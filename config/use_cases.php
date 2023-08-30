<?php

use App\Enums\UseCaseSystemNamesEnum;
use App\UseCases\Chat\CreateChatUseCase;
use App\UseCases\Chat\DeleteChatUseCase;
use App\UseCases\Chat\GetUserChatsUseCase;
use App\UseCases\Chat\JoinPublicChatUseCase;
use App\UseCases\Chat\UpdateChatUseCase;
use App\UseCases\ChatUser\CreateChatUserUseCase;
use App\UseCases\Handbook\GetHandbookUseCase;
use App\UseCases\Message\CreateMessageUseCase;
use App\UseCases\Message\GetMessagesUseCase;
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
        UseCaseSystemNamesEnum::DELETE_CHAT => DeleteChatUseCase::class,
        UseCaseSystemNamesEnum::JOIN_PUBLIC_CHAT => JoinPublicChatUseCase::class,
        UseCaseSystemNamesEnum::GET_USER_CHATS => GetUserChatsUseCase::class,
        UseCaseSystemNamesEnum::CREATE_CHAT_USER => CreateChatUserUseCase::class,
        UseCaseSystemNamesEnum::CREATE_MESSAGE => CreateMessageUseCase::class,
        UseCaseSystemNamesEnum::GET_MESSAGES => GetMessagesUseCase::class,
        UseCaseSystemNamesEnum::GET_HANDBOOK => GetHandbookUseCase::class,
    ]
];
