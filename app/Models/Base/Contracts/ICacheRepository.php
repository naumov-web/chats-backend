<?php

namespace App\Models\Base\Contracts;

/**
 * Interface ICacheRepository
 * @package App\Models\Common\Contacts
 */
interface ICacheRepository
{
    /**
     * @return string
     */
    public function getVersionNumber(): string;

    /**
     * Get directory key value
     *
     * @return string
     */
    public function getDirectoryKey(): string;
}
