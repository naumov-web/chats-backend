<?php

namespace App\Models\Chat;

use App\Models\BaseDBModel;

/**
 * Class Model
 * @package App\Models\Chat
 *
 * @property-read int $id
 * @property int $user_owner_id
 * @property string $name
 * @property int $type_id
 * @property string $created_at
 */
final class Model extends BaseDBModel
{
    /**
     * Table name for model
     * @var string
     */
    protected $table = 'chats';
}
