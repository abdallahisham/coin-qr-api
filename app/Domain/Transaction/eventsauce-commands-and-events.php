<?php

namespace App\Domain\Transaction;

use EventSauce\EventSourcing\Serialization\SerializableEvent;

final class TransactionCreated implements SerializableEvent
{
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

    /**
     * @var string
     */
    private $type;

    public function __construct(
        string $sender,
        string $receiver,
        string $amount,
        string $type
    ) {
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->amount = $amount;
        $this->type = $type;
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

    public function type(): string
    {
        return $this->type;
    }
    public static function fromPayload(array $payload): SerializableEvent
    {
        return new TransactionCreated(
            (string) $payload['sender'],
            (string) $payload['receiver'],
            (string) $payload['amount'],
            (string) $payload['type']);
    }

    public function toPayload(): array
    {
        return [
            'sender' => (string) $this->sender,
            'receiver' => (string) $this->receiver,
            'amount' => (string) $this->amount,
            'type' => (string) $this->type,
        ];
    }

    /**
     * @codeCoverageIgnore
     */
    public function withSender(string $sender): TransactionCreated
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public function withReceiver(string $receiver): TransactionCreated
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public function withAmount(string $amount): TransactionCreated
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public function withType(string $type): TransactionCreated
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public static function with(): TransactionCreated
    {
        return new TransactionCreated(
            (string) 'example-user',
            (string) 'list-name',
            (string) 'list-name',
            (string) 'list-name'
        );
    }
}

final class CreateTransaction
{
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

    /**
     * @var string
     */
    private $type;

    public function __construct(
        string $sender,
        string $receiver,
        string $amount,
        string $type
    ) {
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->amount = $amount;
        $this->type = $type;
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

    public function type(): string
    {
        return $this->type;
    }
}
