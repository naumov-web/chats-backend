<?php

namespace App\Models\Message\Contracts;

use App\Models\Base\DTO\IndexDTO;
use App\Models\Base\DTO\ListDTO;
use App\Models\Message\DTO\CreateMessageDTO;

/**
 * Interface IMessageService
 * @package App\Models\Message\Contracts
 */
interface IMessageService
{
    /**
     * Get messages of specific chat
     *
     * @param int $chatId
     * @param IndexDTO $indexDto
     * @return ListDTO
     */
    public function index(int $chatId, IndexDTO $indexDto): ListDTO;

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
