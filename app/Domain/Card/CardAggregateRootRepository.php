<?php

namespace App\Domain\Card;

use App\Domain\Card\Consumers\CardProjector;
use Spatie\LaravelEventSauce\AggregateRootRepository;

/** @method \App\Domain\Card\CardAggregateRoot retrieve */
class CardAggregateRootRepository extends AggregateRootRepository
{
    /** @var string */
    protected $aggregateRoot = CardAggregateRoot::class;

    /** @var string */
    protected $tableName = 'card_aggregate_root_domain_messages';

    /** @var array */
    protected $consumers = [
        CardProjector::class,
    ];

    /** @var array */
    protected $queuedConsumers = [
    ];
}
