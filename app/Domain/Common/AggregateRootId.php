<?php

namespace App\Domain\Common;

use EventSauce\EventSourcing\AggregateRootId as AggregateRootIdContract;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class AggregateRootId implements AggregateRootIdContract
{
    /** @var \Ramsey\Uuid\UuidInterface */
    protected $id;

    public function __construct(UuidInterface $id)
    {
        $this->id = $id;
    }

    public function toString(): string
    {
        return $this->id->toString();
    }

    public static function fromString(string $aggregateRootId): AggregateRootIdContract
    {
        return new static(Uuid::fromString($aggregateRootId));
    }

    public static function create(): self
    {
        return self::fromString((string) Uuid::uuid4());
    }
}
