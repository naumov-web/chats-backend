<?php

namespace App\Models\User\DTO;

use App\Models\Base\DTO\ModelDTO;

/**
 * Class UserDTO
 * @package App\Models\User\DTO
 */
final class UserDTO extends ModelDTO
{
    /**
     * User id value
     * @var int
     */
    public int $id;

    /**
     * User email value
     * @var string
     */
    public string $username;

    /**
     * User password value
     * @var string|null
     */
    public string|null $password = null;

    /**
     * User is anonymous flag
     * @var bool
     */
    public bool $isAnonymous;
}
