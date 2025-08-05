<?php

namespace App\Services\Google\Drive;

use App\Facades\Google\GoogleDriveFacade;
use App\Repositories\File\FileRepositoryInterface;
use Illuminate\Support\Facades\Log;

class TrashService
{
    public function __construct(
        private FileRepositoryInterface $fileRepo,
        private DashboardService $dashboardService
    ) {
    }

    public function all()
    {
        return $this->dashboardService->all(true);
    }

    public function trash($id)
    {
        try {
            GoogleDriveFacade::update($id, ['trashed' => true]);
            if (!$this->dashboardService->sync()) {
                return false;
            }
            return true;
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }
}