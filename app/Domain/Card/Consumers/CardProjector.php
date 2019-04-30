<?php

namespace App\Domain\Card\Consumers;

use App\Domain\Card\CardCreated;
use App\Domain\Card\CardRecharged;
use App\Domain\Card\Jobs\CreateCardJob;
use App\Domain\Card\Jobs\RechargeCardJob;
use App\Domain\Common\JobDispatcher;
use EventSauce\EventSourcing\Consumer;
use EventSauce\EventSourcing\Message;

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
            $this->dispatcher->dispatch(new CreateCardJob(
                $event->amount(),
                $event->number()
            ));

            return;
        } elseif ($event instanceof CardRecharged) {
            $this->dispatcher->dispatch(new RechargeCardJob(
                $event->number(),
                $event->user()
            ));
        }
    }
}
