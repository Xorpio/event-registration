<?php
namespace EventRegistration\Event\Commands;

if ( ! defined( 'WPINC' ) ) { die; }

class CreateEventCommand
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

    private $slots;
    public function GetSlots(): string
    {
        return $this->slots;
    }
    public function SetSlots($slots): self
    {
        $this->slots = $slots;
        return $this;
    }

    private $startRegistrationDate;
    public function GetStartRegistrationDate(): \DateTime
    {
        return $this->startRegistrationDate;
    }
    public function SetStartRegistrationDate(\DateTime $startRegistrationDate): self
    {
        $this->startRegistrationDate = $startRegistrationDate;
        return $this;
    }

    private $endRegistrationDate;
    public function GetEndRegistrationDate(): \DateTime
    {
        return $this->endRegistrationDate;
    }
    public function SetEndRegistrationDate(\DateTime $endRegistrationDate): self
    {
        $this->endRegistrationDate = $endRegistrationDate;
        return $this;
    }

    private $eventDate;
    public function GetEventDate(): \DateTime
    {
        return $this->eventDate;
    }
    public function SetEventDate(\DateTime $eventDate): self
    {
        $this->eventDate = $eventDate;
        return $this;
    }

    private $eventType;
    public function GetEventType(): string
    {
        return $this->eventType;
    }
    public function SetEventType(string $eventType): self
    {
        $this->eventType = $eventType;
        return $this;
    }

    private $price;
    public function GetPrice(): float
    {
        return $this->price;
    }
    public function SetPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    private $spectatorPrice;
    public function GetSpectatorPrice(): float
    {
        return $this->spectatorPrice;
    }
    public function SetSpectatorPrice(float $spectatorPrice): self
    {
        $this->spectatorPrice = $spectatorPrice;
        return $this;
    }

    private $tax;
    public function GetTax(): int
    {
        return $this->tax;
    }
    public function SetTax(int $tax): self
    {
        $this->tax = $tax;
        return $this;
    }

    public function ToArray(): array
    {
        return [
            'endRegistrationDate' => $this->endRegistrationDate,
            'eventDate' => $this->eventDate,
            'eventType' => $this->eventType,
            'price' => $this->price,
            'spectatorPrice' => $this->spectatorPrice,
            'tax' => $this->tax,
            'slots' => $this->slots,
            'startRegistrationDate' => $this->startRegistrationDate,
            'title' => $this->title
        ];
    }
}
