<?php

namespace App\Models\Message\Contracts;

use App\Models\Message\DTO\CreateMessageDTO;
use App\Models\Message\DTO\MessageDTO;

/**
 * Interface IMessageDatabaseRepository
 * @package App\Models\Message\Contracts
 */
interface IMessageDatabaseRepository extends IMessageRepository
{
    /**
     * Create message in database
     *
     * @param CreateMessageDTO $dto
     * @return void
     */
    public function create(CreateMessageDTO $dto): void;
}
