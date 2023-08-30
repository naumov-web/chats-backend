<?php

namespace App\Models\Base\Repositories;

use App\Models\Base\DTO\ListDTO;
use Illuminate\Support\Facades\Cache;

/**
 * Class BaseCacheRepository
 * @package App\Models\Base\Repositories
 */
abstract class BaseCacheRepository
{
    /**
     * Get list DTO instance from cache
     *
     * @param string $keyName
     * @param array $tags
     * @return ListDTO|null
     */
    protected function getListDTO(string $keyName, array $tags): ?ListDTO
    {
        /** @var ListDTO $value */
        $value = Cache::tags($tags)->get($keyName);

        return $value;
    }

    /**
     * Put list DTO instance into cache
     *
     * @param string $keyName
     * @param array $tags
     * @param ListDTO $value
     * @return void
     */
    protected function putListDTO(string $keyName, array $tags, ListDTO $value): void
    {
        Cache::tags($tags)
            ->put(
                $keyName,
                $value
            );
    }
}
