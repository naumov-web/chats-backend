<?php

namespace App\Models\Message\DTO;

/**
 * Class CreateMessageDTO
 * @package App\Models\Message\DTO
 */
final class CreateMessageDTO
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

    /**
     * Message text value
     * @var string
     */
    public string $text;
}
