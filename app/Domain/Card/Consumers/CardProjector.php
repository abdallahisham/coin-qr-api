<?php

namespace App\Domain\Card\Consumers;

use App\Domain\Card\CardCreated;
use App\Domain\Common\JobDispatcher;
use EventSauce\EventSourcing\Consumer;

class CardProjector implements Consumer
{
    protected $dispatcher;

    public function __construct(JobDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function handle(Message $message)
    {
        $event = $message->event();

        if ($event instanceof CardCreated) {
            $this->dispatcher->dispatch(new CreateCard($event->amount(), $event->number()));

            return;
        } elseif ($event) {
        }
    }
}
