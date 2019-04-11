<?php

namespace Tests\Unit;

use App\Domain\Transaction\TransactionId;
use Tests\TestCase;

class CreateUuidTest extends TestCase
{
    /** @test */
    public function it_should_generate_valid_uuid()
    {
        $uuid = TransactionId::create();

        $this->assertEquals(5, count(explode('-', (string) $uuid)));
    }
}
