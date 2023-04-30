<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\UseCaseSystemNamesEnum;
use App\Http\Controllers\Api\BaseApiController;
use App\UseCases\Base\Exceptions\UseCaseNotFoundException;
use App\UseCases\User\RegisterRandomUserUseCase;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class AuthController
 * @package App\Http\Controllers\Api\V1
 */
final class AuthController extends BaseApiController
{
    /**
     * Handle request for registering user with random username
     *
     * @return JsonResponse
     * @throws UseCaseNotFoundException
     * @throws BindingResolutionException
     */
    public function registerRandomUser(): JsonResponse
    {
        /**
         * @var RegisterRandomUserUseCase $useCase
         */
        $useCase = $this->useCaseFactory->createUseCase(
            UseCaseSystemNamesEnum::REGISTER_RANDOM_USER
        );
        $useCase->execute();
        $outputDto = $useCase->getOutputDto();

        return response()->json(
            [
                'success' => true,
                'message' => __('messages.random_user_registered_successfully'),
                'token' => $outputDto->token,
                'username' => $outputDto->username,
            ],
            Response::HTTP_CREATED
        );
    }
}