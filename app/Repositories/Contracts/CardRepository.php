<?php

namespace App\Repositories\Contracts;

use App\Domain\Card\CardEntity;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface CardRepository.
 */
interface CardRepository extends RepositoryInterface
{
    public function createCard($amount): CardEntity;
}
