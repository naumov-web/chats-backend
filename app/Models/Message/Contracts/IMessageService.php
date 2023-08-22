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
     * @return void
     */
    public function create(CreateMessageDTO $dto): void;

    /**
     * Delete all chat messages
     *
     * @param int $chatId
     * @return void
     */
    public function deleteChatMessages(int $chatId): void;
}
