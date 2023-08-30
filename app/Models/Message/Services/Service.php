<?php

namespace App\Models\Message\Services;

use App\Models\Base\DTO\IndexDTO;
use App\Models\Base\DTO\ListDTO;
use App\Models\Message\Contracts\IMessageCacheRepository;
use App\Models\Message\Contracts\IMessageDatabaseRepository;
use App\Models\Message\Contracts\IMessageService;
use App\Models\Message\DTO\CreateMessageDTO;

/**
 * Class Service
 * @package App\Models\Message\Services
 */
final class Service implements IMessageService
{
    /**
     * Service constructor
     * @param IMessageCacheRepository $cacheRepository
     * @param IMessageDatabaseRepository $databaseRepository
     */
    public function __construct(
        private IMessageCacheRepository $cacheRepository,
        private IMessageDatabaseRepository $databaseRepository
    ) {}

    /**
     * @inheritDoc
     */
    public function create(CreateMessageDTO $dto): void
    {
        $this->databaseRepository->create($dto);
        $this->cacheRepository->resetChatMessagesTag($dto->chatId);
    }

    /**
     * @inheritDoc
     */
    public function deleteChatMessages(int $chatId): void
    {
        $this->databaseRepository->deleteChatMessages($chatId);
    }

    /**
     * @inheritDoc
     */
    public function index(int $chatId, IndexDTO $indexDto): ListDTO
    {
        return $this->cacheRepository->index($chatId, $indexDto);
    }
}
