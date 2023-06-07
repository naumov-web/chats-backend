<?php

namespace App\Models\Chat\Contracts;

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
}
