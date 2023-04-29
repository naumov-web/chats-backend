<?php

namespace App\Providers;

use App\Models\User\Contracts\IUserCacheRepository;
use App\Models\User\Contracts\IUserDatabaseRepository;
use App\Models\User\Contracts\IUserService;
use App\Models\User\Repositories\CacheRepository;
use App\Models\User\Repositories\DatabaseRepository;
use App\Models\User\Services\Service;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            IUserService::class,
            Service::class
        );
        $this->app->bind(
            IUserCacheRepository::class,
            CacheRepository::class
        );
        $this->app->bind(
            IUserDatabaseRepository::class,
            DatabaseRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
