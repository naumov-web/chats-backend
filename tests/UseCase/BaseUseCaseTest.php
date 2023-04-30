<?php

namespace Tests\UseCase;

use App\UseCases\UseCaseFactory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

/**
 * Class BaseUseCaseTest
 * @package Tests\UseCase
 */
abstract class BaseUseCaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Use case factory instance
     * @var UseCaseFactory
     */
    protected UseCaseFactory $useCaseFactory;

    /**
     * Init test before execution
     *
     * @return void
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();
        Queue::fake();
        $this->useCaseFactory = app()->make(UseCaseFactory::class);

    }
}
