<?php

namespace Tests\UseCase\User;

use App\Enums\UseCaseSystemNamesEnum;
use App\UseCases\Base\Exceptions\UseCaseNotFoundException;
use App\UseCases\User\Exceptions\InvalidCredentialsException;
use App\UseCases\User\InputDTO\LoginUserInputDTO;
use App\UseCases\User\InputDTO\RegisterUserInputDTO;
use App\UseCases\User\LoginUserUseCase;
use App\UseCases\User\RegisterUserUseCase;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\UseCase\BaseUseCaseTest;

/**
 * Class LoginUserUseCaseTest
 * @package
 */
final class LoginUserUseCaseTest extends BaseUseCaseTest
{
    /**
     * Test case, when we use correct credentials
     *
     * @test
     * @return void
     */
    public function testCaseWhenWeTryToUseCorrectCredentials(): void
    {
        $inputDto = new RegisterUserInputDTO();
        $inputDto->username = 'some-user';
        $inputDto->password = 'some-password';
        $registerUseCase = $this->useCaseFactory->createUseCase(
            UseCaseSystemNamesEnum::REGISTER_USER
        );
        $registerUseCase->setInputDTO($inputDto);
        $registerUseCase->execute();

        $inputDto = new LoginUserInputDTO();
        $inputDto->username = 'some-user';
        $inputDto->password = 'some-password';

        /**
         * @var LoginUserUseCase $loginUseCase
         */
        $loginUseCase = $this->useCaseFactory->createUseCase(
            UseCaseSystemNamesEnum::LOGIN_USER
        );
        $loginUseCase->setInputDTO($inputDto);
        $loginUseCase->execute();

        $this->assertNotNull(
            $loginUseCase->getOutputDto()->token
        );
    }

    /**
     * Test case, when we use invalid credentials
     *
     * @test
     * @return void
     * @throws UseCaseNotFoundException
     * @throws BindingResolutionException
     */
    public function testCaseWhenWeTryToUseInvalidCredentials(): void
    {
        $inputDto = new RegisterUserInputDTO();
        $inputDto->username = 'some-user';
        $inputDto->password = 'some-password';
        $registerUseCase = $this->useCaseFactory->createUseCase(
            UseCaseSystemNamesEnum::REGISTER_USER
        );
        $registerUseCase->setInputDTO($inputDto);
        $registerUseCase->execute();

        $inputDto = new LoginUserInputDTO();
        $inputDto->username = 'some-user';
        $inputDto->password = 'another-password';

        $this->expectException(InvalidCredentialsException::class);

        $loginUseCase = $this->useCaseFactory->createUseCase(
            UseCaseSystemNamesEnum::LOGIN_USER
        );
        $loginUseCase->setInputDTO($inputDto);
        $loginUseCase->execute();
    }
}
