<?php

namespace App\Domain\Card\Repositories;

use App\Domain\Card\CardEntity;

interface CardRepository
{
    /**
     * Retieve card by its number.
     *
     * @param string $number
     *
     * @return CardEntity
     */
    public function findByNumber(string $number): CardEntity;

    /**
     * Persists the card into storage.
     *
     * @param CardEntity $card
     */
    public function persist(CardEntity $card): void;

    /**
     * Generates unique new card.
     *
     * @return string - String of unique card number
     */
    public function nextCardNumber(): string;
}
