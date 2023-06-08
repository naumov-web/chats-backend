<?php

namespace App\Providers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // User
        $this->app->bind(
            User\Contracts\IUserService::class,
            User\Services\Service::class
        );
        $this->app->bind(
            User\Contracts\IUserCacheRepository::class,
            User\Repositories\CacheRepository::class
        );
        $this->app->bind(
            User\Contracts\IUserDatabaseRepository::class,
            User\Repositories\DatabaseRepository::class
        );
        // Chat
        $this->app->bind(
            Chat\Contracts\IChatService::class,
            Chat\Services\Service::class
        );
        $this->app->bind(
            Chat\Contracts\IChatCacheRepository::class,
            Chat\Repositories\CacheRepository::class
        );
        $this->app->bind(
            Chat\Contracts\IChatDatabaseRepository::class,
            Chat\Repositories\DatabaseRepository::class
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
