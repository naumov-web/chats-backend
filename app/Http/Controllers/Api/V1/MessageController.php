<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\UseCaseSystemNamesEnum;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\V1\Message\CreateRequest;
use App\Http\Requests\Api\V1\Message\IndexRequest;
use App\Http\Resources\Api\ListResource;
use App\Http\Resources\Api\V1\Message\MessageResource;
use App\Models\Chat\Exceptions\ChatDoesntExistException;
use App\Models\Chat\Exceptions\ForbiddenException;
use App\Models\Message\Exceptions\ChatUserDoesntExistException;
use App\Models\User\Model;
use App\UseCases\Base\Exceptions\UseCaseNotFoundException;
use App\UseCases\Message\GetMessagesUseCase;
use App\UseCases\Message\InputDTO\CreateMessageInputDTO;
use App\UseCases\Message\InputDTO\GetMessagesInputDTO;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class MessageController
 * @package App\Http\Controllers\Api\V1
 */
final class MessageController extends BaseApiController
{
    /**
     * Get list of messages of specific chat
     *
     * @param IndexRequest $request
     * @param int $chatId
     * @return ListResource|JsonResponse
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function index(IndexRequest $request, int $chatId): ListResource|JsonResponse
    {
        try {
            /** @var Model $user */
            $user = auth()->user();
            $inputDto = new GetMessagesInputDTO();
            $inputDto->chatId = $chatId;
            $inputDto->user = $user;
            $inputDto->limit = $request->limit;
            $inputDto->offset = $request->offset;
            $inputDto->sortBy = $request->sortBy;
            $inputDto->sortDirection = $request->sortDirection;

            /** @var GetMessagesUseCase $useCase */
            $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::GET_MESSAGES);
            $useCase->setInputDTO($inputDto);
            $useCase->execute();
        } catch (ForbiddenException) {
            return response()->json(
                [
                    'success' => false,
                    'message' => __('messages.forbidden')
                ],
                Response::HTTP_FORBIDDEN
            );
        } catch (ChatDoesntExistException) {
            return response()->json(
                [
                    'success' => false,
                    'message' => __('messages.not_found')
                ],
                Response::HTTP_NOT_FOUND
            );
        }

        $outputDto = $useCase->getOutputDto();

        return (new ListResource(null))
            ->setCount($outputDto->count)
            ->setItems($outputDto->items)
            ->setResourceClassName(MessageResource::class)
            ->setMessage(__('messages.messages_list_loaded_successfully'));
    }

    /**
     * Handle request to create chat message
     *
     * @param CreateRequest $request
     * @param int $chatId
     * @return JsonResponse
     * @throws UseCaseNotFoundException
     * @throws BindingResolutionException
     */
    public function create(CreateRequest $request, int $chatId): JsonResponse
    {
        /** @var Model $user */
        $user = auth()->user();

        $inputDto = new CreateMessageInputDTO();
        $inputDto->chatId = $chatId;
        $inputDto->userId = $user->id;
        $inputDto->text = $request->text;

        try {
            $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CREATE_MESSAGE);
            $useCase->setInputDTO($inputDto);
            $useCase->execute();
        } catch (ChatUserDoesntExistException) {
            return response()->json(
                [
                    'success' => false,
                    'message' => __('messages.forbidden')
                ],
                Response::HTTP_FORBIDDEN
            );
        } catch (ChatDoesntExistException) {
            return response()->json(
                [
                    'success' => false,
                    'message' => __('messages.not_found')
                ],
                Response::HTTP_NOT_FOUND
            );
        }

        return response()->json([
            'success' => true,
            'message' => __('messages.message_created_successfully')
        ]);
    }
}
