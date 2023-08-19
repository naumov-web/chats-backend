<?php

namespace App\UseCases\Message\InputDTO;

use App\UseCases\Base\DTO\BaseUseCaseDTO;

/**
 * Class CreateMessageInputDTO
 * @package App\UseCases\Message\InputDTO
 */
final class CreateMessageInputDTO extends BaseUseCaseDTO
{
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

    /**
     * Message text value
     * @var string
     */
    public string $text;
}
