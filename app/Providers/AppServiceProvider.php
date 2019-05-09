<?php

namespace App\Providers;

use App\Domain\Card\Repositories\CardRepository;
use App\Domain\Common\Repositories\UserRepository;
use App\Infrastructure\Card\EloquentCardRepository;
use App\Infrastructure\Common\EloquentUserRepository;
use App\Services\Contracts\SmsServiceInterface;
use App\Services\NexmoSmsService;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Nexmo\Client;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        SmsServiceInterface::class => NexmoSmsService::class,
        CardRepository::class => EloquentCardRepository::class,
        UserRepository::class => EloquentUserRepository::class,
    ];

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
