<?php

namespace App\Http\Controllers\Api;

use App\Models\Card;
use Endroid\QrCode\QrCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CardCreateRequest;
use App\Repositories\Contracts\CardRepository;

class CardsController extends Controller
{
    protected $cardRepository;

    public function __construct(CardRepository $cardRepository)
    {
        $this->cardRepository = $cardRepository;
    }

    public function store(CardCreateRequest $request)
    {
        $amount = request('amount');
        $type = request('type');
        try {
            $card = Card::create([
                'amount' => $amount,
                'number' => rand(156412345, 999999999),
            ]);
        } catch (Illuminate\Database\QueryException $e) {
            $card = Card::create([
                'amount' => $amount,
                'number' => rand(156412345, 999999999),
            ]);
        }

        switch ($type) {
            case 'image':
                $qrCode = new QrCode($card->number);
                $qrCode->setSize(300);
                $qrCode->writeFile(public_path("qr-codes/{$card->number}qrcode.png"));

                return [
                    'image_url' => env('APP_URL').':'.env('APP_PORT')."/qr-codes/{$card->number}qrcode.png",
                ];
            case 'number':
                return ['number' => $card->number];
            default:
                return [
                    'httpCode' => 400,
                    'msg' => 'Bad amount',
                ];
                break;
        }
    }

    public function recharge(Request $request)
    {
        $number = request('number');
        $card = Card::where('number', $number)->first();
        $user = $request->user();
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
    }
}
