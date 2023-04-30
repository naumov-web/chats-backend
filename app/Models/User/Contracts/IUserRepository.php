<?php

namespace App\Models\User\Contracts;

use App\Models\User\DTO\UserDTO;

/**
 * Interface IUserRepository
 * @package App\Models\User\Contracts
 */
interface IUserRepository
{
    /**
     * Get user DTO instance by username
     *
     * @param string $username
     * @return UserDTO|null
     */
    public function getUserByUsername(string $username): ?UserDTO;
}
