<?php

namespace App\Models\Message\Composers;

use App\Models\Base\Composers\BaseDTOComposer;
use App\Models\Base\DTO\ModelDTO;
use App\Models\BaseDBModel;
use App\Models\Message\DTO\MessageDTO;
use App\Models\Message\Model;
use Illuminate\Foundation\Auth\User as Authentication;

/**
 * Class MessageDTOComposer
 * @package App\Models\Message\Composers
 */
final class MessageDTOComposer extends BaseDTOComposer
{

    /**
     * @inheritDoc
     */
    function getDTOClass(): string
    {
        return MessageDTO::class;
    }

    /**
     * Get DTO instance from model instance
     *
     * @param BaseDBModel|Authentication $model
     * @return ModelDTO
     */
    public function getFromModel(BaseDBModel|Authentication $model): ModelDTO
    {
        /** @var Model $model */
        $result = new MessageDTO();
        $result->id = $model->id;
        $result->chatId = $model->chat_id;
        $result->userId = $model->user_id;
        $result->text = $model->text;
        $result->username = $model->user->username;
        $result->createdAt = $model->created_at;

        return $result;
    }
}
