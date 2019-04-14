<?php

namespace Tests\Unit;

use App\Domain\Transaction\TransactionId;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class CreateUuidTest extends TestCase
{
    /** @test */
    public function it_should_generate_valid_uuid()
    {
        $uuid = TransactionId::create();

        $this->assertTrue(Uuid::isValid($uuid->toString()));
    }
}
