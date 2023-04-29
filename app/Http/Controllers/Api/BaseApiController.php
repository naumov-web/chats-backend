<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\UseCases\UseCaseFactory;

/**
 * Class BaseApiController
 * @package App\Http\Controllers\Api\V1
 */
abstract class BaseApiController extends Controller
{
    /**
     * BaseApiController constructor
     * @param UseCaseFactory $useCaseFactory
     */
    public function __construct(protected UseCaseFactory $useCaseFactory) {}
}
