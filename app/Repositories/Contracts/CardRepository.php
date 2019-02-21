<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface CardRepository.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface CardRepository extends RepositoryInterface
{
    public function generateCard($amount);
}
