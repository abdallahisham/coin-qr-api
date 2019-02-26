<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
use App\Services\Contracts\SmsServiceInterface;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
     * @param  UserLoggedIn  $event
     * @return void
     */
    public function handle(UserLoggedIn $event)
    {
        $message = "Your otp is: {$event->user->password}";
        $messageInfo = $this->smsService->send($event->user->phone, $message);
    }
}
