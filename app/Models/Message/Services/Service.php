<?php

namespace App\Models\Message\Services;

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
     * @param IMessageDatabaseRepository $databaseRepository
     */
    public function __construct(private IMessageDatabaseRepository $databaseRepository) {}

    /**
     * @inheritDoc
     */
    public function create(CreateMessageDTO $dto): void
    {
        $this->databaseRepository->create($dto);
    }
}
