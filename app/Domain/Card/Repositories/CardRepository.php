<?php

namespace App\Domain\Card\Repositories;

use App\Domain\Card\CardEntity;

interface CardRepository
{
    public function findByNumber(string $number): CardEntity;
}
