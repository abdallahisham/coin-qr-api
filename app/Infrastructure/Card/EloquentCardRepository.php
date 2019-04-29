<?php

namespace App\Infrastructure\Card;

use App\Domain\Card\CardEntity;
use App\Domain\Card\Repositories\CardRepository;
use App\Models\Card;

class EloquentCardRepository implements CardRepository
{
    protected $model;

    public function __construct(Card $model)
    {
        $this->model = $model;
    }

    public function findByNumber(string $number): CardEntity
    {
        $model = $this->model->where('number', $number)->firstOrFail();

        return CardEntity::fromObject($model);
    }
}