<?php

use App\Enums\UseCaseSystemNamesEnum;
use App\UseCases\User\RegisterRandomUserUseCase;

return [
    'mapping' => [
        UseCaseSystemNamesEnum::REGISTER_RANDOM_USER => RegisterRandomUserUseCase::class,
    ]
];
