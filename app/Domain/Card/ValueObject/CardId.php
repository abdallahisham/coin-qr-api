<?php

namespace App\Domain\Card\ValueObject;

use Ramsey\Uuid\Uuid;

/**
 * class CardId.
 * Represent Card identifier.
 */
final class CardId
{
    /**
     * Generate random Uuid.
     *
     * @var string
     */
    private $uuid;

    public function __construct(string $uuid = '')
    {
        $this->uuid = empty($uuid) ? Uuid::uuid4() : $uuid;
    }

    public function __toString()
    {
        return (string) $this->uuid;
    }

    public static function fromString(string $uuid)
    {
        return new static($uuid);
    }
}
