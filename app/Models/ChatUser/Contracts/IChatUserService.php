<?php

namespace App\Models\ChatUser\Contracts;

use App\Models\ChatUser\DTO\CreateChatUserDTO;

/**
 * Interface IChatUserService
 * @package App\Models\ChatUser\Contracts
 */
interface IChatUserService
{
    /**
     * Create chat user instance
     *
     * @param CreateChatUserDTO $dto
     * @return void
     */
    public function createChatUser(CreateChatUserDTO $dto): void;
}
