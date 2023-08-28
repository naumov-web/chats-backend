<?php

namespace App\Models\Handbook\DTO;

/**
 * Class DefaultHandbookDTO
 * @package App\Models\Handbook\DTO
 */
final class DefaultHandbookDTO
{
    /**
     * DefaultHandbookDTO constructor
     * @param int $id
     * @param string $name
     */
    public function __construct(public int $id, public string $name) {}
}
