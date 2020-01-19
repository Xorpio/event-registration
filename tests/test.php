<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use EventRegistration\Event\Queries\ListEventQuery;

final class EmailTest extends TestCase
{
    public function testCanBeCreatedFromValidEmailAddress(): void
    {
        $var = new ListEventQuery();

        $this->assertTrue(true);
    }
}
