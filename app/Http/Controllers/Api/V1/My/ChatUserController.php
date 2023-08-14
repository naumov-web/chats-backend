<?php

namespace App\Http\Controllers\Api\V1\My;

use App\Enums\UseCaseSystemNamesEnum;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\V1\ChatUser\CreateChatUserRequest;
use App\Models\Chat\Exceptions\ChatDoesntExistException;
use App\Models\Chat\Exceptions\ForbiddenException;
use App\Models\ChatUser\Exceptions\ChatUserAlreadyExistsException;
use App\Models\User\Model;
use App\UseCases\Base\Exceptions\UseCaseNotFoundException;
use App\UseCases\ChatUser\InputDTO\CreateChatUserInputDTO;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class ChatUserController
 * @package App\Http\Controllers\Api\V1
 */
final class ChatUserController extends BaseApiController
{
    /**
     * Handle request to create chat user
     *
     * @param CreateChatUserRequest $request
     * @param int $chatId
     * @return JsonResponse
     * @throws UseCaseNotFoundException
     * @throws BindingResolutionException
     */
    public function create(CreateChatUserRequest $request, int $chatId): JsonResponse
    {
        /** @var Model $user */
        $user = auth()->user();
        $inputDto = new CreateChatUserInputDTO();
        $inputDto->chatId = $chatId;
        $inputDto->userId = $request->userId;
        $inputDto->currentUserId = $user->id;

        try {
            $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CREATE_CHAT_USER);
            $useCase->setInputDTO($inputDto);
            $useCase->execute();
        } catch (ChatUserAlreadyExistsException) {
            return \response()->json(
                [
                    'success' => false,
                    'message' => __('messages.char_user_already_exists')
                ],
                Response::HTTP_BAD_REQUEST
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

        return response()->json(
            [
                'success' => true,
                'message' => __('messages.chat_user_created_successfully')
            ]
        );
    }
}
