<?php
declare(strict_types=1);
namespace EventRegistration\Registration\Commands;

if ( ! defined( 'WPINC' ) ) { die; }

class CreateRegistrationCommand
{
    public function __construct(string $title)
    {
        $this->title = $title;
    }

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
    public function GetPost(): ?array
    {
        return $this->post;
    }
    public function SetPost(array $post): self
    {
        $this->post = $post;
        return $this;
    }

    public function GetEmail(): string
    {
        return $this->post['email'];
    }

    public function GetFirstName(): string
    {
        return $this->post['firstName'];
    }

    public function GetLastName(): string
    {
        return $this->post['lastName'];
    }

    public function GetSurName(): string
    {
        return $this->post['surName'];
    }

    public function GetPhonenumber(): string
    {
        return $this->post['phone'];
    }

    public function GetRegistrationType(): string
    {
        return $this->post['registrationType'];
    }

    public function GetDocumentNr(): string
    {
        return $this->post['docNr'];
    }

    public function GetBirthDate(): string
    {
        return $this->post['birthdate'];
    }

    public function GetCityOfBirth(): string
    {
        return $this->post['cityOfBirth'];
    }

    public function GetIdType(): string
    {
        return $this->post['idType'];
    }

    public function GetIsRunner(): bool
    {
        return $this->post['registrationType'] == 'runner';
    }
}
