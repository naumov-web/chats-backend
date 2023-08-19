<?php

namespace App\Models\Message\Contracts;

use App\Models\Message\DTO\CreateMessageDTO;
use App\Models\Message\DTO\MessageDTO;

/**
 * Interface IMessageService
 * @package App\Models\Message\Contracts
 */
interface IMessageService
{
    /**
     * Create chat message
     *
     * @param CreateMessageDTO $dto
     * @return MessageDTO
     */
    public function create(CreateMessageDTO $dto): void;
}
