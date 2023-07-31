<?php

namespace App\Http\Resources\Api\V1\Chat;

use App\Http\Resources\Api\BaseApiResource;
use Illuminate\Http\Request;

/**
 * Class ChatResource
 * @package App\Http\Resources\Api\V1\Chat
 */
final class ChatResource extends BaseApiResource
{
    /**
     * Convert object to array
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'typeId' => $this->typeId,
            'createdAt' => $this->createdAt,
        ];
    }
}
