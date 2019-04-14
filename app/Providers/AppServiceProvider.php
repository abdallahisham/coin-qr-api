<?php

namespace App\Providers;

use App\Services\Contracts\SmsServiceInterface;
use App\Services\NexmoSmsService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\Resource;
use Nexmo\Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(Client::class, function () {
            $key = config('services.nexmo.key');
            $secret = config('services.nexmo.secret');
            $basic = new Client\Credentials\Basic($key, $secret);

            return new Client($basic);
        });

        $this->app->bind(SmsServiceInterface::class, NexmoSmsService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Resource::withoutWrapping();
    }
}
