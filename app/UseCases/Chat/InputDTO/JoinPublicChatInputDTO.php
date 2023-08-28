<?php

namespace App\UseCases\Chat\InputDTO;

use App\UseCases\Base\DTO\BaseUseCaseDTO;

/**
 * Class JoinChatInputDTO
 * @package App\UseCases\Chat\InputDTO
 */
final class JoinChatInputDTO extends BaseUseCaseDTO
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
