<?php

namespace App\Models\Base\DTO;

use Illuminate\Support\Collection;

/**
 * Class ListDTO
 * @package App\Models\Base\DTO
 */
final class ListDTO
{
    /**
     * Items collection
     * @var Collection
     */
    public Collection $items;

    /**
     * Total count value
     * @var int
     */
    public int $count;
}
