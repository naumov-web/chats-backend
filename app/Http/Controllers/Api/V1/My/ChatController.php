<?php

namespace App\Http\Controllers\Api\V1\My;

use App\Enums\UseCaseSystemNamesEnum;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\V1\Chat\CreateRequest;
use App\Http\Requests\Api\V1\Chat\IndexMyRequest;
use App\Http\Requests\Api\V1\Chat\UpdateRequest;
use App\Http\Resources\Api\ListResource;
use App\Http\Resources\Api\V1\Chat\ChatResource;
use App\Models\Chat\Exceptions\ChatDoesntExistException;
use App\Models\Chat\Exceptions\ChatWithNameAlreadyExistsException;
use App\Models\Chat\Exceptions\ForbiddenException;
use App\Models\User\Model;
use App\UseCases\Base\Exceptions\UseCaseNotFoundException;
use App\UseCases\Chat\CreateChatUseCase;
use App\UseCases\Chat\GetUserChatsUseCase;
use App\UseCases\Chat\InputDTO\CreateChatInputDTO;
use App\UseCases\Chat\InputDTO\DeleteChatInputDTO;
use App\UseCases\Chat\InputDTO\GetUserChatsInputDTO;
use App\UseCases\Chat\InputDTO\UpdateChatInputDTO;
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
        /** @var Model $user */
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

    /**
     * Handle request to get user's chats
     *
     * @param IndexMyRequest $request
     * @return ListResource
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function indexMy(IndexMyRequest $request): ListResource
    {
        /** @var Model $user */
        $user = auth()->user();
        $inputDto = new GetUserChatsInputDTO();
        $inputDto->user = $user;
        $inputDto->limit = $request->limit;
        $inputDto->offset = $request->offset;
        $inputDto->sortBy = $request->sortBy;
        $inputDto->sortDirection = $request->sortDirection;

        /** @var GetUserChatsUseCase $useCase */
        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::GET_USER_CHATS);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();

        $outputDto = $useCase->getOutputDto();

        return (new ListResource(null))
            ->setCount($outputDto->count)
            ->setItems($outputDto->items)
            ->setResourceClassName(ChatResource::class)
            ->setMessage(__('messages.chats_list_loaded_successfully'));
    }

    /**
     * Handle request to update specific chat
     *
     * @param UpdateRequest $request
     * @param int $chatId
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function update(UpdateRequest $request, int $chatId): JsonResponse
    {
        /** @var Model $user */
        $user = auth()->user();

        $inputDto = new UpdateChatInputDTO();
        $inputDto->id = $chatId;
        $inputDto->currentUserId = $user->id;
        $inputDto->name = $request->name;
        $inputDto->typeId = $request->typeId;

        try {
            $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::UPDATE_CHAT);
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
        } catch (ChatDoesntExistException) {
            return response()->json(
                [
                    'success' => false,
                    'message' => __('messages.not_found'),
                ],
                Response::HTTP_NOT_FOUND
            );
        } catch (ForbiddenException) {
            return response()->json(
                [
                    'success' => false,
                    'message' => __('messages.forbidden'),
                ],
                Response::HTTP_FORBIDDEN
            );
        }

        return \response()->json([
            'success' => true,
            'message' => __('messages.chat_updated_successfully')
        ]);
    }

    /**
     * Handle request to delete specific chat
     *
     * @param int $chatId
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function delete(int $chatId): JsonResponse
    {
        /** @var Model $user */
        $user = auth()->user();

        $inputDto = new DeleteChatInputDTO();
        $inputDto->id = $chatId;
        $inputDto->currentUserId = $user->id;

        try {
            $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::DELETE_CHAT);
            $useCase->setInputDTO($inputDto);
            $useCase->execute();
        } catch (ChatDoesntExistException) {
            return response()->json(
                [
                    'success' => false,
                    'message' => __('messages.not_found'),
                ],
                Response::HTTP_NOT_FOUND
            );
        } catch (ForbiddenException) {
            return response()->json(
                [
                    'success' => false,
                    'message' => __('messages.forbidden'),
                ],
                Response::HTTP_FORBIDDEN
            );
        }

        return \response()->json([
            'success' => true,
            'message' => __('messages.chat_deleted_successfully')
        ]);
    }
}
