<?php

namespace App\Models\Base\Repositories;

use App\Models\User\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

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
        $query = $className::on(self::LEADER_CONNECTION_NAME);

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
        $query = $className::on(self::FOLLOWER_CONNECTION_NAME);

        return $query;
    }
}
