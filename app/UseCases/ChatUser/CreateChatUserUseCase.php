<?php

namespace App\UseCases\ChatUser;

use App\Models\ChatUser;
use App\Models\Chat;
use App\Models\ChatUser\DTO\CreateChatUserDTO;
use App\UseCases\BaseUseCase;
use App\UseCases\ChatUser\InputDTO\CreateChatUserInputDTO;

/**
 * Class CreateChatUserUseCase
 * @package App\UseCases\ChatUser
 */
final class CreateChatUserUseCase extends BaseUseCase
{
    /**
     * CreateChatUserUseCase constructor
     * @param Chat\Contracts\IChatService $chatService
     * @param ChatUser\Contracts\IChatUserService $chatUserService
     */
    public function __construct(
        private Chat\Contracts\IChatService $chatService,
        private ChatUser\Contracts\IChatUserService $chatUserService
    ) {}

    /**
     * @inheritDoc
     */
    protected function getInputDTOClass(): ?string
    {
        return CreateChatUserInputDTO::class;
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        /** @var CreateChatUserInputDTO $inputDto */
        $inputDto = $this->inputDto;
        $this->chatService->getUserChat($inputDto->currentUserId, $inputDto->chatId);

        $createDto = new CreateChatUserDTO();
        $createDto->chatId = $inputDto->chatId;
        $createDto->userId = $inputDto->userId;

        $this->chatUserService->createChatUser($createDto);
    }
}
