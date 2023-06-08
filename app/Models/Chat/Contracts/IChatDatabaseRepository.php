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
}
