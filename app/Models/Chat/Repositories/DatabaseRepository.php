<?php

namespace App\Models\Chat\Repositories;

use App\Models\Base\Repositories\BaseDatabaseRepository;
use App\Models\Chat\Composers\ChatDTOComposer;
use App\Models\Chat\Contracts\IChatDatabaseRepository;
use App\Models\Chat\DTO\ChatDTO;
use App\Models\Chat\Model;

/**
 * Class DatabaseRepository
 * @package App\Models\Chat\Repositories
 */
final class DatabaseRepository extends BaseDatabaseRepository implements IChatDatabaseRepository
{
    /**
     * DatabaseRepository constructor
     * @param ChatDTOComposer $composer
     */
    public function __construct(private ChatDTOComposer $composer) {}

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
        return 'chats';
    }

    /**
     * @inheritDoc
     */
    public function createChat(ChatDTO $dto): ChatDTO
    {
        $result = $dto;
        $query = $this->getLeaderQuery();

        /**
         * @var Model $model
         */
        $model = $query->create([
            'user_owner_id' => $dto->userOwnerId,
            'name' => $dto->name,
            'type_id' => $dto->typeId
        ]);

        $result->id = $model->id;

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function getChatByName(int $userOwnerId, string $name): ?ChatDTO
    {
        $query = $this->getFollowerQuery();
        $query->where('user_owner_id', $userOwnerId);
        $query->where('name', $name);

        /**
         * @var Model $model
         */
        $model = $query->first();

        if (!$model) {
            return null;
        }

        return $this->composer->getFromModel($model);
    }
}
