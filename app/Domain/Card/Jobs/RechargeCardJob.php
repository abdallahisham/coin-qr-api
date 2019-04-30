<?php

namespace App\Domain\Card\Jobs;

use App\Domain\Card\Repositories\CardRepository;
use App\Domain\Common\Jobs\JobInterface;
use App\User;

class RechargeCardJob implements JobInterface
{
    protected $number;
    protected $user;

    public function __construct($number, $user)
    {
        $this->number = $number;
        $this->user = $user;
    }

    public function handle()
    {
        $cardRepository = app(CardRepository::class);
        $user = User::findOrFail($this->user);
        $card = $cardRepository->findByNumber($this->number);

        $user->balance += $card->getAmount();
        $user->save();
        $card->setStatus(1);
        $cardRepository->persist($card);
    }
}
