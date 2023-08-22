<?php

namespace App\UseCases\Chat\InputDTO;

use App\UseCases\Base\DTO\BaseUseCaseDTO;

/**
 * Class DeleteChatInputDTO
 * @package App\UseCases\Chat\InputDTO
 */
final class DeleteChatInputDTO extends BaseUseCaseDTO
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
}
