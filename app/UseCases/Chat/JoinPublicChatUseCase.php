<?php

namespace App\UseCases\Chat;

use App\UseCases\BaseUseCase;
use App\UseCases\Chat\InputDTO\JoinChatInputDTO;

/**
 * Class JoinChatUseCase
 * @package App\UseCases\Chat
 */
final class JoinChatUseCase extends BaseUseCase
{

    /**
     * @inheritDoc
     */
    protected function getInputDTOClass(): ?string
    {
        return JoinChatInputDTO::class;
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        // TODO: Implement execute() method.
    }
}
