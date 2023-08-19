<?php

namespace App\Http\Requests\Api\V1\ChatUser;

use App\Http\Requests\Api\BaseApiRequest;

/**
 * Class CreateRequest
 * @package App\Http\Requests\Api\V1\ChatUser
 *
 * @property int $userId
 */
final class CreateRequest extends BaseApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'userId' => [
                'required',
                'integer',
            ],
        ];
    }
}
