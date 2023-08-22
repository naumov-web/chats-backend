<?php

namespace App\Models\ChatUser\Contracts;

/**
 * Class IChatUserDatabaseRepository
 * @package App\Models\ChatUser\Contracts
 */
interface IChatUserDatabaseRepository extends IChatUserRepository
{
    /**
     * Create chat user instance
     *
     * @param int $chatId
     * @param int $userId
     * @return void
     */
    public function createChatUser(int $chatId, int $userId): void;

    /**
     * Delete users for specific chat
     *
     * @param int $chatId
     * @return void
     */
    public function deleteChatUsers(int $chatId): void;
}
