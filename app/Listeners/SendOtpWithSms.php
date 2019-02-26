<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
use App\Services\Contracts\SmsServiceInterface;
use Nexmo\Client\Exception\Request;

class SendOtpWithSms
{
    protected $smsService;

    public function __construct(SmsServiceInterface $smsService)
    {
        $this->smsService = $smsService;
    }

    /**
     * Handle the event.
     *
     * @param UserLoggedIn $event
     */
    public function handle(UserLoggedIn $event)
    {
        $message = "Your otp is: {$event->user->password}";
        try {
            $messageInfo = $this->smsService->send($event->user->phone, $message);
        } catch (Request $e) {
            $user = $event->user;
            // Temp
            $user->password = '100200';
            $user->save();
        }
    }
}
