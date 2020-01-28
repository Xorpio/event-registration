<?php
declare(strict_types=1);
if (!defined('WPINC')) define('WPINC', '');

use PHPUnit\Framework\TestCase;
use EventRegistration\Registration\Commands\CreateRegistrationCommand;
use EventRegistration\Registration\RegistrationCommandHandler;

final class RegistrationCreateTest extends TestCase
{
    public function testRegistrationCreateCommandCanBeMade(): void
    {
        //arrange
        $post = [];
        $get = [];

        //act
        $cmd = new CreateRegistrationCommand($get, $post);

        //assert
        $this->assertInstanceOf(CreateRegistrationCommand::class, $cmd);
        //  CreateRegistrationCommand
    }

    public function testHandlerCanBeCreated(): void
    {
        //arrange

        //act
        $handler = new RegistrationCommandHandler();

        //assert
        $this->assertInstanceOf(RegistrationCommandHandler::class, $handler);
    }
}
