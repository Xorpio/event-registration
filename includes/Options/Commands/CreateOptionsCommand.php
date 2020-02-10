<?php
namespace EventRegistration\Options\Commands;

use EventRegistration\Options\Commands\CreateOptionsCommand;

if ( ! defined( 'WPINC' ) ) { die; }

class CreateOptionsCommand
{
    private $mollieApiKey;
    public function GetMollieApiKey(): string
    {
        return $this->mollieApiKey;
    }
    public function SetMollieApiKey(string $mollieApiKey): self
    {
        $this->mollieApiKey = $mollieApiKey;
        return $this;
    }

    public function ToArray(): array
    {
        return [
            'mollieApiKey' => $this->mollieApiKey,
        ];
    }
}
