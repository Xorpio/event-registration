<?php
declare(strict_types=1);
namespace EventRegistration\Payment;

use EventRegistration\Payment\Commands\CreatePaymentCommand;
use EventRegistration\Payment\Commands\EventNotFoundResult;
use EventRegistration\Payment\Commands\CreatePaymentResult;
use EventRegistration\Payment\Commands\CreatePaymentEventResult;
use EventRegistration\Payment\Commands\CreatePaymentEventResultSucces;
use Valitron\Validator;

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

        $table = $this->wpdb->prefix.'er_payments';
        $payment = $this->wpdb->get_row(
            $this->wpdb->prepare("SELECT status, mollieId FROM {$table}
                WHERE registrationId = %s",
                $cmd->GetRegistrationId()
        ));

        if ($payment === null) {
            return new PaymentNotFoundResult();
        }

        $res = new CreatePaymentEventResult();

        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey(get_option('er_mollieApiKey'));

        // $payment = $mollie->payments->create([
        //     "amount" => [
        //         "currency" => "EUR",
        //         "value" => "10.00"
        //     ],
        //     "description" => "My first API payment",
        //     "redirectUrl" => $redirectUrl,
        //     "webhookUrl"  => $webhook
        // ]);

        // $this->wpdb->update(
        //     $paymentTable,
        //     ['mollieId' => $payment->id],
        //     ['registrationId' => $registrationId]
        // );

        return $res;
    }
}
