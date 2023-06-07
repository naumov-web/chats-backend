<?php

namespace App\Models\Chat\Composers;

use App\Models\Base\Composers\BaseDTOComposer;
use App\Models\Chat\DTO\ChatDTO;

/**
 * Class ChatDTOComposer
 * @package App\Models\Chat\Composers
 */
final class ChatDTOComposer extends BaseDTOComposer
{

    /**
     * @inheritDoc
     */
    function getDTOClass(): string
    {
        return ChatDTO::class;
    }
}
