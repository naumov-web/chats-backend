<?php

namespace App\UseCases\User\InputDTO;

use App\UseCases\Base\DTO\BaseUseCaseDTO;

/**
 * Class RegisterUserInputDTO
 * @package App\UseCases\User\InputDTO
 */
final class RegisterUserInputDTO extends BaseUseCaseDTO
{
    /**
     * Username value
     * @var string
     */
    public string $username;

    /**
     * Password value
     * @var string
     */
    public string $password;
}
