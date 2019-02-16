<?php

use App\Card;
use App\User;
use App\Transfer;
use Endroid\QrCode\QrCode;
use Illuminate\Http\Request;

Route::middleware('auth:api')->post('/user', function (Request $request) {
    return $request->user();
});

Route::post('generate-card', function () {
    $amount = request('amount');
    $type = request('type');
    switch ($amount) {
        case 100:
        case 200:
        case 300:
            break;
        
        default:
            return [
                'httpCode' => 400,
                'msg' => 'Bad amount'
            ];
            break;
    }

    try {
        $card = Card::create([
            'amount' => $amount,
            'number' => rand(130320330326652, 999999999999999)
        ]);
    } catch (Illuminate\Database\QueryException $e) {
        $card = Card::create([
            'amount' => $amount,
            'number' => rand(130320330326652, 999999999999999)
        ]);
    }

    switch ($type) {
        case 'image':
            $qrCode = new QrCode($card->number);
            $qrCode->setSize(300);
            $qrCode->writeFile(public_path("qr-codes/{$card->number}qrcode.png"));
            return [
                'image_url' => env('APP_URL') . ':' . env('APP_PORT') . "/qr-codes/{$card->number}qrcode.png"
            ];
        case 'number':
            return ['number' => $card->number];
        default:
            return [
                'httpCode' => 400,
                'msg' => 'Bad amount'
            ];
            break;
    }
});

Route::middleware('auth:api')->post('recharge', function () {
    $number = request('number');
    $card = Card::where('number', $number)->first();
    $user = request()->user();
    if ($card->status == 0) {
        $user->balance += $card->amount;
        $user->save();
        $card->status = 1;
        $card->save();
        return [
            'httpCode' => 200,
            'msg' => 'Card charged successfully'
        ];
    } else {
        return [
            'httpCode' => 403,
            'msg' => 'Sorry, This card is already entered'
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
        $sender->save();
        $receiver->suspended_balance += $amount;
        $receiver->save();

        return [
            'httpCode' => 200,
            'msg' => 'Transferred successfully'
        ];
    } else {
        return [
            'httpCode' => 400,
            'msg' => 'You have not enough balance for this operation'
        ];
    }
});
