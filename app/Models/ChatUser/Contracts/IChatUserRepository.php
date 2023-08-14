<?php

namespace App\Models\ChatUser\Contracts;

/**
 * Class IChatUserRepository
 * @package App\Models\ChatUser\Contracts
 */
interface IChatUserRepository
{
    /**
     * Check is chat user record exists
     *
     * @param int $chatId
     * @param int $userId
     * @return bool
     */
    public function isChatUserExists(int $chatId, int $userId): bool;
}
