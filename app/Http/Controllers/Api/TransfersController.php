<?php

namespace App\Http\Controllers\Api;

use App\Domain\Transaction\CreateTransaction;
use App\Domain\Transaction\TransactionCommandHandler;
use App\Domain\Transaction\TransactionId;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionCreateRequest;
use App\Http\Resources\TransferResource;
use App\Http\Responses\MessageResponse;
use App\Models\Transfer;
use App\User;
use Illuminate\Http\Request;

class TransfersController extends Controller
{
    protected $commandHandler;

    public function __construct(TransactionCommandHandler $commandHandler)
    {
        $this->commandHandler = $commandHandler;
    }

    public function transfer(TransactionCreateRequest $request)
    {
        [$phone, $amount] = $request->prepared();

        $sender = $request->user();
        $receiver = User::where('phone', $phone)->firstOrFail();

        $this->commandHandler->handle(new CreateTransaction(
            TransactionId::create(),
            $sender->id,
            $receiver->id,
            $amount
        ));

        return new MessageResponse('Transferred successfully!');
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
