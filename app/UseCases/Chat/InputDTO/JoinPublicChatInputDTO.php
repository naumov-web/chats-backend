<?php

namespace App\UseCases\Chat\InputDTO;

use App\UseCases\Base\DTO\BaseUseCaseDTO;

/**
 * Class JoinPublicChatInputDTO
 * @package App\UseCases\Chat\InputDTO
 */
final class JoinPublicChatInputDTO extends BaseUseCaseDTO
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
