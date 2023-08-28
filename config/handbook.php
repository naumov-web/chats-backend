<?php

use App\Models\Chat\Enums\TypesEnum;
use App\Models\Handbook\DTO\DefaultHandbookItemDTO;

return [
    'chatTypes' => [
        new DefaultHandbookItemDTO(
            id: TypesEnum::PUBLIC,
            name: __('handbooks.chat_type_public')
        ),
        new DefaultHandbookItemDTO(
            id: TypesEnum::PRIVATE,
            name: __('handbooks.chat_type_private')
        ),
    ]
];
