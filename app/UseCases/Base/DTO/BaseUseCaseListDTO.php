<?php

namespace App\UseCases\Base\DTO;

use App\Models\Base\DTO\IndexDTO;

/**
 * Class BaseUseCaseListDTO
 * @package App\UseCases\Base\DTO
 */
abstract class BaseUseCaseListDTO extends BaseUseCaseDTO
{
    /**
     * Limit value
     * @var int|null
     */
    public int|null $limit = null;

    /**
     * Offset value
     * @var int|null
     */
    public int|null $offset = null;

    /**
     * Sort column name
     * @var string|null
     */
    public string|null $sortBy = null;

    /**
     * Sort direction
     * @var string|null
     */
    public string|null $sortDirection = null;

    /**
     * Get index DTO instance from current instance
     *
     * @return IndexDTO
     */
    public function getIndexDTO(): IndexDTO
    {
        $indexDto = new IndexDTO();
        $indexDto->limit = $this->limit;
        $indexDto->offset = $this->offset;
        $indexDto->sortBy = $this->sortBy;
        $indexDto->sortDirection = $this->sortDirection;

        return $indexDto;
    }
}
