<?php

namespace App\Providers;

use App\Models\ChatUser;
use App\Models\Chat;
use App\Models\Handbook;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
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
        // Chat user
        $this->app->bind(
            ChatUser\Contracts\IChatUserService::class,
            ChatUser\Services\Service::class
        );
        $this->app->bind(
            ChatUser\Contracts\IChatUserCacheRepository::class,
            ChatUser\Repositories\CacheRepository::class
        );
        $this->app->bind(
            ChatUser\Contracts\IChatUserDatabaseRepository::class,
            ChatUser\Repositories\DatabaseRepository::class
        );
        // Message
        $this->app->bind(
            Message\Contracts\IMessageService::class,
            Message\Services\Service::class
        );
        $this->app->bind(
            Message\Contracts\IMessageCacheRepository::class,
            Message\Repositories\CacheRepository::class
        );
        $this->app->bind(
            Message\Contracts\IMessageDatabaseRepository::class,
            Message\Repositories\DatabaseRepository::class
        );
        // Handbook
        $this->app->bind(
            Handbook\Contracts\IHandbookService::class,
            Handbook\Services\Service::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
    }
}
