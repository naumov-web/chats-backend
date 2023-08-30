<?php

namespace App\Models\Message\DTO;

use App\Models\Base\DTO\ModelDTO;

/**
 * Class MessageDTO
 * @package
 */
final class MessageDTO extends ModelDTO
{
    /**
     * Message id value
     * @var int
     */
    public int $id;

    /**
     * Chat id value
     * @var string
     */
    public string $chatId;

    /**
     * Username value
     * @var string
     */
    public string $username;

    /**
     * User id value
     * @var string
     */
    public string $userId;

    /**
     * Message text value
     * @var string
     */
    public string $text;

    /**
     * Created at value
     * @var string
     */
    public string $createdAt;
}
