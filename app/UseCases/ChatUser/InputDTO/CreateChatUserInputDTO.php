<?php

namespace App\UseCases\ChatUser\InputDTO;

use App\UseCases\Base\DTO\BaseUseCaseDTO;

/**
 * Class CreateChatUserInputDTO
 * @package App\UseCases\ChatUser\InputDTO
 */
final class CreateChatUserInputDTO extends BaseUseCaseDTO
{
    /**
     * Current user id value
     * @var int
     */
    public int $currentUserId;

    /**
     * Chat if value
     * @var int
     */
    public int $chatId;

    /**
     * User id value
     * @var int
     */
    public int $userId;
}
