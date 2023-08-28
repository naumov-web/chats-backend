<?php

namespace App\Models\Handbook\DTO;

/**
 * Class DefaultHandbookItemDTO
 * @package App\Models\Handbook\DTO
 */
final class DefaultHandbookItemDTO
{
    /**
     * DefaultHandbookDTO constructor
     * @param int $id
     * @param string $translationKeyName
     */
    public function __construct(public int $id, public string $translationKeyName) {}
}
