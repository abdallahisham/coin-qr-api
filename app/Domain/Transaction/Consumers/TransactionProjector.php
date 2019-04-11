<?php

namespace App\Domain\Transaction\Consumers;

use App\Domain\Transaction\Exceptions\TransactionNotCompleted;
use App\Domain\Transaction\TransactionCreated;
use App\Models\Transfer;
use App\User;
use EventSauce\EventSourcing\Consumer;
use EventSauce\EventSourcing\Message;
use Illuminate\Support\Facades\DB;

class TransactionProjector implements Consumer
{
    public function handle(Message $message)
    {
        $event = $message->event();

        $id = $event->id();

        $sender = User::findOrFail($event->sender());
        $receiver = User::findOrFail($event->receiver());
        $amount = $event->amount();

        if ($event instanceof TransactionCreated) {
            if ($sender->canTransfer($amount)) {
                try {
                    DB::transaction(function () use ($sender, $receiver, $amount) {
                        // Sub the amount from sender balance and put it on suspended balance
                        $sender->refresh();
                        $sender->balance -= $amount;
                        $sender->suspended_balance += $amount;
                        $sender->save();

                        // Start a new transfer operation
                        $transfer = new Transfer(['amount' => $amount]);
                        $transfer->sender_id = $sender->id;
                        $transfer->receiver_id = $receiver->id;
                        // Add the amount to receiver balance
                        $receiver->refresh();
                        $receiver->balance += $amount;
                        $receiver->save();
                        // Sub the amount from suspended balance of sender
                        $sender->suspended_balance -= $amount;
                        $sender->save();
                        // Finally save the transfer operation
                        $transfer->status = 1;
                        $transfer->save();
                    });
                } catch (Exception $e) {
                    throw TransactionNotCompleted::internalError();
                }
            } else {
                throw TransactionNotCompleted::notEnoughBalance();
            }

            $transaction = new Transfer();
            $transaction->sender_id = $event->sender();
            $transaction->receiver_id = $event->receiver();
            $transaction->amount = $event->amount();
            $transaction->save();

            return;
        }
    }
}
