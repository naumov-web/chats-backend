<?php

namespace App\Models\ChatUser;

use App\Models\BaseDBModel;

/**
 * Class Model
 * @package App\Models\ChatUser
 *
 * @property-read int $id
 * @property-read int $chat_id
 * @property int $user_id
 * @property string $created_at
 */
final class Model extends BaseDBModel
{
    /**
     * Table name for model
     * @var string
     */
    protected $table = 'chat_users';
}
