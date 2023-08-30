<?php

namespace Tests\UseCase\Message;

use App\Enums\UseCaseSystemNamesEnum;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use App\UseCases\Base\Exceptions\UseCaseNotFoundException;
use App\UseCases\Chat\CreateChatUseCase;
use App\UseCases\Chat\InputDTO\CreateChatInputDTO;
use App\UseCases\Message\GetMessagesUseCase;
use App\UseCases\Message\InputDTO\CreateMessageInputDTO;
use App\UseCases\Message\InputDTO\GetMessagesInputDTO;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\UseCase\BaseUseCaseTest;

/**
 * Class GetChatMessagesUseCaseTest
 * @package Tests\UseCase\Message
 */
final class GetChatMessagesUseCaseTest extends BaseUseCaseTest
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
        $inputDto = new GetMessagesInputDTO();
        $inputDto->chatId = 1;
        $inputDto->user = $user;

        $this->expectException(Chat\Exceptions\ChatDoesntExistException::class);

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::GET_MESSAGES);
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
        /** @var User\Model $user1 */
        $user1 = User\Model::query()->create([
            'username' => 'user1',
            'is_anonymous' => true
        ]);

        $createChatInputDTO = new CreateChatInputDTO();
        $createChatInputDTO->userOwnerId = $user1->id;
        $createChatInputDTO->name = 'Chat 1';
        $createChatInputDTO->typeId = 1;

        /** @var CreateChatUseCase $createChatUseCase */
        $createChatUseCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CREATE_CHAT);
        $createChatUseCase->setInputDTO($createChatInputDTO);
        $createChatUseCase->execute();

        /** @var User\Model $user2 */
        $user2 = User\Model::query()->create([
            'username' => 'user2',
            'is_anonymous' => true
        ]);

        $inputDto = new GetMessagesInputDTO();
        $inputDto->chatId = $createChatUseCase->getOutputDTO()->id;
        $inputDto->user = $user2;

        $this->expectException(Chat\Exceptions\ForbiddenException::class);

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::GET_MESSAGES);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();
    }

    /**
     * Test success case
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws Chat\Exceptions\ForbiddenException
     * @throws UseCaseNotFoundException
     */
    public function testSuccessCase(): void
    {
        /** @var User\Model $user */
        $user = User\Model::query()->create([
            'username' => 'user1',
            'is_anonymous' => true
        ]);

        $chatId = $this->createChat($user);

        $inputDto = new GetMessagesInputDTO();
        $inputDto->chatId = $chatId;
        $inputDto->user = $user;

        /** @var GetMessagesUseCase $getMessagesUseCase */
        $getMessagesUseCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::GET_MESSAGES);
        $getMessagesUseCase->setInputDTO($inputDto);
        $getMessagesUseCase->execute();

        $this->assertEquals(
            0,
            $getMessagesUseCase->getOutputDto()->count
        );

        $createMessageInputDto = new CreateMessageInputDTO();
        $createMessageInputDto->chatId = $chatId;
        $createMessageInputDto->userId = $user->id;
        $createMessageInputDto->text = 'test message!';

        $createMessageUseCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CREATE_MESSAGE);
        $createMessageUseCase->setInputDTO($createMessageInputDto);
        $createMessageUseCase->execute();

        $getMessagesUseCase->execute();

        $this->assertEquals(
            1,
            $getMessagesUseCase->getOutputDto()->count
        );

        $this->assertEquals(
            $chatId,
            $getMessagesUseCase->getOutputDto()->items[0]->chatId
        );
        $this->assertEquals(
            $user->id,
            $getMessagesUseCase->getOutputDto()->items[0]->userId
        );
        $this->assertEquals(
            $createMessageInputDto->text,
            $getMessagesUseCase->getOutputDto()->items[0]->text
        );
    }

    /**
     * Create chat for specific user
     *
     * @param User\Model $user
     * @return int
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    private function createChat(User\Model $user): int
    {
        $createChatInputDTO = new CreateChatInputDTO();
        $createChatInputDTO->userOwnerId = $user->id;
        $createChatInputDTO->name = 'Chat 1';
        $createChatInputDTO->typeId = 1;

        /** @var CreateChatUseCase $createChatUseCase */
        $createChatUseCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CREATE_CHAT);
        $createChatUseCase->setInputDTO($createChatInputDTO);
        $createChatUseCase->execute();

        return $createChatUseCase->getOutputDTO()->id;
    }
}
