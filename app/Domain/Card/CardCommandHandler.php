<?php

namespace App\Domain\Card;

class CardCommandHandler
{
    protected $repository;

    protected $commandsMapping = [
        CreateCard::class => 'createCard',
        RechargeCard::class => 'rechargeCard',
    ];

    public function __construct(CardAggregateRootRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($command)
    {
        $id = $command->id();

        $cardAggregateRoot = $this->repository->retrieve($id);

        try {
            foreach ($this->commandsMapping as $commandClass => $method) {
                if ($command instanceof $commandClass) {
                    $cardAggregateRoot->{$method}($command);
                    break;
                }
            }
        } finally {
            $this->repository->persist($cardAggregateRoot);
        }
    }
}
