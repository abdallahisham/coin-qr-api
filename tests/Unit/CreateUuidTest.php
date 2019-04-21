<?php

namespace Tests\Unit;

use App\Domain\Common\AggregateRootId;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class CreateUuidTest extends TestCase
{
    /** @test */
    public function it_should_generate_valid_uuid()
    {
        $uuid = AggregateRootId::create();

        $this->assertTrue(Uuid::isValid($uuid->toString()));
    }
}
