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
    private $type;

    public function __construct(
        CardId $id,
        string $amount,
        string $type
    ) {
        $this->id = $id;
        $this->amount = $amount;
        $this->type = $type;
    }

    public function id(): CardId
    {
        return $this->id;
    }

    public function amount(): string
    {
        return $this->amount;
    }

    public function type(): string
    {
        return $this->type;
    }
    public static function fromPayload(array $payload): SerializableEvent
    {
        return new CardCreated(
            CardId::fromString($payload['id']),
            (string) $payload['amount'],
            (string) $payload['type']);
    }

    public function toPayload(): array
    {
        return [
            'id' => $this->id->toString(),
            'amount' => (string) $this->amount,
            'type' => (string) $this->type,
        ];
    }

    /**
     * @codeCoverageIgnore
     */
    public static function withIdAndAmountAndType(CardId $id, string $amount, string $type): CardCreated
    {
        return new CardCreated(
            $id,
            $amount,
            $type
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
    private $type;

    public function __construct(
        CardId $id,
        string $amount,
        string $type
    ) {
        $this->id = $id;
        $this->amount = $amount;
        $this->type = $type;
    }

    public function id(): CardId
    {
        return $this->id;
    }

    public function amount(): string
    {
        return $this->amount;
    }

    public function type(): string
    {
        return $this->type;
    }
}
