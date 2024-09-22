<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\InventoryService;
use App\Services\ItemStrategyFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(InventoryService::class, function ($app) {
            return new InventoryService(new ItemStrategyFactory());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
