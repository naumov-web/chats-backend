<?php

namespace App\Models\Message\Repositories;

use App\Models\Base\DTO\IndexDTO;
use App\Models\Base\DTO\ListDTO;
use App\Models\Base\Repositories\BaseCacheRepository;
use App\Models\Message\Contracts\IMessageCacheRepository;
use App\Models\Message\Contracts\IMessageDatabaseRepository;
use Illuminate\Support\Facades\Cache;

/**
 * Class CacheRepository
 * @package App\Models\Message\Repositories
 */
final class CacheRepository extends BaseCacheRepository implements IMessageCacheRepository
{
    /**
     * CacheRepository constructor
     * @param IMessageDatabaseRepository $databaseRepository
     */
    public function __construct(private IMessageDatabaseRepository $databaseRepository) {}

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
    public function index(int $chatId, IndexDTO $indexDto): ListDTO
    {
        $keyName = $this->getDirectoryKey() . '/chats/' . $chatId . '/messages/' . $indexDto->toString();
        $tags = [$this->getChatTag($chatId)];
        $items = $this->getListDTO($keyName, $tags);

        if ($items) {
            return $items;
        } else {
            $items = $this->databaseRepository->index($chatId, $indexDto);

            $this->putListDTO(
                $keyName,
                [$this->getChatTag($chatId)],
                $items
            );

            return $items;
        }
    }

    /**
     * @inheritDoc
     */
    public function resetChatMessagesTag(int $chatId): void
    {
        $tag = $this->getChatTag($chatId);
        Cache::tags([$tag])->flush();
    }

    /**
     * Get chat tag value
     *
     * @param int $chatId
     * @return string
     */
    private function getChatTag(int $chatId): string
    {
        return 'chats/' . $chatId;
    }
}
