<?php

namespace App\Domain\Transaction\Jobs;

use App\Domain\Common\Jobs\JobInterface;
use App\Domain\Transaction\Exceptions\TransactionNotCompleted;
use App\Models\Transfer;
use App\User;
use Exception;
use DB;

class CreateTransactionJob implements JobInterface
{
    protected $event;

    public function __construct($event)
    {
        $this->event = $event;
    }

    public function handle()
    {
        $sender = User::findOrFail($this->event->sender());
        $receiver = User::findOrFail($this->event->receiver());
        $amount = $this->event->amount();

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
        $transaction->sender_id = $sender->id;
        $transaction->receiver_id = $receiver->id;
        $transaction->amount = $amount;
        $transaction->save();
    }
}
