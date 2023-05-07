<?php

namespace App\UseCases\User;

use App\Models\User\DTO\UserAuthDTO;
use App\Models\User\DTO\UserDTO;
use App\UseCases\BaseUseCase;
use App\UseCases\User\Exceptions\InvalidCredentialsException;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class BaseUserUseCase
 * @package App\UseCases\User
 */
abstract class BaseUserUseCase extends BaseUseCase
{
    /**
     * Add token prefix
     *
     * @param string $token
     * @return string
     */
    protected function addTokenPrefix(string $token): string
    {
        return 'Bearer ' . $token;
    }

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

        return $this->addTokenPrefix($token);
    }

    /**
     * Get user token by user's credentials
     *
     * @param string $username
     * @param string $password
     * @return string
     * @throws InvalidCredentialsException
     */
    protected function getUserTokenByCredentials(string $username, string $password): string
    {
        $token = JWTAuth::attempt([
            'username' => $username,
            'password' => $password
        ]);

        if (!$token) {
            throw new InvalidCredentialsException();
        }

        return $this->addTokenPrefix($token);
    }
}
