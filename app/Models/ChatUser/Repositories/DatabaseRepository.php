<?php

namespace App\Models\ChatUser\Repositories;

use App\Models\Base\Repositories\BaseDatabaseRepository;
use App\Models\ChatUser\Contracts\IChatUserDatabaseRepository;
use App\Models\ChatUser\Model;

/**
 * Class DatabaseRepository
 * @package App\Models\ChatUser\Repositories
 */
final class DatabaseRepository extends BaseDatabaseRepository implements IChatUserDatabaseRepository
{

    /**
     * @inheritDoc
     */
    public function createChatUser(int $chatId, int $userId): void
    {
        $query = $this->getLeaderQuery();
        $query->create([
            'chat_id' => $chatId,
            'user_id' => $userId,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function isChatUserExists(int $chatId, int $userId): bool
    {
        $query = $this->getFollowerQuery();
        $query->where('chat_id', $chatId);
        $query->where('user_id', $userId);
        $model = $query->first();

        return (bool)$model;
    }

    /**
     * @inheritDoc
     */
    public function deleteChatUsers(int $chatId): void
    {
        $query = $this->getLeaderQuery();
        $query->where('chat_id', $chatId);
        $query->delete();
    }

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
        return 'chat_users';
    }
}
