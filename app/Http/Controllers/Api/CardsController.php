<?php

namespace App\Http\Controllers\Api;

use App\Card;
use App\Http\Controllers\Controller;
use App\Http\Requests\CardCreateRequest;
use App\Repositories\Contracts\CardRepository;
use Endroid\QrCode\QrCode;

class CardsController extends Controller
{
    protected $cardRepository;

    public function __construct(CardRepository $cardRepository)
    {
        $this->cardRepository = $cardRepository;
    }

    public function create(CardCreateRequest $request)
    {
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
}
