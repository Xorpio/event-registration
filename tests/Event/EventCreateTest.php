<?php
declare(strict_types=1);
define('WPINC', '');

use PHPUnit\Framework\TestCase;
use EventRegistration\Event\Commands\CreateEventCommand;
use EventRegistration\Event\Commands\CreateEventResult;
use EventRegistration\Event\EventCommandHandler;

final class EventCreateTest extends TestCase
{
    public function testEventCreateCommandCreated(): void
    {
        //arrange

        //act
        $command = new CreateEventCommand();

        //assert
        $this->assertInstanceOf(CreateEventCommand::class, $command);
    }

    public function testThatTitleCanBeSet()
    {
        //arrange
        $command = new CreateEventCommand();
        $text = "Dit is mijn titel";

        //act
        $command->SetTitle($text);

        //assert
        $this->assertEquals("Dit is mijn titel", $command->GetTitle());
    }

    public function testThatSlotsCanBeSet ()
    {
        //arrange
        $cmd = new CreateEventCommand();
        $slots = 50;

        //act
        $cmd->SetSlots($slots);

        //assert
        $this->assertEquals(50, $cmd->GetSlots());
    }

    public function testThatStartRegistrationDateCanBeSet ()
    {
        //arrange
        $cmd = new CreateEventCommand();
        $startRegistrationDate = new \DateTime();

        //act
        $cmd->SetStartRegistrationDate($startRegistrationDate);

        //assert
        $this->assertEquals($startRegistrationDate, $cmd->GetStartRegistrationDate());
    }

    public function testThatEndRegistrationDateCanBeSet ()
    {
        //arrange
        $cmd = new CreateEventCommand();
        $endRegistrationDate = new DateTime();

        //act
        $cmd->SetEndRegistrationDate($endRegistrationDate);

        //assert
        $this->assertEquals($endRegistrationDate, $cmd->GetEndRegistrationDate());
    }

    public function testThatEventDateCanBeSet ()
    {
        //arrange
        $cmd = new CreateEventCommand();
        $eventDate = new \DateTime();

        //act
        $cmd->SetEventDate($eventDate);

        //assert
        $this->assertEquals($eventDate, $cmd->GetEventDate());
    }

    public function testThatEventTypeCanBeSet ()
    {
        //arrange
        $cmd = new CreateEventCommand();
        $eventType = "run";

        //act
        $cmd->SetEventType($eventType);

        //assert
        $this->assertEquals("run", $cmd->GetEventType());
    }

    public function testThatPriceCanBeSet ()
    {
        //arrange
        $cmd = new CreateEventCommand();
        $price = 125.21;

        //act
        $cmd->SetPrice($price);

        //assert
        $this->assertEquals(125.21, $cmd->GetPrice());
    }

    public function testThatTaxCanBeSet ()
    {
        //arrange
        $cmd = new CreateEventCommand();
        $tax = 50;

        //act
        $cmd->SetTax($tax);

        //assert
        $this->assertEquals(50, $cmd->GetTax());
    }

    public function testTitleMustBeSet()
    {
        //arrange
        $cmd = new CreateEventCommand();
        $cmd->SetEndRegistrationDate(new \DateTime())
            ->SetEventDate(new \DateTime())
            ->SetEventType("run")
            ->SetPrice(0)
            ->SetTax(0)
            ->SetSlots(1)
            ->SetStartRegistrationDate(new \DateTime())
        ;

        $wpdb = $this->createStub(\wpdb::class);
        $cmdHandler = new EventCommandHandler($wpdb);

        //act
        $cmdResult = $cmdHandler->HandeCreateEvent($cmd);

        //assert
        $this->assertInstanceOf(CreateEventResult::class, $cmdResult);
        $this->assertIsArray($cmdResult->GetErrors());
        $this->assertEquals("Titel is verplicht",$cmdResult->GetErrors()['title'][0]);
    }

    public function testToArray()
    {
        $date1 = \DateTime::createFromFormat("Y-m-d", "2020-01-01");
        $date2 = \DateTime::createFromFormat("Y-m-d", "2020-02-01");
        $date3 = \DateTime::createFromFormat("Y-m-d", "2020-01-02");

        //arrange
        $cmd = new CreateEventCommand();
        $cmd->SetEndRegistrationDate($date1)
            ->SetEventDate($date2)
            ->SetEventType("run")
            ->SetPrice(0)
            ->SetTax(0)
            ->SetSlots(1)
            ->SetStartRegistrationDate($date3)
            ->SetTitle("test");
        ;

        //act
        $array = $cmd->ToArray();

        //assert
        $this->assertEquals([
            'endRegistrationDate' => $date1,
            'eventDate' => $date2,
            'eventType' => "run",
            'price' => 0,
            'tax' => 0,
            'slots' => 1,
            'startRegistrationDate' => $date3,
            'title' => 'test'
        ], $array);
    }

    public function testTitleMustBeMax50()
    {
        //arrange
        $cmd = new CreateEventCommand();
        $cmd->SetEndRegistrationDate(new \DateTime())
            ->SetEventDate(new \DateTime())
            ->SetEventType("run")
            ->SetPrice(0)
            ->SetTax(0)
            ->SetSlots(1)
            ->SetTitle('$wpdb = $this->createStub(\wpdb::class);$cmdHandlea')
            ->SetStartRegistrationDate(new \DateTime())
        ;

        $wpdb = $this->createStub(\wpdb::class);
        $cmdHandler = new EventCommandHandler($wpdb);

        //act
        $cmdResult = $cmdHandler->HandeCreateEvent($cmd);

        //assert
        $this->assertInstanceOf(CreateEventResult::class, $cmdResult);
        $this->assertIsArray($cmdResult->GetErrors());
        $this->assertEquals("Titel mag niet meer dan 50 karakters lang zijn",$cmdResult->GetErrors()['title'][0]);
    }
}
