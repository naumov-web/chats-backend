<?php

namespace Tests\UseCase\User;

use App\Enums\UseCaseSystemNamesEnum;
use App\Models\User\Exceptions\UserWithUsernameAlreadyExistsException;
use App\Models\User\Model;
use App\UseCases\Base\Exceptions\UseCaseNotFoundException;
use App\UseCases\User\InputDTO\RegisterUserInputDTO;
use App\UseCases\User\RegisterUserUseCase;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\UseCase\BaseUseCaseTest;

/**
 * Class RegisterUserUseCaseTest
 * @package Tests\UseCase\User;
 */
final class RegisterUserUseCaseTest extends BaseUseCaseTest
{
    /**
     * Test success case
     *
     * @test
     * @return void
     * @throws UseCaseNotFoundException
     * @throws BindingResolutionException
     */
    public function testSuccessCase(): void
    {
        $inputDto = new RegisterUserInputDTO();
        $inputDto->username = 'some-user';
        $inputDto->password = 'some-password';
        /**
         * @var RegisterUserUseCase $useCase
         */
        $useCase = $this->useCaseFactory->createUseCase(
            UseCaseSystemNamesEnum::REGISTER_USER
        );
        $useCase->setInputDTO($inputDto);
        $useCase->execute();

        $outputDto = $useCase->getOutputDto();

        $this->assertEquals(
            $inputDto->username,
            $outputDto->username
        );
        $this->assertNotNull($outputDto->token);
        $this->assertNotNull($outputDto->id);

        $this->assertNotNull(
            Model::query()
                ->where('id', $outputDto->id)
                ->where('username', $outputDto->username)
                ->where('is_anonymous', false)
                ->first()
        );
    }

    /**
     * Test case when user with same username already registered
     *
     * @return void
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function testCaseWhenUserWithNameAlreadyRegistered(): void
    {
        Model::query()->create([
            'username' => 'some-user',
            'is_anonymous' => true
        ]);

        $inputDto = new RegisterUserInputDTO();
        $inputDto->username = 'some-user';
        $inputDto->password = 'some-password';

        $this->expectException(UserWithUsernameAlreadyExistsException::class);

        /**
         * @var RegisterUserUseCase $useCase
         */
        $useCase = $this->useCaseFactory->createUseCase(
            UseCaseSystemNamesEnum::REGISTER_USER
        );
        $useCase->setInputDTO($inputDto);
        $useCase->execute();
    }
}
