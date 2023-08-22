<?php

namespace App\Models\ChatUser\Services;

use App\Models\ChatUser\Contracts\IChatUserCacheRepository;
use App\Models\ChatUser\Contracts\IChatUserDatabaseRepository;
use App\Models\ChatUser\Contracts\IChatUserService;
use App\Models\ChatUser\DTO\CreateChatUserDTO;
use App\Models\ChatUser\Exceptions\ChatUserAlreadyExistsException;

/**
 * Class IChatUserService
 * @package App\Models\ChatUser
 */
final class Service implements IChatUserService
{
    /**
     * Service constructor
     * @param IChatUserCacheRepository $cacheRepository
     * @param IChatUserDatabaseRepository $databaseRepository
     */
    public function __construct(
        private IChatUserCacheRepository $cacheRepository,
        private IChatUserDatabaseRepository $databaseRepository
    ) {}

    /**
     * @inheritDoc
     * @throws ChatUserAlreadyExistsException
     */
    public function createChatUser(CreateChatUserDTO $dto): void
    {
        if ($this->isChatUserExists($dto->chatId, $dto->userId)) {
            throw new ChatUserAlreadyExistsException();
        }

        $this->databaseRepository->createChatUser(
            $dto->chatId,
            $dto->userId
        );
        $this->cacheRepository->resetChatUserTag($dto->chatId);
    }

    /**
     * @inheritDoc
     */
    public function isChatUserExists(int $chatId, int $userId): bool
    {
        return $this->cacheRepository->isChatUserExists(
            $chatId,
            $userId
        );
    }

    /**
     * @inheritDoc
     */
    public function deleteChatUsers(int $chatId): void
    {
        $this->databaseRepository->deleteChatUsers($chatId);
        $this->cacheRepository->resetChatUserTag($chatId);
    }
}
