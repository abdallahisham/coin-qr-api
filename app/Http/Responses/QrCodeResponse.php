<?php

namespace App\Http\Responses;

use App\Domain\Card\CardEntity;
use Endroid\QrCode\QrCode;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

class QrCodeResponse implements Responsable
{
    protected $card;

    public function __construct(CardEntity $card)
    {
        $this->card = $card;
    }

    public function toResponse($request)
    {
        $qrCode = new QrCode($this->card->getNumber());
        $qrCode->setSize(300);
        $qrCode->writeFile(public_path("qr-codes/{$this->card->getNumber()}qrcode.png"));

        return new JsonResponse([
            'image_url' => env('APP_URL')."/qr-codes/{$this->card->getNumber()}qrcode.png",
            'amount' => $this->card->getAmount(),
            'msg' => 'Card generated succussfully!',
            'httpCode' => 200,
        ], 200);
    }
}
