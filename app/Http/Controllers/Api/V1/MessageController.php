<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\UseCaseSystemNamesEnum;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\V1\Message\CreateRequest;
use App\Models\Chat\Exceptions\ChatDoesntExistException;
use App\Models\Message\Exceptions\ChatUserDoesntExistException;
use App\Models\User\Model;
use App\UseCases\Base\Exceptions\UseCaseNotFoundException;
use App\UseCases\Message\InputDTO\CreateMessageInputDTO;
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
