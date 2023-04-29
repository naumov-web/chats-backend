<?php

namespace App\Models\User\DTO;

use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class UserAuthDTO
 * @package App\Models\User\DTO
 */
final class UserAuthDTO implements JWTSubject
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
     * @inheritDoc
     */
    public function getJWTIdentifier()
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getJWTCustomClaims()
    {
        return [
            'username' => $this->username
        ];
    }
}
