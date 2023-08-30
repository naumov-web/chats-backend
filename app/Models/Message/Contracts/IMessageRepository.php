<?php

namespace App\Models\Message\Contracts;

use App\Models\Base\DTO\IndexDTO;
use App\Models\Base\DTO\ListDTO;

/**
 * Interface IMessageRepository
 * @package App\Models\Message\Contracts
 */
interface IMessageRepository
{
    /**
     * Get messages of specific chat
     *
     * @param int $chatId
     * @param IndexDTO $indexDto
     * @return ListDTO
     */
    public function index(int $chatId, IndexDTO $indexDto): ListDTO;
}
