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
    ) {
    }

    public function all()
    {
        $data = collect([
            TrashedDate::TODAY->value => collect([]),
            TrashedDate::YESTERDAY->value => collect([]),
            TrashedDate::LONG_TIME_AGO->value => collect([])
        ]);
        foreach ($this->fileRepo->filter('trashed', ['updated_at', 'desc']) as $item) {
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
            $file = $this->fileRepo->findBy('drive_id', $id);
            !$restore ? GoogleDriveFacade::delete($id) : GoogleDriveFacade::restore($id);
            $update = $this->fileRepo->update(
                [
                    'trashed' => !$restore ? TrashedStatus::TRASHED : TrashedStatus::NOT_TRASHED,
                    'updated_at' => now()
                ],
                $file->id
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
            $file = $this->fileRepo->findBy('drive_id', $id);
            return $this->fileRepo->delete($file['id']) ? true : false;
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    public function empty()
    {
        try {
            if (!GoogleDriveFacade::emptyTrash()) {
                return false;
            }
            foreach ($this->fileRepo->filter('trashed', ['updated_at', 'desc']) as $item) {
                $this->fileRepo->delete($item['id']);
            }
            return true;
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }
}
