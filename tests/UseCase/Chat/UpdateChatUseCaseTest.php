<?php

namespace Tests\UseCase\Chat;

use App\Enums\UseCaseSystemNamesEnum;
use App\Models\Chat;
use App\Models\User;
use App\UseCases\Base\Exceptions\UseCaseNotFoundException;
use App\UseCases\Chat\CreateChatUseCase;
use App\UseCases\Chat\InputDTO\CreateChatInputDTO;
use App\UseCases\Chat\InputDTO\UpdateChatInputDTO;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\UseCase\BaseUseCaseTest;

/**
 * Class UpdateChatUseCaseTest
 * @package Tests\UseCase\Chat
 */
final class UpdateChatUseCaseTest extends BaseUseCaseTest
{
    /**
     * Test case when chat doesn't belong to current user
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function testCaseWhenTheChatDoesntBelongToCurrentUser(): void
    {
        /** @var User\Model $user */
        $user = User\Model::query()->create([
            'username' => 'user1',
            'is_anonymous' => true
        ]);

        $createChatInputDto = new CreateChatInputDTO();
        $createChatInputDto->userOwnerId = $user->id;
        $createChatInputDto->name = 'Chat 1';
        $createChatInputDto->typeId = 2;

        /** @var CreateChatUseCase $createChatUseCase */
        $createChatUseCase = $this->useCaseFactory->createUseCase(
            UseCaseSystemNamesEnum::CREATE_CHAT
        );
        $createChatUseCase->setInputDTO($createChatInputDto);
        $createChatUseCase->execute();

        $creationResult = $createChatUseCase->getOutputDTO();

        $updateChatInputDto = new UpdateChatInputDTO();
        $updateChatInputDto->id = $creationResult->id;
        $updateChatInputDto->currentUserId = $user->id + 1000;
        $updateChatInputDto->name = 'New chat name';
        $updateChatInputDto->typeId = 1;

        $this->expectException(Chat\Exceptions\ForbiddenException::class);

        $updateChatUseCase = $this->useCaseFactory->createUseCase(
            UseCaseSystemNamesEnum::UPDATE_CHAT
        );
        $updateChatUseCase->setInputDTO($updateChatInputDto);
        $updateChatUseCase->execute();
    }

    /**
     * Test case when chat with new name already exists
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function testCaseWhenChatWithNewNameAlreadyExists(): void
    {
        /** @var User\Model $user */
        $user = User\Model::query()->create([
            'username' => 'user1',
            'is_anonymous' => true
        ]);

        $createChatInputDto = new CreateChatInputDTO();
        $createChatInputDto->userOwnerId = $user->id;
        $createChatInputDto->name = 'Chat 1';
        $createChatInputDto->typeId = 2;

        /** @var CreateChatUseCase $createChatUseCase */
        $createChatUseCase = $this->useCaseFactory->createUseCase(
            UseCaseSystemNamesEnum::CREATE_CHAT
        );
        $createChatUseCase->setInputDTO($createChatInputDto);
        $createChatUseCase->execute();
        $creationResult = $createChatUseCase->getOutputDTO();

        $createSecondChatInputDto = new CreateChatInputDTO();
        $createSecondChatInputDto->userOwnerId = $user->id;
        $createSecondChatInputDto->name = 'Chat 2';
        $createSecondChatInputDto->typeId = 2;

        $createChatUseCase->setInputDTO($createSecondChatInputDto);
        $createChatUseCase->execute();

        $updateChatInputDto = new UpdateChatInputDTO();
        $updateChatInputDto->id = $creationResult->id;
        $updateChatInputDto->currentUserId = $user->id;
        $updateChatInputDto->name = $createSecondChatInputDto->name;
        $updateChatInputDto->typeId = 1;

        $this->expectException(Chat\Exceptions\ChatWithNameAlreadyExistsException::class);

        $updateChatUseCase = $this->useCaseFactory->createUseCase(
            UseCaseSystemNamesEnum::UPDATE_CHAT
        );
        $updateChatUseCase->setInputDTO($updateChatInputDto);
        $updateChatUseCase->execute();
    }

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
        /** @var User\Model $user */
        $user = User\Model::query()->create([
            'username' => 'user1',
            'is_anonymous' => true
        ]);

        $createChatInputDto = new CreateChatInputDTO();
        $createChatInputDto->userOwnerId = $user->id;
        $createChatInputDto->name = 'Chat 1';
        $createChatInputDto->typeId = 2;

        /** @var CreateChatUseCase $createChatUseCase */
        $createChatUseCase = $this->useCaseFactory->createUseCase(
            UseCaseSystemNamesEnum::CREATE_CHAT
        );
        $createChatUseCase->setInputDTO($createChatInputDto);
        $createChatUseCase->execute();

        $creationResult = $createChatUseCase->getOutputDTO();

        $updateChatInputDto = new UpdateChatInputDTO();
        $updateChatInputDto->id = $creationResult->id;
        $updateChatInputDto->currentUserId = $user->id;
        $updateChatInputDto->name = 'New chat name';
        $updateChatInputDto->typeId = 1;

        $updateChatUseCase = $this->useCaseFactory->createUseCase(
            UseCaseSystemNamesEnum::UPDATE_CHAT
        );
        $updateChatUseCase->setInputDTO($updateChatInputDto);
        $updateChatUseCase->execute();

        $this->assertDatabaseMissing(
            (new Chat\Model())->getTable(),
            [
                'id' => $creationResult->id,
                'user_owner_id' => $createChatInputDto->userOwnerId,
                'name' => $createChatInputDto->name,
                'type_id' => $createChatInputDto->typeId,
            ]
        );
        $this->assertDatabaseHas(
            (new Chat\Model())->getTable(),
            [
                'id' => $creationResult->id,
                'user_owner_id' => $updateChatInputDto->currentUserId,
                'name' => $updateChatInputDto->name,
                'type_id' => $updateChatInputDto->typeId,
            ]
        );
    }
}
