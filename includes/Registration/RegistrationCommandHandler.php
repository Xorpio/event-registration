<?php
declare(strict_types=1);
namespace EventRegistration\Registration;

use EventRegistration\Registration\Commands\CreateRegistrationCommand;
use EventRegistration\Registration\Commands\EventNotFoundResult;
use EventRegistration\Registration\Commands\CreateRegistrationResult;
use EventRegistration\Registration\Commands\CreateRegistrationEventResult;
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
            $this->wpdb->prepare("SELECT title FROM {$table}
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
                ->rule('required', 'initials')->label('Initialen')
                ->rule('lengthMax', 'initials', 20)->label('Initialen')

                ->rule('lengthMax', 'surname', 10)->label('Tussenvoegsel')

                ->rule('required', 'lastname')->label('Achternaam')
                ->rule('lengthMax', 'lastname', 100)->label('Achternaam')

                ->rule('required', 'email')->label('Email')
                ->rule('lengthMax', 'email', 255)->label('Email')
                ->rule('email', 'email')->label('Email')

                ->rule('required', 'phone')->label('Telefoon')
                ->rule('lengthMax', 'phone', 20)->label('Telefoon')

                ->rule('required', 'docNr')->label('Document nr')
                ->rule('lengthMax', 'docNr', 20)->label('Document nr')

                ->rule('required', 'voorwaarden')->label('Voorwaarden')
            ;
            //  Ik ga akkoord met de voorwaarden

            //return errors
            if (!$validator->validate()) {
                $res->SetPost($cmd->GetPost());
                $res->SetErrors($validator->errors());
            }

            //store

            //return succes
        }

        // $res->SetPost([]);

        return $res;
    }
}
