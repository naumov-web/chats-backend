<?php

namespace App\Models\ChatUser\Composers;

use App\Models\Base\Composers\BaseDTOComposer;
use App\Models\ChatUser\DTO\ChatUserDTO;

/**
 * Class ChatUserDTOComposer
 * @package App\Models\ChatUser\Composers
 */
final class ChatUserDTOComposer extends BaseDTOComposer
{

    /**
     * @inheritDoc
     */
    function getDTOClass(): string
    {
        return ChatUserDTO::class;
    }
}
