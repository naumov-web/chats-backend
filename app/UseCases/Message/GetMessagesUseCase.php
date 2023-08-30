<?php

namespace App\UseCases\Message;

use App\Models\Base\DTO\ListDTO;
use App\Models\Chat\Contracts\IChatService;
use App\Models\Chat\Exceptions\ForbiddenException;
use App\Models\ChatUser\Contracts\IChatUserService;
use App\Models\Message\Contracts\IMessageService;
use App\UseCases\BaseUseCase;
use App\UseCases\Message\InputDTO\GetMessagesInputDTO;

/**
 * Class GetMessagesUseCase
 * @package App\UseCases\Message
 */
final class GetMessagesUseCase extends BaseUseCase
{
    /**
     * Output DTO instance
     * @var ListDTO
     */
    private ListDTO $outputDto;

    /**
     * GetMessagesUseCase constructor
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
        return GetMessagesInputDTO::class;
    }

    /**
     * @inheritDoc
     * @throws ForbiddenException
     */
    public function execute(): void
    {
        /** @var GetMessagesInputDTO $inputDto */
        $inputDto = $this->inputDto;
        $this->chatService->getChat($inputDto->chatId);
        $isChatUserExists = $this->chatUserService->isChatUserExists($inputDto->chatId, $inputDto->user->id);

        if (!$isChatUserExists) {
            throw new ForbiddenException();
        }

        $this->outputDto = $this->messageService->index(
            $inputDto->chatId,
            $inputDto->getIndexDTO()
        );
    }

    /**
     * Get output DTO instance
     *
     * @return ListDTO
     */
    public function getOutputDto(): ListDTO
    {
        return $this->outputDto;
    }
}
