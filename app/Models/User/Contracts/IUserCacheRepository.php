<?php

namespace App\Models\User\Contracts;

use App\Models\Base\Contracts\ICacheRepository;

/**
 * Interface IUserCacheRepository
 * @package App\Models\User\Contracts
 */
interface IUserCacheRepository extends IUserRepository, ICacheRepository
{
}
