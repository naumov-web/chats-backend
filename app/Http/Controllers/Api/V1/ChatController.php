<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\UseCaseSystemNamesEnum;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\V1\Chat\CreateRequest;
use App\Models\Chat\Exceptions\ChatWithNameAlreadyExistsException;
use App\Models\User\Model;
use App\UseCases\Base\Exceptions\UseCaseNotFoundException;
use App\UseCases\Chat\CreateChatUseCase;
use App\UseCases\Chat\InputDTO\CreateChatInputDTO;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class ChatController
 * @package App\Http\Controllers\Api\V1
 */
final class ChatController extends BaseApiController
{
    /**
     * Handle request to create new chat
     *
     * @param CreateRequest $request
     * @return JsonResponse
     * @throws UseCaseNotFoundException
     * @throws BindingResolutionException
     */
    public function create(CreateRequest $request): JsonResponse
    {
        /**
         * @var Model $user
         */
        $user = auth()->user();
        $inputDto = new CreateChatInputDTO();
        $inputDto->name = $request->name;
        $inputDto->typeId = $request->typeId;
        $inputDto->userOwnerId = $user->id;

        try {
            /**
             * @var CreateChatUseCase $useCase
             */
            $useCase = $this->useCaseFactory->createUseCase(
                UseCaseSystemNamesEnum::CREATE_CHAT
            );
            $useCase->setInputDTO($inputDto);
            $useCase->execute();
        } catch (ChatWithNameAlreadyExistsException) {
            return response()->json(
                [
                    'success' => false,
                    'message' => __('messages.chat_with_name_already_exists'),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        $chatDto = $useCase->getOutputDTO();

        return response()->json(
            [
                'success' => true,
                'message' => __('messages.chat_created_successfully'),
                'id' => $chatDto->id,
            ],
            Response::HTTP_CREATED
        );
    }
}
