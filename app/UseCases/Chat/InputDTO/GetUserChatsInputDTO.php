<?php

namespace App\UseCases\Chat\InputDTO;

use App\Models\User\Model;
use App\UseCases\Base\DTO\BaseUseCaseListDTO;

/**
 * Class GetUserChatsInputDTO
 * @package App\UseCases\Chat\InputDTO
 */
final class GetUserChatsInputDTO extends BaseUseCaseListDTO
{
    /**
     * User model instance
     * @var Model
     */
    public Model $user;
}
