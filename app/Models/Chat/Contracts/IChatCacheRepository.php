<?php

namespace App\Models\Chat\Contracts;

use App\Models\Base\Contracts\ICacheRepository;

/**
 * Interface IChatCacheRepository
 * @package App\Models\Chat\Contracts
 */
interface IChatCacheRepository extends IChatRepository, ICacheRepository
{
    /**
     * Reset user chats cache by tag
     *
     * @param int $userOwnerId
     * @return void
     */
    public function resetUserChatsTag(int $userOwnerId): void;

    /**
     * Reset specific chat's cache
     *
     * @param int $chatId
     * @return void
     */
    public function resetChatCache(int $chatId): void;
}
