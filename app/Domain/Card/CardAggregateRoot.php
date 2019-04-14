<?php

namespace App\Domain\Card;

use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour;
use Spatie\LaravelEventSauce\Concerns\IgnoresMissingMethods;

class CardAggregateRoot implements AggregateRoot
{
    use AggregateRootBehaviour, IgnoresMissingMethods;

    public function createCard(CreateCard $command)
    {
        $this->recordThat(new CardCreated(
            $command->id(),
            $command->amount(),
            $command->type()
        ));
    }

    public function applyCardCreated(CardCreated $event)
    {
        // Do nothing for now
    }
}
