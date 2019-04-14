<?php

namespace App\Repositories;

use App\Domain\Card\CardEntity;
use App\Models\Card;
use App\Repositories\Contracts\CardRepository;
use Illuminate\Database\QueryException;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class CardRepositoryEloquent.
 */
class CardRepositoryEloquent extends BaseRepository implements CardRepository
{
    public function model()
    {
        return Card::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function createCard($amount): CardEntity
    {
        $randomNumber = $this->generateRandomNumber();
        try {
            $card = $this->create([
                'amount' => $amount,
                'number' => $randomNumber,
            ]);
        } catch (QueryException $e) {
            // Unigue constraint
            if (1062 === $e->getCode()) {
                $this->createCard($amount);
            }
        }

        return CardEntity::fromObject($card);
    }

    /**
     * Generates random fixed-length number.
     *
     * @return string
     */
    public function generateRandomNumber()
    {
        return time() % 10000 .rand(12020000034, 99999999999);
    }
}
