<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\UseCaseSystemNamesEnum;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Http\Requests\Api\V1\Auth\RegisterUserRequest;
use App\Models\User\Exceptions\UserWithUsernameAlreadyExistsException;
use App\UseCases\Base\Exceptions\UseCaseNotFoundException;
use App\UseCases\User\Exceptions\InvalidCredentialsException;
use App\UseCases\User\InputDTO\LoginUserInputDTO;
use App\UseCases\User\InputDTO\RegisterUserInputDTO;
use App\UseCases\User\LoginUserUseCase;
use App\UseCases\User\RegisterRandomUserUseCase;
use App\UseCases\User\RegisterUserUseCase;
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

    /**
     * Handle request for registering user with username and password
     *
     * @param RegisterUserRequest $request
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function register(RegisterUserRequest $request): JsonResponse
    {
        $inputDto = new RegisterUserInputDTO();
        $inputDto->username = $request->username;
        $inputDto->password = $request->password;

        /**
         * @var RegisterUserUseCase $useCase
         */
        $useCase = $this->useCaseFactory->createUseCase(
            UseCaseSystemNamesEnum::REGISTER_USER
        );
        $useCase->setInputDTO($inputDto);
        try {
            $useCase->execute();
        } catch (UserWithUsernameAlreadyExistsException) {
            return \response()->json(
                [
                    'errors' => [
                        'username' => __('validation.user_already_registered')
                    ]
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $outputDto = $useCase->getOutputDto();

        return response()->json(
            [
                'success' => true,
                'message' => __('messages.user_registered_successfully'),
                'token' => $outputDto->token,
                'username' => $outputDto->username,
            ],
            Response::HTTP_CREATED
        );
    }

    /**
     * Handle request to authorize user via username and password
     *
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $inputDto = new LoginUserInputDTO();
        $inputDto->username = $request->username;
        $inputDto->password = $request->password;

        try {
            /**
             * @var LoginUserUseCase $useCase
             */
            $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::LOGIN_USER);
            $useCase->setInputDTO($inputDto);
            $useCase->execute();
        } catch (InvalidCredentialsException) {
            return response()->json(
                [
                    'success' => false,
                    'message' => __('messages.invalid_username_or_password'),
                ],
                Response::HTTP_FORBIDDEN
            );
        }

        return response()->json(
            [
                'success' => true,
                'message' => __('messages.user_logged_successfully'),
                'token' => $useCase->getOutputDto()->token,
            ]
        );
    }
}
