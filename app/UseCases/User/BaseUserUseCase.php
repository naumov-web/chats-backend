<?php

namespace App\UseCases\User;

use App\Models\User\DTO\UserAuthDTO;
use App\Models\User\DTO\UserDTO;
use App\UseCases\BaseUseCase;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class BaseUserUseCase
 * @package App\UseCases\User
 */
abstract class BaseUserUseCase extends BaseUseCase
{
    /**
     * Get user token string
     *
     * @param UserDTO $userDto
     * @return string
     */
    protected function getUserToken(UserDTO $userDto): string
    {
        $userAuthDto = new UserAuthDTO();
        $userAuthDto->id = $userDto->id;
        $userAuthDto->username = $userDto->username;

        $token =  JWTAuth::fromUser($userAuthDto);

        return $token;
    }
}
