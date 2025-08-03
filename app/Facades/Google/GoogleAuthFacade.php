<?php

namespace App\Facades\Google;

use App\Services\Google\GoogleAuthService;
use Illuminate\Support\Facades\Facade;

class GoogleAuthFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return GoogleAuthService::class;
    }
}