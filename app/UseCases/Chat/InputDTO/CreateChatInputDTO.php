<?php

namespace App\UseCases\Chat\InputDTO;

use App\UseCases\Base\DTO\BaseUseCaseDTO;

/**
 * Class CreateChatInputDTO
 * @package App\UseCases\Chat\InputDTO
 */
final class CreateChatInputDTO extends BaseUseCaseDTO
{
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
}
