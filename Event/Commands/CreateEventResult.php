<?php
namespace EventRegistration\Event\Commands;

if ( ! defined( 'WPINC' ) ) { die; }

class CreateEventResult
{
    private $sucess;
    public function GetSucess(): bool
    {
        return $this->sucess;
    }

    private $errors;
    public function GetErrors(): array
    {
        return $this->errors;
    }

    public function __construct(bool $sucess, array $errors = null)
    {
        $this->sucess = $sucess;
        $this->errors = $errors;
    }
}
