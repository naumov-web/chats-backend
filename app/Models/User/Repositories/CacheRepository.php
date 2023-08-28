<?php

namespace App\Models\User\Repositories;

use App\Models\User\Contracts\IUserCacheRepository;
use App\Models\User\Contracts\IUserDatabaseRepository;
use App\Models\User\DTO\UserDTO;
use Illuminate\Support\Facades\Cache;

/**
 * Class CacheRepository
 * @package App\Models\User\Repositories
 */
final class CacheRepository implements IUserCacheRepository
{
    /**
     * CacheRepository constructor
     * @param IUserDatabaseRepository $databaseRepository
     */
    public function __construct(private IUserDatabaseRepository $databaseRepository) {}

    /**
     * @inheritDoc
     */
    public function getVersionNumber(): string
    {
        return '2';
    }

    /**
     * @inheritDoc
     */
    public function getDirectoryKey(): string
    {
        return 'users/v' . $this->getVersionNumber();
    }

    /**
     * @inheritDoc
     */
    public function getUserByUsername(string $username): ?UserDTO
    {
        $keyName = $this->getDirectoryKey() . '/by-username/' . $username;
        $item = Cache::get($keyName);

        if ($item) {
            return $item;
        } else {
            $item = $this->databaseRepository->getUserByUsername($username);

            if ($item) {
                Cache::put($keyName, $item);

                return $item;
            }
        }

        return null;
    }
}
