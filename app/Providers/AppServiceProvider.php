<?php

namespace App\Providers;

use App\Contracts\AccountServiceInterface;
use App\Contracts\CategoryServiceInterface;
use App\Contracts\CustomerServiceInterface;
use App\Contracts\NotificationServiceInterface;
use App\Contracts\PostServiceInterface;
use App\Contracts\ProductDisplayServiceInterface;
use App\Contracts\ProductServiceInterface;
use App\Contracts\TransactionServiceInterface;
use App\Contracts\UserServiceInterface;
use App\Services\AccountService;
use App\Services\CategoryService;
use App\Services\CustomerService;
use App\Services\NotificationService;
use App\Services\PostService;
use App\Services\ProductDisplayService;
use App\Services\ProductService;
use App\Services\TransactionService;
use App\Services\UserService;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(NotificationServiceInterface::class, NotificationService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(CustomerServiceInterface::class, CustomerService::class);
        $this->app->bind(AccountServiceInterface::class, AccountService::class);
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
        $this->app->bind(PostServiceInterface::class, PostService::class);
        $this->app->bind(ProductDisplayServiceInterface::class, ProductDisplayService::class);
        $this->app->bind(TransactionServiceInterface::class, TransactionService::class);
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
