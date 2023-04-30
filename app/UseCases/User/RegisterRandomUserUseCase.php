<?php

namespace App\UseCases\User;

use App\Models\User\Contracts\IUserService;
use App\Models\User\DTO\UserAuthDTO;
use App\Models\User\DTO\UserDTO;
use App\UseCases\BaseUseCase;
use App\UseCases\User\OutputDTO\RegisterRandomUserOutputDTO;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class RegisterRandomUserUseCase
 * @package App\UseCases\User
 */
final class RegisterRandomUserUseCase extends BaseUseCase
{
    /**
     * Output DTO instance
     * @var RegisterRandomUserOutputDTO
     */
    private RegisterRandomUserOutputDTO $outputDto;

    /**
     * RegisterRandomUserUseCase constructor
     * @param IUserService $service
     */
    public function __construct(private IUserService $service) {}

    /**
     * Get output DTO instance
     *
     * @return RegisterRandomUserOutputDTO
     */
    public function getOutputDto(): RegisterRandomUserOutputDTO
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

        $this->outputDto = new RegisterRandomUserOutputDTO();
        $this->outputDto->token = $token;
        $this->outputDto->id = $userDto->id;
        $this->outputDto->username = $userDto->username;
    }

    /**
     * Get user token string
     *
     * @param UserDTO $userDto
     * @return string
     */
    private function getUserToken(UserDTO $userDto): string
    {
        $userAuthDto = new UserAuthDTO();
        $userAuthDto->id = $userDto->id;
        $userAuthDto->username = $userDto->username;

        $token =  JWTAuth::fromUser($userAuthDto);

        return $token;
    }
}
