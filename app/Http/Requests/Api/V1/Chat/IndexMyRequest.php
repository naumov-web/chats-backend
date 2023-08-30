<?php

namespace App\Http\Requests\Api\V1\Chat;

use App\Http\Requests\Api\BaseListRequest;

/**
 * Class IndexMyRequest
 * @package App\Http\Requests\Api\V1\Chat
 */
final class IndexMyRequest extends BaseListRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->getListRules(
            [
                'id',
                'name',
                'typeId',
                'createdAt'
            ]
        );
    }
}
