<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\UseCaseSystemNamesEnum;
use App\Http\Controllers\Api\BaseApiController;
use App\Models\Chat\Exceptions\ChatDoesntExistException;
use App\Models\Chat\Exceptions\ChatIsNotPublicException;
use App\Models\ChatUser\Exceptions\ChatUserAlreadyExistsException;
use App\Models\User\Model;
use App\UseCases\Base\Exceptions\UseCaseNotFoundException;
use App\UseCases\Chat\InputDTO\JoinPublicChatInputDTO;
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
     * Join to specific public chat
     *
     * @param int $chatId
     * @return JsonResponse
     * @throws UseCaseNotFoundException
     * @throws BindingResolutionException
     */
    public function join(int $chatId): JsonResponse
    {
        /** @var Model $user */
        $user = auth()->user();

        $inputDto = new JoinPublicChatInputDTO();
        $inputDto->chatId = $chatId;
        $inputDto->userId = $user->id;

        try {
            $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::JOIN_PUBLIC_CHAT);
            $useCase->setInputDTO($inputDto);
            $useCase->execute();
        } catch (ChatDoesntExistException) {
            return response()->json(
                [
                    'success' => false,
                    'message' => __('messages.not_found')
                ],
                Response::HTTP_NOT_FOUND
            );
        } catch (ChatIsNotPublicException|ChatUserAlreadyExistsException) {
            return response()->json(
                [
                    'success' => false,
                    'message' => __('messages.forbidden')
                ],
                Response::HTTP_FORBIDDEN
            );
        }

        return response()->json(
            [
                'success' => true,
                'message' => __('messages.user_joined_chat')
            ]
        );
    }
}
