<?php
declare(strict_types=1);
namespace EventRegistration\Registration\Commands;

use EventRegistration\Registration\Commands\CreateRegistrationCommand;

if ( ! defined( 'WPINC' ) ) { die; }

class CreateRegistrationEventResultSucces implements CreateRegistrationResult
{
    private $cmd;
    private $event;

    public function __construct(string $url, CreateRegistrationCommand $cmd, object $event)
    {
        $this->paymentUrl = $url;
        $this->cmd = $cmd;
        $this->event = $event;
    }

    private $paymentUrl;
    public function GetPaymentUrl(): string
    {
        return $this->paymentUrl;
    }

    public function GetFirstName(): string
    {
        return $this->cmd->GetFirstName();
    }

    public function GetSurName(): string
    {
        return $this->cmd->GetSurName();
    }

    public function GetLastName(): string
    {
        return $this->cmd->GetLastName();
    }

    public function GetBirthDate(): string
    {
        return $this->cmd->GetBirthDate();
    }

    public function GetCityOfBirth(): string
    {
        return $this->cmd->GetCityOfBirth();
    }

    public function GetEmail(): string
    {
        return $this->cmd->GetEmail();
    }

    public function GetPhone(): string
    {
        return $this->cmd->GetPhonenumber();
    }

    public function GetDocumentNr(): string
    {
        return $this->cmd->GetDocumentNr();
    }

    public function GetIdType(): string
    {
        return $this->cmd->GetIdType();
    }

    public function GetPrice(): string
    {
        return ($this->cmd->GetIsRunner()) ?
            $this->event->price:
            $this->event->spectatorPrice;
    }

    public function GetTax(): string
    {
        return $this->event->tax;
    }

    public function GetIsRunner()
    {
        return $this->cmd->GetIsRunner();
    }
}
