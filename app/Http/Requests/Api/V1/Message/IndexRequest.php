<?php

namespace App\Http\Requests\Api\V1\Message;

use App\Http\Requests\Api\BaseListRequest;

/**
 * Class IndexRequest
 * @package App\Http\Requests\Api\V1\Message
 */
final class IndexRequest extends BaseListRequest
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
                'createdAt'
            ]
        );
    }
}
