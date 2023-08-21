<?php

namespace App\Models\Chat\Contracts;

use App\Models\Chat\DTO\ChatDTO;

/**
 * Interface IChatDatabaseRepository
 */
interface IChatDatabaseRepository extends IChatRepository
{
    /**
     * Store chat instance to database
     *
     * @param ChatDTO $dto
     * @return ChatDTO
     */
    public function createChat(ChatDTO $dto): ChatDTO;

    /**
     * Get chat instance by name for specific user
     *
     * @param int $userOwnerId
     * @param string $name
     * @return ChatDTO|null
     */
    public function getChatByName(int $userOwnerId, string $name): ?ChatDTO;

    /**
     * Get chat instance by name for specific user exclude specific id
     *
     * @param int $userOwnerId
     * @param string $name
     * @param int $excludeId
     * @return ChatDTO|null
     */
    public function getChatByNameExcludeId(int $userOwnerId, string $name, int $excludeId): ?ChatDTO;

    /**
     * Update specific chat
     *
     * @param ChatDTO $dto
     * @return ChatDTO
     */
    public function updateChat(ChatDTO $dto): ChatDTO;
}
