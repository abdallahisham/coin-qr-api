<?php

namespace Tests\Unit;

use Domain\Transaction\ValueObject\Money;
use Tests\TestCase;

class MoneyTest extends TestCase
{
    /** @test */
    public function it_should_create_money_value()
    {
        $money = new Money(20.5, 'SAR');
        $this->assertEquals(20.5, $money->amount());
        $this->assertEquals('SAR', $money->currency());
        $this->assertEquals((string) $money, '20.50  SAR');
    }
}
