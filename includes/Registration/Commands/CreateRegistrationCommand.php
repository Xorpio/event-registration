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
}
