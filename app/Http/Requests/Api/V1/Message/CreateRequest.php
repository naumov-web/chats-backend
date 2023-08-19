<?php

namespace App\Http\Requests\Api\V1\Message;

use App\Http\Requests\Api\BaseApiRequest;

/**
 * Class CreateRequest
 * @package App\Http\Requests\Api\V1\Message
 *
 * @property string $text
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
            'text' => [
                'required',
                'string',
            ],
        ];
    }
}
