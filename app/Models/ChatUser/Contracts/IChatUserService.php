<?php

namespace App\Models\ChatUser\Contracts;

use App\Models\ChatUser\DTO\CreateChatUserDTO;

/**
 * Interface IChatUserService
 * @package App\Models\ChatUser\Contracts
 */
interface IChatUserService
{
    /**
     * Create chat user instance
     *
     * @param CreateChatUserDTO $dto
     * @return void
     */
    public function createChatUser(CreateChatUserDTO $dto): void;

    /**
     * Check is chat user exists
     *
     * @param int $chatId
     * @param int $userId
     * @return bool
     */
    public function isChatUserExists(int $chatId, int $userId): bool;

    /**
     * Delete chat users for specific chat
     *
     * @param int $chatId
     * @return void
     */
    public function deleteChatUsers(int $chatId): void;
}
