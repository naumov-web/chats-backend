<?php

namespace App\Http\Requests\Api;

/**
 * Class BaseListRequest
 * @package App\Http\Requests\Api
 *
 * @property int|null $limit
 * @property int|null $offset
 * @property string|null $sortBy
 * @property string|null $sortDirection
 */
abstract class BaseListRequest extends BaseApiRequest
{
    /**
     * Get list rules
     *
     * @param array $sortByColumns
     * @return \string[][]
     */
    protected function getListRules(array $sortByColumns = ['id']): array
    {
        return [
            'limit' => [
                'nullable',
                'integer',
            ],
            'offset' => [
                'nullable',
                'integer',
            ],
            'sortBy' => [
                'nullable',
                'string',
                'in:' . implode(',', $sortByColumns)
            ],
            'sortDirection' => [
                'nullable',
                'string',
                'in:asc,desc'
            ],
        ];
    }
}
