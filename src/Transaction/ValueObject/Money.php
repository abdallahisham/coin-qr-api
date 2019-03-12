<?php

namespace Domain\Transaction\ValueObject;

/**
 * class Amount.
 * Represents the Money.
 */
final class Money
{
    private $amount;
    private $currency;

    public function __construct($amount, $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function amount()
    {
        return $this->amount;
    }

    public function currency()
    {
        return $this->currency;
    }

    public function __toString()
    {
        $amountFormatted = number_format($this->amount, 2);

        return "{$amountFormatted}  {$this->currency}";
    }
}
