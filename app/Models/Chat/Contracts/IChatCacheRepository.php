<?php

namespace App\Models\Chat\Contracts;

use App\Models\Base\Contracts\ICacheRepository;

/**
 * Interface IChatCacheRepository
 * @package App\Models\Chat\Contracts
 */
interface IChatCacheRepository extends IChatRepository, ICacheRepository
{
}
