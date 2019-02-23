<?php

namespace App\Repositories;

use App\Models\Card;
use App\Repositories\Contracts\CardRepository;
use Illuminate\Database\QueryException;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class CardRepositoryEloquent.
 *
 * @package namespace App\Repositories;
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

    public function createCard($amount)
    {
        $randomNumber = time() % 1000 . rand(120232, 999999);
        try {
            $card = $this->create([
                'amount' => $amount,
                'number' => $randomNumber
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() === 1062) {
                $this->createCard($amount);
            }
        }
        return $card;
    }
}
