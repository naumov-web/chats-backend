<?php

namespace App\Models\Chat\Contracts;

use App\Models\Base\DTO\IndexDTO;
use App\Models\Base\DTO\ListDTO;
use App\Models\Chat\DTO\ChatDTO;

/**
 * Interface IChatService
 * @package App\Models\Chat\Contracts
 */
interface IChatService
{
    /**
     * Create chat instance
     *
     * @param ChatDTO $dto
     * @return ChatDTO
     */
    public function createChat(ChatDTO $dto): ChatDTO;

    /**
     * Get chats, which belong to specific user
     *
     * @param int $userId
     * @param IndexDTO $indexDto
     * @return ListDTO
     */
    public function getUserChats(int $userId, IndexDTO $indexDto): ListDTO;
}
