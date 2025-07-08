<?php

namespace App\Facades\Google;

use App\Services\Google\GoogleDriveService;
use Illuminate\Support\Facades\Facade;

class GoogleDrive extends Facade
{
    protected static function getFacadeAccessor()
    {
        return GoogleDriveService::class;
    }
}