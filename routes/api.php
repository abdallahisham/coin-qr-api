<?php

use App\Card;
use App\User;
use App\Transfer;
use Illuminate\Http\Request;

Route::middleware('auth:api')->post('/user', function (Request $request) {
    return $request->user();
});

Route::post('generate-card', 'CardsController@create');

Route::middleware('auth:api')->post('recharge', function () {
    $number = request('number');
    $card = Card::where('number', $number)->first();
    $user = request()->user();
    if (0 == $card->status) {
        $user->balance += $card->amount;
        $user->save();
        $card->status = 1;
        $card->save();

        return [
            'httpCode' => 200,
            'msg' => 'Card charged successfully',
        ];
    } else {
        return [
            'httpCode' => 403,
            'msg' => 'Sorry, This card is already entered',
        ];
    }
});

Route::middleware('auth:api')->post('users', function () {
    $users = User::all();

    return $users->toArray();
});

Route::middleware('auth:api')->post('transfer', function () {
    $sender = request()->user();
    $phone = request('phone');
    $amount = request('amount');

    $receiver = User::where('phone', $phone)->firstOrFail();

    if ($sender->balance >= $amount) {
        $transfer = new Transfer(['amount' => $amount]);
        $transfer->sender_id = $sender->id;
        $transfer->receiver_id = $receiver->id;
        $transfer->save();
        $sender->balance -= $amount;
        $sender->suspended_balance += $amount;
        $sender->save();

        return [
            'httpCode' => 200,
            'msg' => 'Transferred successfully',
        ];
    } else {
        return [
            'httpCode' => 400,
            'msg' => 'You have not enough balance for this operation',
        ];
    }
});
