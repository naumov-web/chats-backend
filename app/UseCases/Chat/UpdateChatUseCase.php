<?php

namespace App\UseCases\Chat;

use App\Models\Chat\Contracts\IChatService;
use App\Models\Chat\DTO\ChatDTO;
use App\UseCases\BaseUseCase;
use App\UseCases\Chat\InputDTO\UpdateChatInputDTO;

/**
 * Class UpdateChatUseCase
 * @package App\UseCases\Chat
 */
final class UpdateChatUseCase extends BaseUseCase
{
    /**
     * UpdateChatUseCase construct
     * @param IChatService $chatService
     */
    public function __construct(private IChatService $chatService) {}

    /**
     * @inheritDoc
     */
    protected function getInputDTOClass(): ?string
    {
        return UpdateChatInputDTO::class;
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        /** @var UpdateChatInputDTO $inputDto */
        $inputDto = $this->inputDto;

        $newChatDto = new ChatDTO();
        $newChatDto->id = $inputDto->id;
        $newChatDto->name = $inputDto->name;
        $newChatDto->typeId = $inputDto->typeId;
        $newChatDto->userOwnerId = $inputDto->currentUserId;

        $this->chatService->updateChat($newChatDto);
    }
}
