<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\UseCaseSystemNamesEnum;
use App\Http\Controllers\Api\BaseApiController;
use App\Models\Handbook\DTO\DefaultHandbookItemDTO;
use App\UseCases\Base\Exceptions\UseCaseNotFoundException;
use App\UseCases\Handbook\GetHandbookUseCase;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;

/**
 * Class HandbookController
 * @package App\Http\Controllers\Api\V1
 */
final class HandbookController extends BaseApiController
{
    /**
     * Handle request to get handbook
     *
     * @return JsonResponse
     * @throws UseCaseNotFoundException
     * @throws BindingResolutionException
     */
    public function index(): JsonResponse
    {
        /** @var GetHandbookUseCase $useCase */
        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::GET_HANDBOOK);
        $useCase->execute();
        $handbookDto = $useCase->getOutputDto();

        return response()
            ->json([
                'success' => true,
                'message' => __('messages.handbook_loaded_successfully'),
                'chatTypes' => array_map(
                    function(DefaultHandbookItemDTO $item) {
                        return [
                            'id' => $item->id,
                            'name' => __($item->translationKeyName)
                        ];
                    },
                    $handbookDto->chatTypes
                )
            ]);
    }
}
