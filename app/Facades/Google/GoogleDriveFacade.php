<?php

namespace App\Facades\Google;

use App\Services\Google\Drive\GoogleDriveService;
use Illuminate\Support\Facades\Facade;

class GoogleDriveFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return GoogleDriveService::class;
    }
}