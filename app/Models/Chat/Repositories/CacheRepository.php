<?php

namespace App\Models\Chat\Repositories;

use App\Models\Base\DTO\IndexDTO;
use App\Models\Base\DTO\ListDTO;
use App\Models\Chat\Contracts\IChatCacheRepository;
use App\Models\Chat\Contracts\IChatDatabaseRepository;
use App\Models\Chat\DTO\ChatDTO;
use Illuminate\Support\Facades\Cache;

/**
 * Class CacheRepository
 * @package App\Models\Chat\Repositories
 */
final class CacheRepository implements IChatCacheRepository
{
    /**
     * CacheRepository constructor
     * @param IChatDatabaseRepository $databaseRepository
     */
    public function __construct(private IChatDatabaseRepository $databaseRepository) {}

    /**
     * @inheritDoc
     */
    public function getVersionNumber(): string
    {
        return '1';
    }

    /**
     * @inheritDoc
     */
    public function getDirectoryKey(): string
    {
        return 'chats/v' . $this->getVersionNumber();
    }

    /**
     * @inheritDoc
     */
    public function getChatByName(int $userOwnerId, string $name): ?ChatDTO
    {
        $keyName = $this->getDirectoryKey() . '/user/' . $userOwnerId . '/by-name/' . $name;
        $item = Cache::get($keyName);

        if ($item) {
            return $item;
        } else {
            $item = $this->databaseRepository->getChatByName($userOwnerId, $name);

            if ($item) {
                Cache::tags([
                    $this->getUserTag($userOwnerId)
                ])->put($keyName, $item);

                return $item;
            }
        }

        return null;
    }

    private function getUserTag(int $userOwnerId): string
    {
        return 'users/' . $userOwnerId . '/chats';
    }

    /**
     * @inheritDoc
     */
    public function getUserChats(int $userOwnerId, IndexDTO $indexDto): ListDTO
    {
        $keyName = 'users/' . $userOwnerId . '/chats/' . $indexDto->toString();
        $items = Cache::get($keyName);

        if ($items) {
            return $items;
        } else {
            $items = $this->databaseRepository->getUserChats($userOwnerId, $indexDto);

            Cache::tags([
                $this->getUserTag($userOwnerId)
            ])->put($keyName, $items);

            return $items;
        }
    }
}
