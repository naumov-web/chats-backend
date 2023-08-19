<?php

namespace App\UseCases\Chat;

use App\Models\Chat\Contracts\IChatService;
use App\Models\Chat\DTO\ChatDTO;
use App\Models\ChatUser\Contracts\IChatUserService;
use App\Models\ChatUser\DTO\CreateChatUserDTO;
use App\UseCases\BaseUseCase;
use App\UseCases\Chat\InputDTO\CreateChatInputDTO;

/**
 * Class CreateChatUseCase
 * @package App\UseCases\Chat
 */
final class CreateChatUseCase extends BaseUseCase
{
    /**
     * Output DTO instance
     * @var ChatDTO
     */
    private ChatDTO $outputDto;

    /**
     * CreateChatUseCase constructor
     * @param IChatService $chatService
     * @param IChatUserService $chatUserService
     */
    public function __construct(private IChatService $chatService, private IChatUserService $chatUserService) {}

    /**
     * @inheritDoc
     */
    protected function getInputDTOClass(): ?string
    {
        return CreateChatInputDTO::class;
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        /** @var CreateChatInputDTO $inputDto */
        $inputDto = $this->inputDto;
        $chatDto = new ChatDTO();
        $chatDto->userOwnerId = $inputDto->userOwnerId;
        $chatDto->name = $inputDto->name;
        $chatDto->typeId = $inputDto->typeId;

        $this->outputDto = $this->chatService->createChat($chatDto);

        $this->createChatUser();
    }

    /**
     * Get output DTO
     *
     * @return ChatDTO
     */
    public function getOutputDTO(): ChatDTO
    {
        return $this->outputDto;
    }

    /**
     * Create chat user instance
     *
     * @return void
     */
    private function createChatUser(): void
    {
        /** @var CreateChatInputDTO $inputDto */
        $inputDto = $this->inputDto;
        $createChatUserDto = new CreateChatUserDTO();
        $createChatUserDto->userId = $inputDto->userOwnerId;
        $createChatUserDto->chatId = $this->outputDto->id;

        $this->chatUserService->createChatUser($createChatUserDto);
    }
}
