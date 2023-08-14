<?php

namespace App\Models\ChatUser\Repositories;

use App\Models\ChatUser\Contracts\IChatUserCacheRepository;
use App\Models\ChatUser\Contracts\IChatUserDatabaseRepository;
use Illuminate\Support\Facades\Cache;

/**
 * Class CacheRepository
 * @package App\Models\ChatUser\Repositories
 */
final class CacheRepository implements IChatUserCacheRepository
{
    /**
     * Class CacheRepository
     * @param IChatUserDatabaseRepository $databaseRepository
     */
    public function __construct(private IChatUserDatabaseRepository $databaseRepository) {}

    /**
     * @inheritDoc
     */
    public function isChatUserExists(int $chatId, int $userId): bool
    {
        $keyName = '/chat-users/' . $chatId . '/' . $userId;
        $value = Cache::tags([
            $this->getChatUsersTag($chatId)
        ])->get($keyName);

        if (is_null($value)) {
            $value = $this->databaseRepository->isChatUserExists($chatId, $userId);

            Cache::tags([
                $this->getChatUsersTag($chatId)
            ])->put($keyName, $value);
        }

        return $value;
    }

    /**
     * @inheritDoc
     */
    public function resetChatUserTag(int $chatId): void
    {
        Cache::tags([
            $this->getChatUsersTag($chatId)
        ])->flush();
    }

    /**
     * Get chat users tag value
     *
     * @param int $chatId
     * @return string
     */
    private function getChatUsersTag(int $chatId): string
    {
        return '/chats/' . $chatId . '/users';
    }
}
