<?php

namespace App\Services;

use App\Services\Contracts\SmsServiceInterface;
use Nexmo\Client as Nexmo;

class NexmoSmsService implements SmsServiceInterface
{
    protected $nexmo;

    public function __construct(Nexmo $nexmo)
    {
        $this->nexmo = $nexmo;
    }

    /**
     * Send a message to specific phone.
     *
     * @param $to
     * @param $message
     *
     * @return mixed
     */
    public function send($to, $message)
    {
        $message = $this->nexmo->message()->send([
            'from' => config('services.nexmo.sms_from'),
            'to' => $to,
            'text' => $message,
        ]);

        return $message;
    }
}
