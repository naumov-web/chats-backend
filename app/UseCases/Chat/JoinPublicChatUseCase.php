<?php

namespace App\UseCases\Chat;

use App\Models\Chat\Contracts\IChatService;
use App\Models\Chat\Enums\TypesEnum;
use App\Models\Chat\Exceptions\ChatIsNotPublicException;
use App\Models\ChatUser\Contracts\IChatUserService;
use App\Models\ChatUser\DTO\CreateChatUserDTO;
use App\Models\ChatUser\Exceptions\ChatUserAlreadyExistsException;
use App\UseCases\BaseUseCase;
use App\UseCases\Chat\InputDTO\JoinPublicChatInputDTO;

/**
 * Class JoinChatUseCase
 * @package App\UseCases\Chat
 */
final class JoinPublicChatUseCase extends BaseUseCase
{
    /**
     * JoinPublicChatUseCase constructor
     * @param IChatService $chatService
     * @param IChatUserService $chatUserService
     */
    public function __construct(private IChatService $chatService, private IChatUserService $chatUserService) {}

    /**
     * @inheritDoc
     */
    protected function getInputDTOClass(): ?string
    {
        return JoinPublicChatInputDTO::class;
    }

    /**
     * @inheritDoc
     * @throws ChatIsNotPublicException
     * @throws ChatUserAlreadyExistsException
     */
    public function execute(): void
    {
        /** @var JoinPublicChatInputDTO $inputDto */
        $inputDto = $this->inputDto;
        $chat = $this->chatService->getChat($inputDto->chatId);

        if ($chat->typeId !== TypesEnum::PUBLIC) {
            throw new ChatIsNotPublicException();
        }

        if ($this->chatUserService->isChatUserExists($inputDto->chatId, $inputDto->userId)) {
            throw new ChatUserAlreadyExistsException();
        }

        $createChatUserDto = new CreateChatUserDTO();
        $createChatUserDto->chatId = $inputDto->chatId;
        $createChatUserDto->userId = $inputDto->userId;

        $this->chatUserService->createChatUser($createChatUserDto);
    }
}
