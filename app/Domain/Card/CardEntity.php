<?php

namespace App\Domain\Card;

final class CardEntity
{
    private $amount;
    private $number;
    private $status;

    public function __construct($amount, $number, $status = 0)
    {
        $this->amount = $amount;
        $this->number = $number;
        $this->status = $status;
    }

    public static function fromObject($object)
    {
        $card = new self();
        $card->setAmount($object->amount);
        $card->setNumber($object->number);
        $card->setStatus($object->status);

        return $card;
    }

    public static function fromArray(array $data)
    {
        $card = new self();
        $card->setAmount($data['amount']);
        $card->setNumber($data['number']);
        $card->setStatus($data['status']);

        return $card;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function setNumber($number)
    {
        $this->number = $number;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }
}
