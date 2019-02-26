<?php

namespace App\Services\Contracts;

interface SmsServiceInterface
{

    /**
     * Send a message to specific phone
     *
     * @param $to
     * @param $message
     * @return mixed
     */
    public function send($to, $message);
}