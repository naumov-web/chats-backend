<?php

namespace App\Http\Resources\Api\V1\Message;

use App\Http\Resources\Api\BaseApiResource;
use Illuminate\Http\Request;

/**
 * Class MessageResource
 * @package App\Http\Resources\Api\V1\Message
 */
final class MessageResource extends BaseApiResource
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
            'userId' => $this->userId,
            'chatId' => $this->chatId,
            'text' => $this->text,
            'username' => $this->username,
            'createdAt' => $this->createdAt,
        ];
    }
}
