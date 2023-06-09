<?php

namespace App\Models\User;

use Illuminate\Foundation\Auth\User as Authentication;
use Illuminate\Support\Collection;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class Model
 * @package App\Models\User
 *
 * @property-read int $id
 * @property string $username
 * @property string $password
 * @property bool $is_anonymous
 */
final class Model extends Authentication implements JWTSubject
{
    /**
     * Table name for model
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
