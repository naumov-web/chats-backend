<?php

namespace App\UseCases\User;

use App\Models\User\Contracts\IUserService;
use App\Models\User\DTO\UserDTO;
use App\UseCases\User\InputDTO\RegisterUserInputDTO;
use App\UseCases\User\OutputDTO\RegisterUserOutputDTO;

/**
 * Class RegisterUserUseCase
 * @package App\UseCases\User
 */
final class RegisterUserUseCase extends BaseUserUseCase
{
    /**
     * Output DTO instance
     * @var RegisterUserOutputDTO
     */
    private RegisterUserOutputDTO $outputDto;

    /**
     * RegisterRandomUserUseCase constructor
     * @param IUserService $service
     */
    public function __construct(private IUserService $service) {}

    /**
     * Get output DTO instance
     *
     * @return RegisterUserOutputDTO
     */
    public function getOutputDto(): RegisterUserOutputDTO
    {
        return $this->outputDto;
    }

    /**
     * @inheritDoc
     */
    protected function getInputDTOClass(): ?string
    {
        return RegisterUserInputDTO::class;
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        /**
         * @var RegisterUserInputDTO $inputDto
         */
        $inputDto = $this->inputDto;

        $userDto = new UserDTO();
        $userDto->username = $inputDto->username;
        $userDto->password = $inputDto->password;
        $userDto->isAnonymous = false;

        $userDto = $this->service->create($userDto);
        $token = $this->getUserToken($userDto);

        $this->outputDto = new RegisterUserOutputDTO();
        $this->outputDto->token = $token;
        $this->outputDto->id = $userDto->id;
        $this->outputDto->username = $userDto->username;
    }
}
