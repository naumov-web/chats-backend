<?php

namespace App\Models\ChatUser\Contracts;

/**
 * Class IChatUserCacheRepository
 * @package App\Models\ChatUser\Contracts
 */
interface IChatUserCacheRepository extends IChatUserRepository
{
    /**
     * Reset chat user tag
     *
     * @param int $chatId
     * @return void
     */
    public function resetChatUserTag(int $chatId): void;
}
