<?php

namespace App\UseCases\Chat\InputDTO;

use App\UseCases\Base\DTO\BaseUseCaseDTO;

/**
 * Class UpdateChatInputDTO
 * @package App\UseCases\Chat\InputDTO
 */
final class UpdateChatInputDTO extends BaseUseCaseDTO
{
    /**
     * Chat id value
     * @var int
     */
    public int $id;

    /**
     * Current user id value
     * @var int
     */
    public int $currentUserId;

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
}
