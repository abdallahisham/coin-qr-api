<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Domain\Card\Entity\Card;
use App\Domain\Generic\ValueObject\Money;

class CardTest extends TestCase
{
    /** @test */
    public function it_should_create_new_card()
    {
        $randomNumber = time() % 100000 .rand(12456, 99999);
        $card = new Card(
            new Money(100, 'SAR'),
            $randomNumber
        );

        $this->assertEquals((string) $card->money(), '100.00  SAR');
        $this->assertEquals($card->number(), $randomNumber);
        $this->assertFalse($card->status());
        // Insure that id is uuid (e.g: xxxx-xxxx-xxxx-xxxx-xxxx, has 5 tokens)
        $this->assertCount(5, explode('-', (string) $card->id()));
    }
}
