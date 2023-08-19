<?php

namespace App\Models\Message;

use App\Models\BaseDBModel;

/**
 * Class Model
 * @package App\Models\Message
 *
 * @property-read int $id
 * @property int $chat_id
 * @property int $user_id
 * @property string $text
 * @property string $created_at
 */
final class Model extends BaseDBModel
{
    /**
     * Table name for model
     * @var string
     */
    protected $table = 'messages';
}
