<?php

namespace Tests\UseCase\Message;

use App\Enums\UseCaseSystemNamesEnum;
use App\Models\Chat;
use App\Models\ChatUser;
use App\Models\Message;
use App\Models\User;
use App\UseCases\Base\Exceptions\UseCaseNotFoundException;
use App\UseCases\Chat\CreateChatUseCase;
use App\UseCases\Chat\InputDTO\CreateChatInputDTO;
use App\UseCases\Message\InputDTO\CreateMessageInputDTO;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\UseCase\BaseUseCaseTest;

/**
 * Class CreateMessageUseCaseTest
 * @package Tests\UseCase\Message
 */
final class CreateMessageUseCaseTest extends BaseUseCaseTest
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
        $inputDto = new CreateMessageInputDTO();
        $inputDto->chatId = 1;
        $inputDto->userId = 1;
        $inputDto->text = 'text';

        $this->expectException(Chat\Exceptions\ChatDoesntExistException::class);

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CREATE_MESSAGE);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();
    }

    /**
     * Test case when chat user doesn't exist
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function testCaseWhenChatUserDoesntExist(): void
    {
        /** @var User\Model $user */
        $user = User\Model::query()->create([
            'username' => 'user1',
            'is_anonymous' => true
        ]);
        /** @var Chat\Model $chat */
        $chat = Chat\Model::query()->create([
            'user_owner_id' => $user->id,
            'name' => 'Chat',
            'type_id' => 1
        ]);

        $inputDto = new CreateMessageInputDTO();
        $inputDto->chatId = $chat->id;
        $inputDto->userId = 2;
        $inputDto->text = 'text';

        $this->expectException(Message\Exceptions\ChatUserDoesntExistException::class);

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CREATE_MESSAGE);
        $useCase->setInputDTO($inputDto);
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
        /** @var User\Model $user */
        $user = User\Model::query()->create([
            'username' => 'user1',
            'is_anonymous' => true
        ]);

        $createChatInputDTO = new CreateChatInputDTO();
        $createChatInputDTO->userOwnerId = $user->id;
        $createChatInputDTO->name = 'Chat 1';
        $createChatInputDTO->typeId = 1;

        /** @var CreateChatUseCase $createChatUseCase */
        $createChatUseCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CREATE_CHAT);
        $createChatUseCase->setInputDTO($createChatInputDTO);
        $createChatUseCase->execute();

        $inputDto = new CreateMessageInputDTO();
        $inputDto->chatId = $createChatUseCase->getOutputDTO()->id;
        $inputDto->userId = $user->id;
        $inputDto->text = 'text';

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CREATE_MESSAGE);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();

        $this->assertDatabaseHas(
            (new Message\Model())->getTable(),
            [
                'chat_id' => $inputDto->chatId,
                'user_id' => $inputDto->userId,
                'text' => $inputDto->text,
            ]
        );
    }
}
