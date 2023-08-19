<?php

namespace App\Models\Message\Composers;

use App\Models\Base\Composers\BaseDTOComposer;
use App\Models\Message\DTO\MessageDTO;

/**
 * Class MessageDTOComposer
 * @package App\Models\Message\Composers
 */
final class MessageDTOComposer extends BaseDTOComposer
{

    /**
     * @inheritDoc
     */
    function getDTOClass(): string
    {
        return MessageDTO::class;
    }
}
