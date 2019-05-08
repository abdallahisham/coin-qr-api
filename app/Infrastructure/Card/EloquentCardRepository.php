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

        $card = CardEntity::fromObject($model);
        $card->setId($model->id);

        return $card;
    }

    public function persist(CardEntity $card): void
    {
        if ($card->getId()) {
            $model = $this->model->findOrFail($card->getId());
        } else {
            $model = new Card();
        }
        $model->number = $card->getNumber();
        $model->amount = $card->getAmount();
        $model->status = $card->getStatus();

        $model->save();
    }

    public function nextCardNumber(): string
    {
        $timeFraction = time() % 10000;
        $randomNumber = rand(11111111111, 99999999999);

        $number = "{$timeFraction}{$randomNumber}";
        if (0 !== $this->model->where('number', $number)->count()) {
            return $this->newCardNumber();
        }

        return $number;
    }
}
