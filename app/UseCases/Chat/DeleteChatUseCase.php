<?php

namespace App\UseCases\Chat;

use App\Models\Chat\Contracts\IChatService;
use App\Models\ChatUser\Contracts\IChatUserService;
use App\Models\Message\Contracts\IMessageService;
use App\UseCases\BaseUseCase;
use App\UseCases\Chat\InputDTO\DeleteChatInputDTO;

/**
 * Class DeleteChatUseCase
 * @package App\UseCases\Chat
 */
final class DeleteChatUseCase extends BaseUseCase
{
    /**
     * DeleteChatUseCase constructor
     * @param IChatService $chatService
     * @param IChatUserService $chatUserService
     * @param IMessageService $messageService
     */
    public function __construct(
        private IChatService $chatService,
        private IChatUserService $chatUserService,
        private IMessageService $messageService
    ) {}

    /**
     * @inheritDoc
     */
    protected function getInputDTOClass(): ?string
    {
        return DeleteChatInputDTO::class;
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        /** @var DeleteChatInputDTO $inputDto */
        $inputDto = $this->inputDto;
        $this->chatService->getUserChat($inputDto->currentUserId, $inputDto->id);
        $this->messageService->deleteChatMessages($inputDto->id);
        $this->chatUserService->deleteChatUsers($inputDto->id);
        $this->chatService->deleteChat($inputDto->id, $inputDto->currentUserId);
    }
}
