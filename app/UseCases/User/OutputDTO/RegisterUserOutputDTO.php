<?php

namespace App\UseCases\User\OutputDTO;

/**
 * Class RegisterRandomUserOutputDTO
 * @package App\UseCases\User\OutputDTO
 */
final class RegisterUserOutputDTO
{
    /**
     * Token value
     * @var string
     */
    public string $token;

    /**
     * User id value
     * @var int
     */
    public int $id;

    /**
     * Username value
     * @var string
     */
    public string $username;
}
