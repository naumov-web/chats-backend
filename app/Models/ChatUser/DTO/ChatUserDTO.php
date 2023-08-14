<?php

namespace App\Models\ChatUser\DTO;

use App\Models\Base\DTO\ModelDTO;

/**
 * Class ChatUserDTO
 * @package App\Models\ChatUser\DTO
 */
final class ChatUserDTO extends ModelDTO
{
    /**
     * User id value
     * @var int
     */
    public int $id;

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

    /**
     * Date and time of creation
     * @var string
     */
    public string $createdAt;
}
