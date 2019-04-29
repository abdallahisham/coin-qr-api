<?php

namespace App\Domain\Card;

use EventSauce\EventSourcing\Serialization\SerializableEvent;

final class CardCreated implements SerializableEvent
{
    /**
     * @var CardId
     */
    private $id;

    /**
     * @var string
     */
    private $amount;

    /**
     * @var string
     */
    private $number;

    public function __construct(
        CardId $id,
        string $amount,
        string $number
    ) {
        $this->id = $id;
        $this->amount = $amount;
        $this->number = $number;
    }

    public function id(): CardId
    {
        return $this->id;
    }

    public function amount(): string
    {
        return $this->amount;
    }

    public function number(): string
    {
        return $this->number;
    }
    public static function fromPayload(array $payload): SerializableEvent
    {
        return new CardCreated(
            CardId::fromString($payload['id']),
            (string) $payload['amount'],
            (string) $payload['number']);
    }

    public function toPayload(): array
    {
        return [
            'id' => $this->id->toString(),
            'amount' => (string) $this->amount,
            'number' => (string) $this->number,
        ];
    }

    /**
     * @codeCoverageIgnore
     */
    public static function withIdAndAmountAndNumber(CardId $id, string $amount, string $number): CardCreated
    {
        return new CardCreated(
            $id,
            $amount,
            $number
        );
    }
}

final class CardRecharged implements SerializableEvent
{
    /**
     * @var CardId
     */
    private $id;

    /**
     * @var string
     */
    private $number;

    /**
     * @var string
     */
    private $user;

    public function __construct(
        CardId $id,
        string $number,
        string $user
    ) {
        $this->id = $id;
        $this->number = $number;
        $this->user = $user;
    }

    public function id(): CardId
    {
        return $this->id;
    }

    public function number(): string
    {
        return $this->number;
    }

    public function user(): string
    {
        return $this->user;
    }
    public static function fromPayload(array $payload): SerializableEvent
    {
        return new CardRecharged(
            CardId::fromString($payload['id']),
            (string) $payload['number'],
            (string) $payload['user']);
    }

    public function toPayload(): array
    {
        return [
            'id' => $this->id->toString(),
            'number' => (string) $this->number,
            'user' => (string) $this->user,
        ];
    }

    /**
     * @codeCoverageIgnore
     */
    public static function withIdAndNumberAndUser(CardId $id, string $number, string $user): CardRecharged
    {
        return new CardRecharged(
            $id,
            $number,
            $user
        );
    }
}

final class CreateCard
{
    /**
     * @var CardId
     */
    private $id;

    /**
     * @var string
     */
    private $amount;

    /**
     * @var string
     */
    private $number;

    public function __construct(
        CardId $id,
        string $amount,
        string $number
    ) {
        $this->id = $id;
        $this->amount = $amount;
        $this->number = $number;
    }

    public function id(): CardId
    {
        return $this->id;
    }

    public function amount(): string
    {
        return $this->amount;
    }

    public function number(): string
    {
        return $this->number;
    }
}

final class RechargeCard
{
    /**
     * @var CardId
     */
    private $id;

    /**
     * @var string
     */
    private $number;

    /**
     * @var string
     */
    private $user;

    public function __construct(
        CardId $id,
        string $number,
        string $user
    ) {
        $this->id = $id;
        $this->number = $number;
        $this->user = $user;
    }

    public function id(): CardId
    {
        return $this->id;
    }

    public function number(): string
    {
        return $this->number;
    }

    public function user(): string
    {
        return $this->user;
    }
}
