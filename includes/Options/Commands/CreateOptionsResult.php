<?php
namespace EventRegistration\Options\Commands;

if ( ! defined( 'WPINC' ) ) { die; }

class CreateOptionsResult
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
