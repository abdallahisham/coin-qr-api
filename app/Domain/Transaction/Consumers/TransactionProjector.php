<?php

namespace App\Domain\Transaction\Consumers;

use App\Domain\Common\JobDispatcher;
use App\Domain\Transaction\Jobs\CreateTransactionJob;
use App\Domain\Transaction\TransactionCreated;
use EventSauce\EventSourcing\Consumer;
use EventSauce\EventSourcing\Message;

class TransactionProjector implements Consumer
{
    protected $dispatcher;

    public function __construct(JobDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function handle(Message $message)
    {
        $event = $message->event();

        if ($event instanceof TransactionCreated) {
            $this->dispatcher->dispatch(new CreateTransactionJob($event));

            return;
        }
    }
}
