<?php

namespace App\Providers;

use App\ApiClient;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Repositories\CardRepositoryEloquent;
use Illuminate\Http\Resources\Json\Resource;
use App\Repositories\Contracts\CardRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CardRepository::class, CardRepositoryEloquent::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Schema::defaultStringLength(191);

        // Add the default client
        $this->app->bind(ApiClient::class, function ($app) {
            $config = config('services.oauth');
            return new ApiClient($config);
        });
        Resource::withoutWrapping();
    }
}
