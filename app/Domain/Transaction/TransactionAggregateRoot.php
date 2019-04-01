<?php

namespace App\Domain\Transaction;

use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour;
use Spatie\LaravelEventSauce\Concerns\IgnoresMissingMethods;

class TransactionAggregateRoot implements AggregateRoot
{
    use AggregateRootBehaviour,
        IgnoresMissingMethods;
}
