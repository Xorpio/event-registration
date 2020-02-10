<?php
declare(strict_types=1);
namespace EventRegistration\Payment\Commands;

if ( ! defined( 'WPINC' ) ) { die; }

class CreatePaymentCommand
{
    private $registrationId;
    public function GetRegistrationId(): string
    {
        return $this->registrationId;
    }
    public function SetRegistrationId(string $registrationId): self
    {
        $this->registrationId = $registrationId;
        return $this;
    }
}
