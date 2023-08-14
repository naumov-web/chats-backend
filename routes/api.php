<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/v1')
    ->namespace('App\Http\Controllers\Api\V1')
    ->name('api.v1.')
    ->group(function() {
        Route::prefix('/auth')->group(function () {
            Route::post('register/random-account', 'AuthController@registerRandomUser');
            Route::post('register', 'AuthController@register');
            Route::post('login', 'AuthController@login');
        });

        Route::middleware(['auth.jwt'])->group(function() {
            Route::prefix('/account')->group(function () {
                Route::prefix('/my/chats')->group(function () {
                    Route::post('', 'My\ChatController@create');
                    Route::get('', 'My\ChatController@indexMy');

                    Route::post('/{chatId}/users', 'My\ChatUserController@create');
                });
            });
        });
    });
