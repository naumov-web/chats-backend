<?php

namespace App\Models\Base\DTO;

/**
 * Class IndexDTO
 * @package App\Models\Base\DTO
 */
class IndexDTO
{
    /**
     * Limit value
     * @var int|null
     */
    public int|null $limit;

    /**
     * Offset value
     * @var int|null
     */
    public int|null $offset;

    /**
     * Sort column name
     * @var string|null
     */
    public string|null $sortBy;

    /**
     * Sort direction
     * @var string|null
     */
    public string|null $sortDirection;

    /**
     * Convert object to string
     *
     * @return string
     */
    public function toString(): string
    {
        $values = [
            'limit' => $this->limit,
            'offset' => $this->offset,
            'sortBy' => $this->sortBy,
            'sortDirection' => $this->sortDirection,
        ];

        return http_build_query(
            array_filter(
                $values
            )
        );
    }
}
