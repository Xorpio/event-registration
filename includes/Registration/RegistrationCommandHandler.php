<?php
declare(strict_types=1);
namespace EventRegistration\Registration;

use EventRegistration\Registration\Commands\CreateRegistrationCommand;
use EventRegistration\Registration\Commands\EventNotFoundResult;
use EventRegistration\Registration\Commands\CreateRegistrationResult;
use EventRegistration\Registration\Commands\CreateRegistrationEventResult;
use EventRegistration\Registration\Commands\CreateRegistrationEventResultSucces;
use Valitron\Validator;

if ( ! defined( 'WPINC' ) ) { die; }

class RegistrationCommandHandler
{
    private $wpdb;

    public function __construct(\wpdb $wpdb)
    {
        $this->wpdb = $wpdb;
    }

    public function HandeCreateEvent(CreateRegistrationCommand $cmd): CreateRegistrationResult
    {

        $table = $this->wpdb->prefix.'er_events';
        $event = $this->wpdb->get_row(
            $this->wpdb->prepare("SELECT id, title, slug, price, tax, spectatorPrice FROM {$table}
                WHERE slug = %s",
                $cmd->GetTitle()
        ));

        if ($event === null) {
            return new EventNotFoundResult();
        }

        $res = new CreateRegistrationEventResult();
        $res->SetTitle($event->title);

        if (is_array($cmd->GetPost())) {
            //validate
            $validator = new Validator($cmd->GetPost(), [], 'nl');
            $validator
                ->rule('required', 'firstName')->label('Initialen')
                ->rule('lengthMax', 'firstName', 20)->label('Initialen')

                ->rule('lengthMax', 'surName', 10)->label('Tussenvoegsel')

                ->rule('required', 'lastName')->label('Achternaam')
                ->rule('lengthMax', 'lastName', 100)->label('Achternaam')

                ->rule('required', 'email')->label('Email')
                ->rule('lengthMax', 'email', 255)->label('Email')
                ->rule('email', 'email')->label('Email')

                ->rule('required', 'phone')->label('Telefoon')
                ->rule('lengthMax', 'phone', 20)->label('Telefoon')

                ->rule('required', 'docNr')->label('Document nr')
                ->rule('lengthMax', 'docNr', 20)->label('Document nr')

                ->rule('required', 'voorwaarden')->label('Voorwaarden')

                ->rule('required', 'birthdate')->label('Geboortedatum')
                ->rule('date', 'birthdate')->label('Geboortedatum')
                ->rule('dateBefore', 'birthdate', date('Y-m-d'))->label('Geboortedatum')

                ->rule('required', 'cityOfBirth')->label('Geboorte stad')

                ->rule('required', 'idType')->label('Type identificatie')
                ->rule('in', 'eventType', ['id','driver','passport'])->label('Type identificatie')

                ->rule('required', 'registrationType')->label('Soort registratie')
                ->rule('in', 'eventType', ['spectator','runner'])->label('Soort registratie')
            ;

            //return errors
            if (!$validator->validate()) {
                $res->SetPost($cmd->GetPost());
                $res->SetErrors($validator->errors());
                return $res;
            }

            //store
            $table = $this->wpdb->prefix.'er_registration';
            $data = [
                'eventId' => $event->id,
                'email' => $cmd->GetEmail(),
                'state' => 'registered',
                'registrationDate' => date(\DateTime::W3C),
                'firstName' => $cmd->GetFirstName(),

                'lastName' => $cmd->GetLastName(),
                'surName' => $cmd->GetSurName(),
                'phonenumber' => $cmd->GetPhonenumber(),
                'registrationType' => $cmd->GetRegistrationType()
            ];
            $format = [
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',

                '%s',
                '%s',
                '%s',
                '%s'
            ];
            $this->wpdb->insert($table,$data,$format);
            $registrationId = $this->wpdb->insert_id;

            $table = $this->wpdb->prefix.'er_runner';
            $data = [
                'registrationId' => $registrationId,
                'documentNr' => $cmd->GetDocumentNr(),
                'birthDate' => $cmd->GetBirthDate(),
                'cityOfBirth' => $cmd->GetCityOfBirth(),
                'identificationType' => $cmd->GetIdType(),

                'isRunner' => $cmd->GetIsRunner()
            ];
            $format = [
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',

                '%d'
            ];
            $this->wpdb->insert($table,$data,$format);
            $registrationId = $this->wpdb->insert_id;

            $price = ($cmd->GetIsRunner()) ?
                $event->price:
                $event->spectatorPrice;

            $paymentTable = $this->wpdb->prefix.'er_payment';
            $data = [
                'registrationId' => $registrationId,
                'price' => $price,
                'tax' => $event->tax,
            ];
            $format = [
                '%d',
                '%f',
                '%f',
            ];
            $this->wpdb->insert($paymentTable,$data,$format);

            $mollie = new \Mollie\Api\MollieApiClient();
            $mollie->setApiKey(get_option('er_mollieApiKey'));

            $webhook = get_site_url() . "/api/payment";
            $redirectUrl = get_site_url() . "/payment/success/{$registrationId}";

            $payment = $mollie->payments->create([
                "amount" => [
                    "currency" => "EUR",
                    "value" => $price,
                ],
                "description" => "Inschrijving voor " . $event->title,
                "redirectUrl" => $redirectUrl,
                "webhookUrl"  => $webhook
            ]);

            $this->wpdb->update(
                $paymentTable,
                ['mollieId' => $payment->id],
                ['registrationId' => $registrationId]
            );

            return new CreateRegistrationEventResultSucces($payment->getCheckoutUrl(), $cmd, $event);
        }

        return $res;
    }
}
