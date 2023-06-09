<?php

namespace App\UseCases\User;

use App\Models\User\Contracts\IUserService;
use App\Models\User\DTO\UserAuthDTO;
use App\Models\User\DTO\UserDTO;
use App\UseCases\User\OutputDTO\RegisterUserOutputDTO;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class RegisterRandomUserUseCase
 * @package App\UseCases\User
 */
final class RegisterRandomUserUseCase extends BaseUserUseCase
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
        return null;
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        $userDto = new UserDTO();
        $userDto->username = Str::orderedUuid();
        $userDto->isAnonymous = true;

        $userDto = $this->service->create($userDto);
        $token = $this->getUserToken($userDto);

        $this->outputDto = new RegisterUserOutputDTO();
        $this->outputDto->token = $token;
        $this->outputDto->id = $userDto->id;
        $this->outputDto->username = $userDto->username;
    }
}
