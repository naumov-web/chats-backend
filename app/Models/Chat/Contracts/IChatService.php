<?php

namespace App\Models\Chat\Contracts;

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
}
