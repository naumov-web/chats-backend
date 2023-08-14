<?php

namespace App\Models\Chat\Contracts;

use App\Models\Base\DTO\IndexDTO;
use App\Models\Base\DTO\ListDTO;
use App\Models\Chat\DTO\ChatDTO;

/**
 * Interface IChatRepository
 * @package App\Models\Chat\Contracts
 */
interface IChatRepository
{
    /**
     * Get chat instance by name for specific user
     *
     * @param int $userOwnerId
     * @param string $name
     * @return ChatDTO|null
     */
    public function getChatByName(int $userOwnerId, string $name): ?ChatDTO;

    /**
     * Get chats which belong to specific user
     *
     * @param int $userOwnerId
     * @param IndexDTO $indexDto
     * @return ListDTO
     */
    public function getUserChats(int $userOwnerId, IndexDTO $indexDto): ListDTO;

    /**
     * Get chat by id
     *
     * @param int $chatId
     * @return ChatDTO|null
     */
    public function getChat(int $chatId): ?ChatDTO;
}
