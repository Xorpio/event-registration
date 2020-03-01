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

                        wp_mail($registration->email, 'Betaald', 'Je hebt betaald! Jee!');
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
