<?php
declare(strict_types=1);
namespace EventRegistration\Payment;

use EventRegistration\Payment\Commands\CreatePaymentCommand;
use EventRegistration\Payment\Commands\CreatePaymentResult;
use EventRegistration\Payment\Commands\CreatePaymentEventResult;
use EventRegistration\Payment\Commands\PaymentNotFoundResult;
use EventRegistration\Payment\Commands\PaymentFailedResult;
use Valitron\Validator;
use Mollie\Api\Types\PaymentStatus;

if ( ! defined( 'WPINC' ) ) { die; }

class PaymentCommandHandler
{
    private $wpdb;

    public function __construct(\wpdb $wpdb)
    {
        $this->wpdb = $wpdb;
    }

    public function HandeCreateEvent(CreatePaymentCommand $cmd): CreatePaymentResult
    {
        $paymentTable = $this->wpdb->prefix.'er_payment';
        $paymentRecord = $this->wpdb->get_row(
            $this->wpdb->prepare("SELECT status, mollieId FROM {$paymentTable}
                WHERE registrationId = %s",
                $cmd->GetRegistrationId()
        ));

        if ($paymentRecord === null) {
            return new PaymentNotFoundResult();
        }

        $res = new CreatePaymentEventResult();

        switch ($paymentRecord->status) {
            case PaymentStatus::STATUS_OPEN:
            case PaymentStatus::STATUS_PENDING:
            default:
                $mollie = new \Mollie\Api\MollieApiClient();
                $mollie->setApiKey(get_option('er_mollieApiKey'));

                $payment = $mollie->payments->get($paymentRecord->mollieId);

                if ($payment->status != $paymentRecord->status) {
                    $this->wpdb->update(
                        $paymentTable,
                        ['status' => $payment->status],
                        ['registrationId' => $cmd->GetRegistrationId()]
                    );

                    if ($payment->status == PaymentStatus::STATUS_FAILED ||
                        $payment->status == PaymentStatus::STATUS_EXPIRED ||
                        $payment->status == PaymentStatus::STATUS_CANCELED
                    ) {
                        return new PaymentFailedResult();
                    }

                    if ($payment->status == PaymentStatus::STATUS_PAID) {
                        $registration = $this->wpdb->get_row(
                            $this->wpdb->prepare("SELECT email FROM {$this->wpdb->prefix}er_registration
                                WHERE id = %s",
                                $cmd->GetRegistrationId()
                        ));

                        wp_mail($registration->email, 'Vliegbasisloop inschrijving Team 77 Midden Brabant',
'Beste deelnemer,

Bedankt voor je inschrijving. We houden je via dit email adres op de hoogte over het evenement

Het geld wat wordt opgehaald met dit evenement gaat richting stichting Roparun dat geld wordt toegekend aan instellingen, goede doelen of projecten die bijdragen aan de missie van Roparun:

"Leven toevoegen aan de dagen, waar vaak geen dagen meer kunnen worden toegevoegd aan het leven”

Het geld dat wordt opgehaald tijdens het evenement Roparun wordt toegekend aan instellingen, goede doelen of projecten die bijdragen aan het motto van Roparun. Je kunt hierbij denken aan de inrichting van een inloophuis, waar (ex-) kankerpatiënten en/of naasten elkaar kunnen ontmoeten. Vakanties voor mensen met kanker en hun familie zodat zij, ook in een akelige periode, een mooie herinnering kunnen creëren. Workshops in ziekenhuizen waarbij mensen met kanker leren omgaan met uiterlijke veranderingen die ze krijgen door de behandelingen. Een fijne dag uit voor zieke kinderen en hun broertjes of zusjes, zodat zij even niet hoeven te denken aan het ziek zijn. De ontwikkeling van ‘palliatieve boxen’, een hulpmiddel voor mensen in een terminale fase die graag in de eigen thuisomgeving willen verblijven. Of de inrichting van een hospice om er voor te zorgen dat mensen tijdens hun laatste levensfase in een prettige omgeving kunnen verblijven.

Met vriendelijke groet,k
Team 77 Midden Brabant');
                    }
                }

                break;
            case PaymentStatus::STATUS_CANCELED:
            case PaymentStatus::STATUS_EXPIRED:
            case PaymentStatus::STATUS_FAILED:
                return new PaymentFailedResult();
                break;
        }

        return $res;
    }
}
