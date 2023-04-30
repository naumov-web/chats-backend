<?php

namespace App\Models\User\Contracts;

use App\Models\User\DTO\UserDTO;

/**
 * Interface IUserDatabaseRepository
 * @package App\Models\User\Contracts
 */
interface IUserDatabaseRepository extends IUserRepository
{
    /**
     * Create user in database
     *
     * @param UserDTO $dto
     * @return UserDTO
     */
    public function createUser(UserDTO $dto): UserDTO;
}
