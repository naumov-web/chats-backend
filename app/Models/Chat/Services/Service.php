<?php

namespace App\Models\Chat\Services;

use App\Models\Base\DTO\IndexDTO;
use App\Models\Base\DTO\ListDTO;
use App\Models\Chat\Contracts\IChatCacheRepository;
use App\Models\Chat\Contracts\IChatDatabaseRepository;
use App\Models\Chat\Contracts\IChatService;
use App\Models\Chat\DTO\ChatDTO;
use App\Models\Chat\Exceptions\ChatWithNameAlreadyExistsException;

/**
 * Class Service
 * @package App\Models\Chat\Services
 */
final class Service implements IChatService
{
    /**
     * Service constructor
     * @param IChatCacheRepository $cacheRepository
     * @param IChatDatabaseRepository $databaseRepository
     */
    public function __construct(
        private IChatCacheRepository $cacheRepository,
        private IChatDatabaseRepository $databaseRepository
    ) {}

    /**
     * @inheritDoc
     * @throws ChatWithNameAlreadyExistsException
     */
    public function createChat(ChatDTO $dto): ChatDTO
    {
        if ($this->cacheRepository->getChatByName($dto->userOwnerId, $dto->name)) {
            throw new ChatWithNameAlreadyExistsException();
        }

        return $this->databaseRepository->createChat($dto);
    }

    /**
     * @inheritDoc
     */
    public function getUserChats(int $userId, IndexDTO $indexDto): ListDTO
    {
        return $this->cacheRepository->getUserChats($userId, $indexDto);
    }
}
