<?php

namespace App\Domain\Card\Jobs;

use App\Domain\Common\Jobs\JobInterface;
use App\Models\Card;

class CreateCardJob implements JobInterface
{
    protected $amount;
    protected $number;

    public function __construct($amount, $number)
    {
        $this->amount = $amount;
        $this->number = $number;
    }

    public function handle()
    {
        Card::create([
            'amount' => $this->amount,
            'number' => $this->number,
        ]);
    }
}
