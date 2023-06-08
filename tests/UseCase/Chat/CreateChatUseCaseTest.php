<?php

namespace Tests\UseCase\Chat;

use App\Enums\UseCaseSystemNamesEnum;
use App\Models\User;
use App\Models\Chat;
use App\UseCases\Base\Exceptions\UseCaseNotFoundException;
use App\UseCases\Chat\InputDTO\CreateChatInputDTO;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\UseCase\BaseUseCaseTest;

/**
 * Class CreateChatUseCaseTest
 * @package Tests\UseCase\Chat
 */
final class CreateChatUseCaseTest extends BaseUseCaseTest
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
         * @var User\Model $user
         */
        $user = User\Model::query()->create([
            'username' => 'user1',
            'is_anonymous' => true
        ]);

        $inputDto = new CreateChatInputDTO();
        $inputDto->userOwnerId = $user->id;
        $inputDto->name = 'Chat 1';
        $inputDto->typeId = 2;

        $useCase = $this->useCaseFactory->createUseCase(
            UseCaseSystemNamesEnum::CREATE_CHAT
        );
        $useCase->setInputDTO($inputDto);
        $useCase->execute();

        $this->assertNotNull(
            Chat\Model::query()
                ->first()
        );
    }

    /**
     * Test case when chat with name already exists
     *
     * @return void
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function testCaseWhenChatWithNameAlreadyExists(): void
    {
        /**
         * @var User\Model $user
         */
        $user = User\Model::query()->create([
            'username' => 'user1',
            'is_anonymous' => true
        ]);

        $inputDto = new CreateChatInputDTO();
        $inputDto->userOwnerId = $user->id;
        $inputDto->name = 'Chat 1';
        $inputDto->typeId = 2;

        $this->expectException(Chat\Exceptions\ChatWithNameAlreadyExistsException::class);

        $useCase = $this->useCaseFactory->createUseCase(
            UseCaseSystemNamesEnum::CREATE_CHAT
        );
        $useCase->setInputDTO($inputDto);
        $useCase->execute();
        $useCase->execute();
    }
}
