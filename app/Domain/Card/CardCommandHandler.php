<?php

namespace App\Domain\Card;

class CardCommandHandler
{
    protected $repository;

    public function __construct(CardAggregateRootRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($command)
    {
        $id = $command->id();

        $cardAggregateRoot = $this->repository->retrieve($id);

        try {
            if ($command instanceof CreateCard) {
                $cardAggregateRoot->createCard($command);
            }
        } finally {
            $this->repository->persist($cardAggregateRoot);
        }
    }
}
