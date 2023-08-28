<?php

namespace Tests\UseCase\Chat;

use App\Enums\UseCaseSystemNamesEnum;
use App\Models\Chat;
use App\Models\ChatUser;
use App\Models\User;
use App\UseCases\Base\Exceptions\UseCaseNotFoundException;
use App\UseCases\Chat\InputDTO\JoinPublicChatInputDTO;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\UseCase\BaseUseCaseTest;

/**
 * Class JoinPublicChatUseCaseTest
 * @package Tests\UseCase\Chat
 */
final class JoinPublicChatUseCaseTest extends BaseUseCaseTest
{
    /**
     * Test case when chat is not public
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function testCaseWhenChatIsNotPublic(): void
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
            'type_id' => Chat\Enums\TypesEnum::PRIVATE
        ]);

        $inputDto = new JoinPublicChatInputDTO();
        $inputDto->chatId = $chat->id;
        $inputDto->userId = $user2->id;

        $this->expectException(Chat\Exceptions\ChatIsNotPublicException::class);

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::JOIN_PUBLIC_CHAT);
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
            'type_id' => Chat\Enums\TypesEnum::PUBLIC
        ]);

        $inputDto = new JoinPublicChatInputDTO();
        $inputDto->chatId = $chat->id;
        $inputDto->userId = $user2->id;

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::JOIN_PUBLIC_CHAT);
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
     * @throws UseCaseNotFoundException
     * @throws BindingResolutionException
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
            'type_id' => Chat\Enums\TypesEnum::PUBLIC
        ]);

        $inputDto = new JoinPublicChatInputDTO();
        $inputDto->chatId = $chat->id;
        $inputDto->userId = $user2->id;

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::JOIN_PUBLIC_CHAT);
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
