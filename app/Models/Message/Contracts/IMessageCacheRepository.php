<?php

namespace App\Models\Message\Contracts;

use App\Models\Base\Contracts\ICacheRepository;

/**
 * Interface IMessageCacheRepository
 * @package App\Models\Message\Contracts
 */
interface IMessageCacheRepository extends IMessageRepository, ICacheRepository
{
    /**
     * Reset chat messages cache by tag
     *
     * @param int $chatId
     * @return void
     */
    public function resetChatMessagesTag(int $chatId): void;
}
