<?php

namespace Tests\UseCase\User;

use App\Enums\UseCaseSystemNamesEnum;
use App\Models\User\Model;
use App\UseCases\Base\Exceptions\UseCaseNotFoundException;
use App\UseCases\User\RegisterRandomUserUseCase;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\UseCase\BaseUseCaseTest;

/**
 * Class RegisterRandomUserUseCaseTest
 * @package Tests\UseCase\User
 */
final class RegisterRandomUserUseCaseTest extends BaseUseCaseTest
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
        /**
         * @var RegisterRandomUserUseCase $useCase
         */
        $useCase = $this->useCaseFactory->createUseCase(
            UseCaseSystemNamesEnum::REGISTER_RANDOM_USER
        );
        $useCase->execute();

        $outputDto = $useCase->getOutputDto();

        $this->assertNotNull($outputDto->token);
        $this->assertNotNull($outputDto->username);

        $this->assertNotNull(
            Model::query()->where('username', $outputDto->username)->first()
        );
    }
}
