<?php

namespace App\UseCases\Message;

use App\Models\Chat\Contracts\IChatService;
use App\Models\ChatUser\Contracts\IChatUserService;
use App\Models\Message\Contracts\IMessageService;
use App\Models\Message\DTO\CreateMessageDTO;
use App\Models\Message\Exceptions\ChatUserDoesntExistException;
use App\UseCases\BaseUseCase;
use App\UseCases\Message\InputDTO\CreateMessageInputDTO;

/**
 * Class CreateMessageUseCase
 * @package App\UseCases\Message
 */
final class CreateMessageUseCase extends BaseUseCase
{
    /**
     * CreateMessageUseCase constructor
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
        return CreateMessageInputDTO::class;
    }

    /**
     * @inheritDoc
     * @throws ChatUserDoesntExistException
     */
    public function execute(): void
    {
        /** @var CreateMessageInputDTO $inputDto */
        $inputDto = $this->inputDto;

        $this->chatService->getChat($inputDto->chatId);

        if (!$this->chatUserService->isChatUserExists($inputDto->chatId, $inputDto->userId)) {
            throw new ChatUserDoesntExistException();
        }

        $createMessageDto = new CreateMessageDTO();
        $createMessageDto->chatId = $inputDto->chatId;
        $createMessageDto->userId = $inputDto->userId;
        $createMessageDto->text = $inputDto->text;

        $this->messageService->create($createMessageDto);
    }
}
