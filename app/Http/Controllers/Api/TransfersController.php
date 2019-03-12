<?php

namespace App\Http\Controllers\Api;

use DB;
use App\User;
use Exception;
use App\Models\Transfer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransferResource;

class TransfersController extends Controller
{
    public function transfer(Request $request)
    {
        $sender = $request->user();
        $phone = request('phone');
        $amount = request('amount');

        $receiver = User::where('phone', $phone)->firstOrFail();

        if ($sender->balance >= $amount) {
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

                return [
                    'httpCode' => 200,
                    'msg' => 'Transferred successfully!',
                ];
            } catch (Exception $e) {
                return [
                    'httpCode' => 500,
                    'msg' => 'Transfer failed, Try again',
                ];
            }
        } else {
            return [
                'httpCode' => 400,
                'msg' => 'You have not enough balance for this operation',
            ];
        }
    }

    public function transactions(Request $request)
    {
        $user = $request->user();
        $transactions = Transfer::with(['sender', 'receiver'])
            ->where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        return TransferResource::collection($transactions);
    }
}
