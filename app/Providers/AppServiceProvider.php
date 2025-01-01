<?php

namespace App\Providers;

use App\Contracts\AccountServiceInterface;
use App\Contracts\ProductServiceInterface;
use App\Services\AccountService;
use App\Services\ProductService;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(AccountServiceInterface::class, AccountService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // URL::forceScheme('https');
        URL::macro('livewire_current', function () {
            if (request()->route()->named('livewire.update')) {
                $previousUrl = $this->previous();
                $previousRoute = app('router')->getRoutes()->match(request()->create($previousUrl));
                return $previousRoute->getName();
            } else {
                return request()->route()->getName();
            }
        });
    }
}
