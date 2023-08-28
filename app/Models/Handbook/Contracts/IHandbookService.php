<?php

namespace App\Models\Handbook\Contracts;

use App\Models\Handbook\DTO\HandbookDTO;

/**
 * Interface IHandbookService
 * @package App\Models\Handbook\Contracts
 */
interface IHandbookService
{
    /**
     * Get handbook
     *
     * @return HandbookDTO
     */
    public function getHandbook(): HandbookDTO;
}
