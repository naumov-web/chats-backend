<?php

namespace App\Models\Chat\Services;

use App\Models\Base\DTO\IndexDTO;
use App\Models\Base\DTO\ListDTO;
use App\Models\Chat\Contracts\IChatCacheRepository;
use App\Models\Chat\Contracts\IChatDatabaseRepository;
use App\Models\Chat\Contracts\IChatService;
use App\Models\Chat\DTO\ChatDTO;
use App\Models\Chat\Exceptions\ChatDoesntExistException;
use App\Models\Chat\Exceptions\ChatWithNameAlreadyExistsException;
use App\Models\Chat\Exceptions\ForbiddenException;

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
        if ($this->databaseRepository->getChatByName($dto->userOwnerId, $dto->name)) {
            throw new ChatWithNameAlreadyExistsException();
        }

        $newChatDto = $this->databaseRepository->createChat($dto);
        $this->cacheRepository->resetUserChatsTag($dto->userOwnerId);

        return $newChatDto;
    }

    /**
     * @inheritDoc
     */
    public function getUserChats(int $userId, IndexDTO $indexDto): ListDTO
    {
        return $this->cacheRepository->getUserChats($userId, $indexDto);
    }

    /**
     * @inheritDoc
     * @throws ChatDoesntExistException
     * @throws ForbiddenException
     */
    public function getUserChat(int $userOwnerId, int $chatId): ChatDTO
    {
        $chatDto = $this->cacheRepository->getChat($chatId);

        if (!$chatDto) {
            throw new ChatDoesntExistException();
        }

        if ($chatDto->userOwnerId !== $userOwnerId) {
            throw new ForbiddenException();
        }

        return $chatDto;
    }


    /**
     * @inheritDoc
     * @throws ChatDoesntExistException
     */
    public function getChat(int $chatId): ChatDTO
    {
        $chatDto = $this->cacheRepository->getChat($chatId);

        if (!$chatDto) {
            throw new ChatDoesntExistException();
        }

        return $chatDto;
    }

    /**
     * @inheritDoc
     * @param ChatDTO $newChatDto
     * @return ChatDTO
     * @throws ChatDoesntExistException
     * @throws ChatWithNameAlreadyExistsException
     * @throws ForbiddenException
     */
    public function updateChat(ChatDTO $newChatDto): ChatDTO
    {
        $chatDto = $this->cacheRepository->getChat($newChatDto->id);

        if (!$chatDto) {
            throw new ChatDoesntExistException();
        }

        if ($chatDto->userOwnerId !== $newChatDto->userOwnerId) {
            throw new ForbiddenException();
        }

        if ($this->databaseRepository->getChatByNameExcludeId(
            $newChatDto->userOwnerId,
            $newChatDto->name,
            $newChatDto->id
        )) {
            throw new ChatWithNameAlreadyExistsException();
        }

        $updatedChatDto = $this->databaseRepository->updateChat($newChatDto);
        $this->cacheRepository->resetChatCache($newChatDto->id);
        $this->cacheRepository->resetUserChatsTag($newChatDto->userOwnerId);

        return $updatedChatDto;
    }

    /**
     * @inheritDoc
     */
    public function deleteChat(int $chatId, int $currentUserId): void
    {
        $this->databaseRepository->deleteChat($chatId);
        $this->cacheRepository->resetChatCache($chatId);
        $this->cacheRepository->resetUserChatsTag($currentUserId);
    }
}
