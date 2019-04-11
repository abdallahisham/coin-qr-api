<?php

namespace App\Domain\Transaction;

use EventSauce\EventSourcing\Serialization\SerializableEvent;

final class TransactionCreated implements SerializableEvent
{
    /**
     * @var TransactionId
     */
    private $id;

    /**
     * @var string
     */
    private $sender;

    /**
     * @var string
     */
    private $receiver;

    /**
     * @var string
     */
    private $amount;

    public function __construct(
        TransactionId $id,
        string $sender,
        string $receiver,
        string $amount
    ) {
        $this->id = $id;
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->amount = $amount;
    }

    public function id(): TransactionId
    {
        return $this->id;
    }

    public function sender(): string
    {
        return $this->sender;
    }

    public function receiver(): string
    {
        return $this->receiver;
    }

    public function amount(): string
    {
        return $this->amount;
    }
    public static function fromPayload(array $payload): SerializableEvent
    {
        return new TransactionCreated(
            TransactionId::fromString($payload['id']),
            (string) $payload['sender'],
            (string) $payload['receiver'],
            (string) $payload['amount']);
    }

    public function toPayload(): array
    {
        return [
            'id' => $this->id->toString(),
            'sender' => (string) $this->sender,
            'receiver' => (string) $this->receiver,
            'amount' => (string) $this->amount,
        ];
    }

    /**
     * @codeCoverageIgnore
     */
    public static function withIdAndSenderAndReceiverAndAmount(TransactionId $id, string $sender, string $receiver, string $amount): TransactionCreated
    {
        return new TransactionCreated(
            $id,
            $sender,
            $receiver,
            $amount
        );
    }
}

final class CreateTransaction
{
    /**
     * @var TransactionId
     */
    private $id;

    /**
     * @var string
     */
    private $sender;

    /**
     * @var string
     */
    private $receiver;

    /**
     * @var string
     */
    private $amount;

    public function __construct(
        TransactionId $id,
        string $sender,
        string $receiver,
        string $amount
    ) {
        $this->id = $id;
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->amount = $amount;
    }

    public function id(): TransactionId
    {
        return $this->id;
    }

    public function sender(): string
    {
        return $this->sender;
    }

    public function receiver(): string
    {
        return $this->receiver;
    }

    public function amount(): string
    {
        return $this->amount;
    }
}
