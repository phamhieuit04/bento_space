<?php

namespace App\Services\Google\Drive;

use App\Enums\Drive\TrashedDate;
use App\Enums\Drive\TrashedStatus;
use App\Facades\Google\GoogleDriveFacade;
use App\Repositories\File\FileRepositoryInterface;
use Illuminate\Support\Facades\Log;

class TrashService
{
    public function __construct(
        private FileRepositoryInterface $fileRepo,
        private DashboardService $dashboardService
    ) {}

    public function all()
    {
        $data = collect([
            TrashedDate::TODAY->value => collect([]),
            TrashedDate::YESTERDAY->value => collect([]),
            TrashedDate::LONG_TIME_AGO->value => collect([])
        ]);
        foreach ($this->fileRepo->trashed() as $item) {
            $key = match (true) {
                $item->updated_at->isToday() => TrashedDate::TODAY->value,
                $item->updated_at->isYesterday() => TrashedDate::YESTERDAY->value,
                default => TrashedDate::LONG_TIME_AGO->value,
            };
            $data[$key]->push($item);
        }
        return $data;
    }

    public function trash($id, bool $restore = false)
    {
        try {
            !$restore ? GoogleDriveFacade::delete($id) : GoogleDriveFacade::restore($id);
            $update = $this->fileRepo->update(
                ['trashed' => !$restore ? TrashedStatus::TRASHED : TrashedStatus::NOT_TRASHED],
                $this->fileRepo->findBy('drive_id', $id)->id
            );
            return blank($update) ? false : true;
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    public function restore($id)
    {
        return $this->trash($id, true);
    }

    public function delete($id)
    {
        try {
            if (!GoogleDriveFacade::hardDelete($id)) {
                return false;
            }
            return $this->fileRepo->delete($id) ? true : false;
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }
}
