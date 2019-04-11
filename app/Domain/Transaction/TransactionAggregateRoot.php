<?php

namespace App\Domain\Transaction;

use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour;
use Spatie\LaravelEventSauce\Concerns\IgnoresMissingMethods;

class TransactionAggregateRoot implements AggregateRoot
{
    use AggregateRootBehaviour, IgnoresMissingMethods;

    public function createTransaction(CreateTransaction $command)
    {
        $this->recordThat(new TransactionCreated(
            $command->id(),
            $command->sender(),
            $command->receiver(),
            $command->amount()
        ));
    }

    public function applyTransactionCreated(TransactionCreated $event)
    {
        // Do nothing for now
    }
}
