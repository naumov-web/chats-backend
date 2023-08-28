<?php

namespace App\Models\Handbook\Services;

use App\Models\Handbook\Contracts\IHandbookService;
use App\Models\Handbook\DTO\HandbookDTO;

/**
 * Class Service
 * @package App\Models\Handbook\Service
 */
final class Service implements IHandbookService
{

    /**
     * @inheritDoc
     */
    public function getHandbook(): HandbookDTO
    {
        $result = new HandbookDTO();
        $result->chatTypes = config('handbook.chatTypes');

        return $result;
    }
}
