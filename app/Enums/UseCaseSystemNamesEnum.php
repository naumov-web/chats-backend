<?php

namespace App\Enums;

/**
 * Class UseCaseSystemNamesEnum
 * @package App\Enums
 */
final class UseCaseSystemNamesEnum
{
    /**
     * Use case for registration of random user
     * @var string
     */
    public const REGISTER_RANDOM_USER = 'registerRandomUser';

    /**
     * Use case for registration of user with username and password
     * @var string
     */
    public const REGISTER_USER = 'register_user';

    /**
     * Use case for login of user by username and password
     * @var string
     */
    public const LOGIN_USER = 'login_user';
}
