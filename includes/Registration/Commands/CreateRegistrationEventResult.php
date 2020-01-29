<?php
declare(strict_types=1);
namespace EventRegistration\Registration\Commands;

if ( ! defined( 'WPINC' ) ) { die; }

class CreateRegistrationEventResult implements CreateRegistrationResult
{
    private $title;
    public function GetTitle(): string
    {
        return $this->title;
    }
    public function SetTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    private $post;
    public function GetPost(): array
    {
        return $this->post;
    }
    public function SetPost(array $post): self
    {
        $this->post = $post;
        return $this;
    }

    private $errors;
    public function GetErrors(): ?array
    {
        return $this->errors;
    }
    public function SetErrors(array $errors): self
    {
        $this->errors = $errors;
        return $this;
    }

    public function GetValue(string $key): string
    {
        if (is_array($this->post) && isset($this->post[$key])) {
            return $this->post[$key];
        }

        return "";
    }

    public function GetClass(string $key): string
    {
        // print_pre(!is_array($this->post));
        if (!is_array($this->post)) {
            return "";
        }

        return (isset($this->errors[$key])) ?
            "is-invalid":
            "is-valid";
    }
}
