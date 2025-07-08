<?php

namespace App\Facades\Google;

use App\Services\Google\GoogleService;
use Illuminate\Support\Facades\Facade;

class Google extends Facade
{
    protected static function getFacadeAccessor()
    {
        return GoogleService::class;
    }
}