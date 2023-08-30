<?php

namespace App\Models\Chat\Repositories;

use App\Models\Base\DTO\IndexDTO;
use App\Models\Base\DTO\ListDTO;
use App\Models\Base\Repositories\BaseCacheRepository;
use App\Models\Chat\Contracts\IChatCacheRepository;
use App\Models\Chat\Contracts\IChatDatabaseRepository;
use App\Models\Chat\DTO\ChatDTO;
use Illuminate\Support\Facades\Cache;

/**
 * Class CacheRepository
 * @package App\Models\Chat\Repositories
 */
final class CacheRepository extends BaseCacheRepository implements IChatCacheRepository
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
    public function getUserChats(int $userOwnerId, IndexDTO $indexDto): ListDTO
    {
        $keyName = $this->getDirectoryKey() . '/users/' . $userOwnerId . '/chats/' . $indexDto->toString();
        $tags = [$this->getUserTag($userOwnerId)];
        $items = $this->getListDTO($keyName, $tags);

        if ($items) {
            return $items;
        } else {
            $items = $this->databaseRepository->getUserChats($userOwnerId, $indexDto);

            $this->putListDTO(
                $keyName,
                [$this->getUserTag($userOwnerId)],
                $items
            );

            return $items;
        }
    }

    /**
     * @inheritDoc
     */
    public function getChat(int $chatId): ?ChatDTO
    {
        $keyName = $this->getSpecificChatKey($chatId);
        $item = Cache::get($keyName);

        if ($item) {
            return $item;
        } else {
            $item = $this->databaseRepository->getChat($chatId);

            if ($item) {
                Cache::put($keyName, $item);

                return $item;
            }
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function resetUserChatsTag(int $userOwnerId): void
    {
        Cache::tags([
            $this->getUserTag($userOwnerId)
        ])->flush();
    }

    /**
     * @inheritDoc
     */
    public function resetChatCache(int $chatId): void
    {
        $keyName = $this->getSpecificChatKey($chatId);
        Cache::forget($keyName);
    }

    /**
     * Get user tag value
     *
     * @param int $userOwnerId
     * @return string
     */
    private function getUserTag(int $userOwnerId): string
    {
        return 'users/' . $userOwnerId . '/my/chats';
    }

    /**
     * Get specific chat key
     *
     * @param int $chatId
     * @return string
     */
    private function getSpecificChatKey(int $chatId): string
    {
        return $this->getDirectoryKey() . '/chats/' . $chatId;
    }
}
