<?php

namespace App\Http\Controllers\Api;

use App\Domain\Card\CardCommandHandler;
use App\Domain\Card\CardId;
use App\Domain\Card\CreateCard;
use App\Domain\Card\RechargeCard;
use App\Domain\Card\Repositories\CardRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\CardCreateRequest;
use App\Http\Responses\MessageResponse;
use App\Http\Responses\QrCodeResponse;
use App\Models\Card;
use Illuminate\Http\Request;

class CardsController extends Controller
{
    protected $commandHandler;
    protected $repository;

    public function __construct(CardCommandHandler $commandHandler, CardRepository $repository)
    {
        $this->commandHandler = $commandHandler;
        $this->repository = $repository;
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

        $card = $this->repository->findByNumber($number);

        if ('image' === $type) {
            return new QrCodeResponse($card);
        }

        return new MessageResponse('Card created Successfully', 200, [
            'number' => $card->getNumber(),
        ]);
    }

    public function recharge(Request $request)
    {
        $card = $this->repository->findByNumber(request('number'));
        $user = $request->user();

        if ($card->isValid()) {
            $this->commandHandler->handle(new RechargeCard(
                CardId::create(),
                $card->getNumber(),
                $user->id
            ));

            return new MessageResponse('Card charged successfully');
        } else {
            return new MessageResponse('Sorry, This card is already entered', 403);
        }
    }
}
