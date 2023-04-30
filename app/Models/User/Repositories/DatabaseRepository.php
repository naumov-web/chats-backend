<?php

namespace App\Models\User\Repositories;

use App\Models\Base\Repositories\BaseDatabaseRepository;
use App\Models\User\Composers\UserDTOComposer;
use App\Models\User\Contracts\IUserDatabaseRepository;
use App\Models\User\DTO\UserDTO;
use App\Models\User\Model;

/**
 * Class DatabaseRepository
 * @package App\Models\User\Repositories
 */
final class DatabaseRepository extends BaseDatabaseRepository implements IUserDatabaseRepository
{
    /**
     * DatabaseRepository constructor
     * @param UserDTOComposer $composer
     */
    public function __construct(private UserDTOComposer $composer) {}

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
        return 'users';
    }

    /**
     * @inheritDoc
     */
    public function getUserByUsername(string $username): ?UserDTO
    {
        $query = $this->getFollowerQuery();
        $query->where('username', $username);
        /**
         * @var Model $model
         */
        $model = $query->first();

        if (!$model) {
            return null;
        }

        return $this->composer->getFromModel($model);
    }

    /**
     * @inheritDoc
     */
    public function createUser(UserDTO $dto): UserDTO
    {
        $result = $dto;
        $query = $this->getLeaderQuery();
        /**
         * @var Model $model
         */
        $model = $query->create([
            'username' => $dto->username,
            'password' => $dto->password,
            'is_anonymous' => $dto->isAnonymous
        ]);

        $result->id = $model->id;

        return $result;
    }
}
