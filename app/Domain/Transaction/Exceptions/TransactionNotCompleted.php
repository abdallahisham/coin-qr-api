<?php

namespace App\Domain\Transaction\Exceptions;

use Exception;

class TransactionNotCompleted extends Exception
{
    public static function internalError()
    {
        throw new static('Transaction faild!, Try again', 500);
    }

    public static function notEnoughBalance()
    {
        throw new static('Transaction forbidden!, you have not enough balance for this operation', 403);
    }
}
