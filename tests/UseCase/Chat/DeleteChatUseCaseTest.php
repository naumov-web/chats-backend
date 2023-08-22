<?php

namespace Tests\UseCase\Chat;

use App\Enums\UseCaseSystemNamesEnum;
use App\Models\Chat;
use App\Models\ChatUser;
use App\Models\Message;
use App\Models\User;
use App\UseCases\Base\Exceptions\UseCaseNotFoundException;
use App\UseCases\Chat\CreateChatUseCase;
use App\UseCases\Chat\InputDTO\CreateChatInputDTO;
use App\UseCases\Chat\InputDTO\DeleteChatInputDTO;
use App\UseCases\Message\InputDTO\CreateMessageInputDTO;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\UseCase\BaseUseCaseTest;

/**
 * Class DeleteChatUseCaseTest
 * @package Tests\UseCase\Chat
 */
final class DeleteChatUseCaseTest extends BaseUseCaseTest
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

        $deleteChatInputDto = new DeleteChatInputDTO();
        $deleteChatInputDto->id = $creationResult->id;
        $deleteChatInputDto->currentUserId = $user->id + 1000;

        $this->expectException(Chat\Exceptions\ForbiddenException::class);

        $deleteChatUseCase = $this->useCaseFactory->createUseCase(
            UseCaseSystemNamesEnum::DELETE_CHAT
        );
        $deleteChatUseCase->setInputDTO($deleteChatInputDto);
        $deleteChatUseCase->execute();
    }

    /**
     * Test case when chat doesn't exist
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function testCaseWhenChatDoesntExists(): void
    {
        /** @var User\Model $user */
        $user = User\Model::query()->create([
            'username' => 'user1',
            'is_anonymous' => true
        ]);

        $deleteChatInputDto = new DeleteChatInputDTO();
        $deleteChatInputDto->id = 1000;
        $deleteChatInputDto->currentUserId = $user->id;

        $this->expectException(Chat\Exceptions\ChatDoesntExistException::class);

        $deleteChatUseCase = $this->useCaseFactory->createUseCase(
            UseCaseSystemNamesEnum::DELETE_CHAT
        );
        $deleteChatUseCase->setInputDTO($deleteChatInputDto);
        $deleteChatUseCase->execute();
    }

    /**
     * Test success case
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function testSuccessCase(): void
    {
        // 1. Create chat instance
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

        // 2. Create chat message
        $createMessageInputDto = new CreateMessageInputDTO();
        $createMessageInputDto->chatId = $creationResult->id;
        $createMessageInputDto->userId = $user->id;
        $createMessageInputDto->text = 'text message';

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CREATE_MESSAGE);
        $useCase->setInputDTO($createMessageInputDto);
        $useCase->execute();

        // 3. Check that tables "chats", "chat_users", "messages" are not empty
        $this->assertDatabaseHas(
            (new Chat\Model())->getTable(),
            [
                'id' => $creationResult->id,
            ]
        );
        $this->assertDatabaseHas(
            (new ChatUser\Model())->getTable(),
            [
                'chat_id' => $creationResult->id,
                'user_id' => $user->id,
            ]
        );
        $this->assertDatabaseHas(
            (new Message\Model())->getTable(),
            [
                'chat_id' => $creationResult->id,
                'user_id' => $user->id,
                'text' => $createMessageInputDto->text,
            ]
        );

        // 4. Create use case and execute it
        $inputDto = new DeleteChatInputDTO();
        $inputDto->id = $creationResult->id;
        $inputDto->currentUserId = $user->id;

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::DELETE_CHAT);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();

        // 5. Check that tables "chats", "chat_users", "messages" are empty
        $this->assertDatabaseMissing(
            (new Chat\Model())->getTable(),
            [
                'id' => $creationResult->id,
            ]
        );
        $this->assertDatabaseMissing(
            (new ChatUser\Model())->getTable(),
            [
                'chat_id' => $creationResult->id,
                'user_id' => $user->id,
            ]
        );
        $this->assertDatabaseMissing(
            (new Message\Model())->getTable(),
            [
                'chat_id' => $creationResult->id,
                'user_id' => $user->id,
                'text' => $createMessageInputDto->text,
            ]
        );
    }
}
