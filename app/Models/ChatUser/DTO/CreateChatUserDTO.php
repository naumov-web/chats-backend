<?php

namespace App\Models\ChatUser\DTO;

/**
 * Class CreateChatUserDTO
 * @package App\Models\ChatUser\DTO
 */
final class CreateChatUserDTO
{
    /**
     * Chat id value
     * @var int
     */
    public int $chatId;

    /**
     * User id value
     * @var int
     */
    public int $userId;
}
