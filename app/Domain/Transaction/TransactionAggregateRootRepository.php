<?php

namespace App\Domain\Transaction;

use Spatie\LaravelEventSauce\AggregateRootRepository;

/** @method \App\Domain\Transaction\TransactionAggregateRoot retrieve */
class TransactionAggregateRootRepository extends AggregateRootRepository
{
    /** @var string */
    protected $aggregateRoot = TransactionAggregateRoot::class;

    /** @var string */
    protected $tableName = 'transaction_aggregate_root_domain_messages';

    /** @var array */
    protected $consumers = [
    ];

    /** @var array */
    protected $queuedConsumers = [
    ];
}
