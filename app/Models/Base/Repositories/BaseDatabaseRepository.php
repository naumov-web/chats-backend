<?php

namespace App\Models\Base\Repositories;

use App\Enums\EnvTypesEnum;
use App\Models\Base\DTO\IndexDTO;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class BaseDatabaseRepository
 * @package App\Models\Base\Repositories
 */
abstract class BaseDatabaseRepository
{
    /**
     * Leader database connection name
     * @var string
     */
    protected const LEADER_CONNECTION_NAME = 'database_leader';

    /**
     * Follower database connection name
     * @var string
     */
    protected const FOLLOWER_CONNECTION_NAME = 'database_follower';

    /**
     * Testing database connection name
     * @var string
     */
    protected const TESTING_CONNECTION_NAME = 'sqlite';

    /**
     * Get model class name
     *
     * @return string
     */
    abstract protected function getModelsClass(): string;

    /**
     * Get table name
     *
     * @return string
     */
    abstract protected function getTableName(): string;

    /**
     * Check is current env testing
     *
     * @return bool
     */
    protected function isTesting(): bool
    {
        return config('app.env') === EnvTypesEnum::TESTING;
    }

    /**
     * Get query builder instance to leader database
     *
     * @return Builder
     */
    protected function getLeaderQuery(): Builder
    {
        $className = $this->getModelsClass();
        /**
         * @var Builder $query
         */
        $query = $className::on($this->isTesting() ? self::TESTING_CONNECTION_NAME : self::LEADER_CONNECTION_NAME);

        return $query;
    }

    /**
     * Get query builder instance to follower database
     *
     * @return Builder
     */
    protected function getFollowerQuery(): Builder
    {
        $className = $this->getModelsClass();
        /**
         * @var Builder $query
         */
        $query = $className::on($this->isTesting() ? self::TESTING_CONNECTION_NAME : self::FOLLOWER_CONNECTION_NAME);

        return $query;
    }

    /**
     * Apply pagination and sorting at query
     *
     * @param Builder $query
     * @param IndexDTO $indexDto
     * @return Builder
     */
    protected function applyPaginationAndSorting(Builder $query, IndexDTO $indexDto): Builder
    {
        if (!is_null($indexDto->limit)) {
            $query->limit($indexDto->limit);
        }

        if (!is_null($indexDto->offset)) {
            $query->limit($indexDto->offset);
        }

        if (!is_null($indexDto->sortBy) && !is_null($indexDto->sortDirection)) {
            $query->orderBy(
                $indexDto->sortBy,
                $indexDto->sortDirection
            );
        }

        return $query;
    }
}
