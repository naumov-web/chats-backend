<?php

namespace Tests\UseCase\ChatUser;

use App\Enums\UseCaseSystemNamesEnum;
use App\Models\Chat\Exceptions\ChatDoesntExistException;
use App\Models\Chat;
use App\Models\ChatUser;
use App\Models\User;
use App\UseCases\Base\Exceptions\UseCaseNotFoundException;
use App\UseCases\ChatUser\InputDTO\CreateChatUserInputDTO;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\UseCase\BaseUseCaseTest;

/**
 * Class CreateChatUserUseCaseTest
 * @package Tests\UseCase\ChatUser
 */
final class CreateChatUserUseCaseTest extends BaseUseCaseTest
{
    /**
     * Test case when chat doesn't exist
     *
     * @test
     * @return void
     * @throws UseCaseNotFoundException
     * @throws BindingResolutionException
     */
    public function testCaseWhenChatDoesntExist(): void
    {
        /** @var User\Model $user */
        $user = User\Model::query()->create([
            'username' => 'user1',
            'is_anonymous' => true
        ]);

        $inputDto = new CreateChatUserInputDTO();
        $inputDto->currentUserId = $user->id;
        $inputDto->userId = $user->id;
        $inputDto->chatId = 1;

        $this->expectException(ChatDoesntExistException::class);

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CREATE_CHAT_USER);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();
    }

    /**
     * Test case when user can't create chat user
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function testCaseWhenUserCantCreateChatUser(): void
    {
        /** @var User\Model $user1 */
        $user1 = User\Model::query()->create([
            'username' => 'user1',
            'is_anonymous' => true
        ]);
        /** @var User\Model $user2 */
        $user2 = User\Model::query()->create([
            'username' => 'user2',
            'is_anonymous' => true
        ]);

        /** @var Chat\Model $chat */
        $chat = Chat\Model::query()->create([
            'user_owner_id' => $user1->id,
            'name' => 'Chat',
            'type_id' => 1
        ]);

        $inputDto = new CreateChatUserInputDTO();
        $inputDto->currentUserId = $user2->id;
        $inputDto->userId = $user1->id;
        $inputDto->chatId = $chat->id;

        $this->expectException(Chat\Exceptions\ForbiddenException::class);

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CREATE_CHAT_USER);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();
    }

    /**
     * Test case when chat user already exists
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function testCaseWhenChatUserAlreadyExists(): void
    {
        /** @var User\Model $user1 */
        $user1 = User\Model::query()->create([
            'username' => 'user1',
            'is_anonymous' => true
        ]);
        /** @var User\Model $user2 */
        $user2 = User\Model::query()->create([
            'username' => 'user2',
            'is_anonymous' => true
        ]);

        /** @var Chat\Model $chat */
        $chat = Chat\Model::query()->create([
            'user_owner_id' => $user1->id,
            'name' => 'Chat',
            'type_id' => 1
        ]);

        $inputDto = new CreateChatUserInputDTO();
        $inputDto->currentUserId = $user1->id;
        $inputDto->userId = $user2->id;
        $inputDto->chatId = $chat->id;

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CREATE_CHAT_USER);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();

        $this->assertDatabaseHas(
            (new ChatUser\Model())->getTable(),
            [
                'chat_id' => $chat->id,
                'user_id' => $user2->id,
            ]
        );

        $this->expectException(ChatUser\Exceptions\ChatUserAlreadyExistsException::class);

        $useCase->execute();
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
        /** @var User\Model $user1 */
        $user1 = User\Model::query()->create([
            'username' => 'user1',
            'is_anonymous' => true
        ]);
        /** @var User\Model $user2 */
        $user2 = User\Model::query()->create([
            'username' => 'user2',
            'is_anonymous' => true
        ]);

        /** @var Chat\Model $chat */
        $chat = Chat\Model::query()->create([
            'user_owner_id' => $user1->id,
            'name' => 'Chat',
            'type_id' => 1
        ]);

        $inputDto = new CreateChatUserInputDTO();
        $inputDto->currentUserId = $user1->id;
        $inputDto->userId = $user2->id;
        $inputDto->chatId = $chat->id;

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CREATE_CHAT_USER);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();

        $this->assertDatabaseHas(
            (new ChatUser\Model())->getTable(),
            [
                'chat_id' => $chat->id,
                'user_id' => $user2->id,
            ]
        );
    }
}
