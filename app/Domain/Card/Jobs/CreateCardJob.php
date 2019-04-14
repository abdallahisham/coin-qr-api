<?php

namespace App\Domain\Card\Jobs;

use App\Domain\Common\Jobs\JobInterface;
use App\Models\Card;

class CreateCardJob implements JobInterface
{
    protected $amount;

    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    public function handle()
    {
        $card = $this->generateCard($this->amount);

        return CardEntity::fromObject($card);
    }

    private function generateCard($amount)
    {
        $randomNumber = $this->generateRandomNumber();
        try {
            $card = Card::create([
                'amount' => $this->amount,
                'number' => $randomNumber,
            ]);
        } catch (QueryException $e) {
            if ($this->isUniqueException($e)) {
                $this->generateCard($amount);
            }
        }
    }

    private function generateRandomNumber()
    {
        $timeFraction = time() % 10000;
        $randomNumber = rand(11111111111, 99999999999);

        return "{$timeFraction}{$randomNumber}";
    }

    private function isUniqueException($exception)
    {
        return 1062 === $e->getCode();
    }
}
