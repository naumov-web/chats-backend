<?php

namespace App\Models\User\Contracts;

use App\Models\User\DTO\UserDTO;

/**
 * Interface IUserService
 * @package App\Models\User\Contracts
 */
interface IUserService
{
    /**
     * Create user
     *
     * @param UserDTO $dto
     * @return UserDTO
     */
    public function create(UserDTO $dto): UserDTO;
}
