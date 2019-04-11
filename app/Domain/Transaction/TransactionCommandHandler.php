<?php

namespace App\Domain\Transaction;

class TransactionCommandHandler
{
    protected $repository;

    public function __construct(TransactionAggregateRootRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($command)
    {
        $id = $command->id();

        $transactionAggregateRoot = $this->repository->retrieve($id);

        try {
            if ($command instanceof CreateTransaction) {
                $transactionAggregateRoot->createTransaction($command);
            }
        } finally {
            $this->repository->persist($transactionAggregateRoot);
        }
    }
}
