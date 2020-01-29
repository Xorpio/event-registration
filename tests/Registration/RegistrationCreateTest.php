<?php
declare(strict_types=1);
if (!defined('WPINC')) define('WPINC', '');

use PHPUnit\Framework\TestCase;
use EventRegistration\Registration\Commands\CreateRegistrationCommand;
use EventRegistration\Registration\Commands\EventNotFoundResult;
use EventRegistration\Registration\RegistrationCommandHandler;

final class RegistrationCreateTest extends TestCase
{
    public function testRegistrationCreateCommandCanBeMade(): void
    {
        //arrange
        $title = 'a';

        //act
        $cmd = new CreateRegistrationCommand($title);

        //assert
        $this->assertInstanceOf(CreateRegistrationCommand::class, $cmd);
        //  CreateRegistrationCommand
    }

    public function testHandlerCanBeCreated(): void
    {
        //arrange

        //act
        $wpdb = $this->createStub(\wpdb::class);
        $handler = new RegistrationCommandHandler($wpdb);

        //assert
        $this->assertInstanceOf(RegistrationCommandHandler::class, $handler);
    }

    public function testHandlerCanHandleCmd(): void
    {
        //arrange
        $wpdb = $this->createStub(\wpdb::class);
        $handler = new RegistrationCommandHandler($wpdb);
        $cmd = new CreateRegistrationCommand('test');

        //act
        $response = $handler->HandeCreateEvent($cmd);

        //assert
        $this->assertIsObject($response);
    }

    public function testEventCannotBeFound(): void
    {
        //arrange
        $eventName = 'abc';
        $cmd = new CreateRegistrationCommand($eventName, []);

        $wpdb = $this->createStub(\wpdb::class);
        $wpdb->method('get_row')
            ->willReturn(null);

        $handler = new RegistrationCommandHandler($wpdb);

        //act
        $response = $handler->HandeCreateEvent($cmd);

        //assert
        $this->assertInstanceOf(EventNotFoundResult::class, $response);
    }
}
