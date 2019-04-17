<?php

namespace App\Http\Controllers\Api;

use App\Domain\Card\CardCommandHandler;
use App\Domain\Card\CardEntity;
use App\Domain\Card\CardId;
use App\Domain\Card\CreateCard;
use App\Http\Controllers\Controller;
use App\Http\Requests\CardCreateRequest;
use App\Http\Responses\MessageResponse;
use App\Http\Responses\QrCodeResponse;
use App\Models\Card;
use Illuminate\Http\Request;

class CardsController extends Controller
{
    protected $commandHandler;

    public function __construct(CardCommandHandler $commandHandler)
    {
        $this->commandHandler = $commandHandler;
    }

    public function generate(CardCreateRequest $request)
    {
        [$amount, $type] = $request->prepared();
        $number = Card::newCardNumber();

        $this->commandHandler->handle(new CreateCard(
            CardId::create(),
            $amount,
            $number
        ));

        $cardModel = Card::where('number', $number)->firstOrFail();
        $card = CardEntity::fromObject($cardModel);

        if ('image' === $type) {
            return new QrCodeResponse($card);
        }

        return new MessageResponse('Card created Successfully', 200, [
            'number' => $card->getNumber(),
        ]);
    }

    public function recharge(Request $request)
    {
        $number = request('number');
        $card = Card::where('number', $number)->firstOrFail();
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
