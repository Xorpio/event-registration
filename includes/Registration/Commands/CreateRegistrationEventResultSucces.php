<?php
declare(strict_types=1);
namespace EventRegistration\Registration\Commands;

if ( ! defined( 'WPINC' ) ) { die; }

class CreateRegistrationEventResultSucces implements CreateRegistrationResult
{
    public function __construct(string $url)
    {
        $this->paymentUrl = $url;
    }

    private $paymentUrl;
    public function GetPaymentUrl(): string
    {
        return $this->paymentUrl;
    }
}
