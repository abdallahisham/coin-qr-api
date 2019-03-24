<?php

namespace App\Domain\Card\Entity;

use App\Domain\Card\ValueObject\CardId;
use App\Domain\Generic\ValueObject\Money;

/**
 * class Card.
 * Represents entity for Card.
 */
class Card
{
    /**
     * Card unique id.
     *
     * @var CardId
     */
    protected $id;
    /**
     * The money that the card hold.
     *
     * @var Money
     */
    protected $money;
    /**
     * The card unique number.
     *
     * @var Amount
     */
    protected $number;
    /**
     *Determine if this card is used or not.
     *
     * @var bool
     */
    protected $status;

    public function __construct(Money $money, string $number, bool $status = false)
    {
        $this->id = new CardId();
        $this->money = $money;
        $this->number = $number;
        $this->status = $status;
    }

    public function id()
    {
        return (string) $this->id;
    }

    public function money()
    {
        return $this->money;
    }

    public function number()
    {
        return $this->number;
    }

    public function status()
    {
        return $this->status;
    }

    public function setId(string $uuid)
    {
        $this->id = CardId::fromString($uuid);
    }

    public function setMoney(Money $money)
    {
        $this->money = $money;
    }
}
