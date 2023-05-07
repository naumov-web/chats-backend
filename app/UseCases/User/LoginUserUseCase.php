<?php

namespace App\UseCases\User;

use App\UseCases\User\InputDTO\LoginUserInputDTO;
use App\UseCases\User\OutputDTO\LoginUserOutputDTO;

/**
 * Class LoginUserUseCase
 * @package App\UseCases\User
 */
final class LoginUserUseCase extends BaseUserUseCase
{
    /**
     * Output DTO instance
     * @var LoginUserOutputDTO
     */
    private LoginUserOutputDTO $outputDto;

    /**
     * @inheritDoc
     */
    protected function getInputDTOClass(): ?string
    {
        return LoginUserInputDTO::class;
    }

    /**
     * Get output DTO instance
     *
     * @return LoginUserOutputDTO
     */
    public function getOutputDto(): LoginUserOutputDTO
    {
        return $this->outputDto;
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        $this->outputDto = new LoginUserOutputDTO();
        $this->outputDto->token = $this->getUserTokenByCredentials(
            $this->inputDto->username,
            $this->inputDto->password
        );
    }
}
