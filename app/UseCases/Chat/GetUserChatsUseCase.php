<?php

namespace App\UseCases\Chat;

use App\Models\Base\DTO\IndexDTO;
use App\Models\Base\DTO\ListDTO;
use App\Models\Chat\Contracts\IChatService;
use App\UseCases\BaseUseCase;
use App\UseCases\Chat\InputDTO\GetUserChatsInputDTO;

/**
 * Class GetUserChatsUseCase
 * @package App\UseCases\Chat
 */
final class GetUserChatsUseCase extends BaseUseCase
{
    /**
     * Output DTO instance
     * @var ListDTO
     */
    private ListDTO $outputDto;

    /**
     * GetUserChatsUseCase constructor
     * @param IChatService $service
     */
    public function __construct(private IChatService $service) {}

    /**
     * Get output DTO instance
     *
     * @return ListDTO
     */
    public function getOutputDto(): ListDTO
    {
        return $this->outputDto;
    }

    /**
     * @inheritDoc
     */
    protected function getInputDTOClass(): ?string
    {
        return GetUserChatsInputDTO::class;
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        /**
         * @var GetUserChatsInputDTO $inputDto
         */
        $inputDto = $this->inputDto;
        $indexDto = $inputDto->getIndexDTO();

        $this->outputDto = $this->service->getUserChats(
            $inputDto->user->id,
            $indexDto
        );
    }
}
