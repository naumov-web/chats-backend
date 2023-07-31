<?php

namespace Tests\UseCase\Chat;

use App\Enums\UseCaseSystemNamesEnum;
use App\Models\User;
use App\Models\Chat;
use App\UseCases\Base\Exceptions\UseCaseNotFoundException;
use App\UseCases\Chat\GetUserChatsUseCase;
use App\UseCases\Chat\InputDTO\GetUserChatsInputDTO;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\UseCase\BaseUseCaseTest;

/**
 * Class GetUserChatsUseCaseTest
 * @package
 */
final class GetUserChatsUseCaseTest extends BaseUseCaseTest
{
    /**
     * Chats data list
     * @var array|array[]
     */
    protected array $chatsData = [
        [
            'name' => 'Secret',
            'type_id' => 2,
        ],
        [
            'name' => 'Public',
            'type_id' => 1,
        ],
    ];

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
        // 1. Create users
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

        // 2. Create chats for first user
        foreach ($this->chatsData as $chatData) {
            Chat\Model::query()->create(
                array_merge(
                    $chatData,
                    [
                        'user_owner_id' => $user1->id,
                    ]
                )
            );
        }

        // 3. Try to get chats for first user
        $inputDto = new GetUserChatsInputDTO();
        $inputDto->user = $user1;
        $inputDto->sortBy = 'name';
        $inputDto->sortDirection = 'asc';

        /** @var GetUserChatsUseCase $useCase */
        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::GET_USER_CHATS);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();

        $outputDto = $useCase->getOutputDto();

        $this->assertEquals(
            $this->chatsData[1]['name'],
            $outputDto->items[0]->name
        );
        $this->assertEquals(
            $this->chatsData[0]['name'],
            $outputDto->items[1]->name
        );
        $this->assertEquals(
            2,
            $outputDto->count
        );

        // 4. Try to get chats for second user
        $inputDto = new GetUserChatsInputDTO();
        $inputDto->user = $user2;

        /** @var GetUserChatsUseCase $useCase */
        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::GET_USER_CHATS);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();

        $outputDto = $useCase->getOutputDto();

        $this->assertEquals(
            0,
            $outputDto->count
        );
    }
}
