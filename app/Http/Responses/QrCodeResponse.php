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

    /**
     * Create an HTTP response that represents the object.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        $qrCode = new QrCode($this->card->getNumber());
        $qrCode->setSize(300);
        $qrCode->writeFile(public_path("qr-codes/{$this->card->getNumber()}qrcode.png"));

        return new JsonResponse([
            'image_url' => env('APP_URL').':'.env('APP_PORT')."/qr-codes/{$this->card->getNumber()}qrcode.png",
            'amount' => $this->card->getAmount(),
            'msg' => 'Card generated succussfully!',
            'httpCode' => 200,
        ], 200);
    }
}
