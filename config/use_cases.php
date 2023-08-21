<?php

use App\Enums\UseCaseSystemNamesEnum;
use App\UseCases\Chat\CreateChatUseCase;
use App\UseCases\Chat\GetUserChatsUseCase;
use App\UseCases\Chat\UpdateChatUseCase;
use App\UseCases\ChatUser\CreateChatUserUseCase;
use App\UseCases\Message\CreateMessageUseCase;
use App\UseCases\User\LoginUserUseCase;
use App\UseCases\User\RegisterRandomUserUseCase;
use App\UseCases\User\RegisterUserUseCase;

return [
    'mapping' => [
        UseCaseSystemNamesEnum::REGISTER_RANDOM_USER => RegisterRandomUserUseCase::class,
        UseCaseSystemNamesEnum::REGISTER_USER => RegisterUserUseCase::class,
        UseCaseSystemNamesEnum::LOGIN_USER => LoginUserUseCase::class,
        UseCaseSystemNamesEnum::CREATE_CHAT => CreateChatUseCase::class,
        UseCaseSystemNamesEnum::UPDATE_CHAT => UpdateChatUseCase::class,
        UseCaseSystemNamesEnum::GET_USER_CHATS => GetUserChatsUseCase::class,
        UseCaseSystemNamesEnum::CREATE_CHAT_USER => CreateChatUserUseCase::class,
        UseCaseSystemNamesEnum::CREATE_MESSAGE => CreateMessageUseCase::class,
    ]
];
