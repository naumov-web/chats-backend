<?php

namespace App\Models\Message\Repositories;

use App\Models\Base\Repositories\BaseDatabaseRepository;
use App\Models\Message\Contracts\IMessageDatabaseRepository;
use App\Models\Message\DTO\CreateMessageDTO;
use App\Models\Message\DTO\MessageDTO;
use App\Models\Message\Model;

/**
 * Class DatabaseRepository
 * @package App\Models\Message\Repositories
 */
final class DatabaseRepository extends BaseDatabaseRepository implements IMessageDatabaseRepository
{
    /**
     * @inheritDoc
     */
    protected function getModelsClass(): string
    {
        return Model::class;
    }

    /**
     * @inheritDoc
     */
    protected function getTableName(): string
    {
        return 'messages';
    }

    /**
     * @inheritDoc
     */
    public function create(CreateMessageDTO $dto): void
    {
        $query = $this->getLeaderQuery();
        $query->create([
            'chat_id' => $dto->chatId,
            'user_id' => $dto->userId,
            'text' => $dto->text,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function deleteChatMessages(int $chatId): void
    {
        $query = $this->getLeaderQuery();
        $query->where('chat_id', $chatId);
        $query->delete();
    }
}
