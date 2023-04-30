<?php

namespace App\Models\User\Services;

use App\Models\User\Contracts\IUserCacheRepository;
use App\Models\User\Contracts\IUserDatabaseRepository;
use App\Models\User\Contracts\IUserService;
use App\Models\User\DTO\UserDTO;
use App\Models\User\Exceptions\UserWithUsernameAlreadyExistsException;
use Illuminate\Support\Facades\Hash;

/**
 * Class Service
 * @package App\Models\User\Services
 */
final class Service implements IUserService
{
    /**
     * Service constructor
     * @param IUserCacheRepository $cacheRepository
     * @param IUserDatabaseRepository $databaseRepository
     */
    public function __construct(
        private IUserCacheRepository $cacheRepository,
        private IUserDatabaseRepository $databaseRepository
    ) {}

    /**
     * @inheritDoc
     * @throws UserWithUsernameAlreadyExistsException
     */
    public function create(UserDTO $dto): UserDTO
    {
        $existingModel = $this->cacheRepository->getUserByUsername($dto->username);

        if ($existingModel) {
            throw new UserWithUsernameAlreadyExistsException();
        }

        if ($dto->password) {
            $dto->password = Hash::make($dto->password);
        }

        return $this->databaseRepository->createUser($dto);
    }


}
