<?php

use App\Enums\UseCaseSystemNamesEnum;
use App\UseCases\User\LoginUserUseCase;
use App\UseCases\User\RegisterRandomUserUseCase;
use App\UseCases\User\RegisterUserUseCase;

return [
    'mapping' => [
        UseCaseSystemNamesEnum::REGISTER_RANDOM_USER => RegisterRandomUserUseCase::class,
        UseCaseSystemNamesEnum::REGISTER_USER => RegisterUserUseCase::class,
        UseCaseSystemNamesEnum::LOGIN_USER => LoginUserUseCase::class,
    ]
];
