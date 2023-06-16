<?php

namespace App\Models\Chat\DTO;

use App\Models\Base\DTO\ModelDTO;

/**
 * Class ChatDTO
 * @package App\Models\Chat\DTO
 */
final class ChatDTO extends ModelDTO
{
    /**
     * User id value
     * @var int
     */
    public int $id;

    /**
     * User owner id value
     * @var int
     */
    public int $userOwnerId;

    /**
     * Name value
     * @var string
     */
    public string $name;

    /**
     * Type id value
     * @var int
     */
    public int $typeId;

    /**
     * Date and time of creation
     * @var string
     */
    public string $createdAt;
}
