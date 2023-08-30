<?php

namespace App\UseCases\Message\InputDTO;

use App\Models\User\Model;
use App\UseCases\Base\DTO\BaseUseCaseListDTO;

/**
 * Class GetMessagesInputDTO
 * @package App\UseCases\Message\InputDTO
 */
final class GetMessagesInputDTO extends BaseUseCaseListDTO
{
    /**
     * User model instance
     * @var Model
     */
    public Model $user;

    /**
     * Chat id value
     * @var int
     */
    public int $chatId;
}
