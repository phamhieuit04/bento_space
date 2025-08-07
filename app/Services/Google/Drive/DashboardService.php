<?php

namespace App\Services\Google\Drive;

use App\Enums\Drive\TrashedStatus;
use App\Facades\Google\GoogleDriveFacade;
use App\Repositories\File\FileRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardService
{
    public function __construct(private FileRepositoryInterface $fileRepo) {}

    public function all()
    {
        $data = collect([
            'folders' => collect([]),
            'files' => collect([])
        ]);
        $rootId = Auth::user()->root_id;
        $this->fileRepo->all()->each(function ($item) use ($data, $rootId) {
            if (!blank($item->parents_id) && $item->parents_id->contains($rootId)) {
                $item->mime_type == 'application/vnd.google-apps.folder' ?
                    $data['folders']->push($item) :
                    $data['files']->push($item);
            }
        });
        return $data;
    }

    public function create(string $name)
    {
        try {
            $data = GoogleDriveFacade::createFolder($name);
            $folder = GoogleDriveFacade::find($data['id']);
            $this->fileRepo->create([
                'drive_id' => $folder['id'],
                'user_id' => Auth::id(),
                'parents_id' => $folder['parents'] ?? null,
                'name' => $folder['name'],
                'size' => 0,
                'download_url' => null,
                'video_url' => null,
                'thumbnail_url' => asset('assets/default.png'),
                'icon_url' => $folder['iconLink'] ?? null,
                'mime_type' => $folder['mimeType'],
                'extension' => null,
                'trashed' => TrashedStatus::NOT_TRASHED,
                'created_at' => $folder['createdTime'],
                'updated_at' => $folder['modifiedTime'],
                'trashed_at' => null
            ]);
            return true;
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    public function upload(UploadedFile $file)
    {
        try {
            $driveFile = GoogleDriveFacade::upload($file);
            GoogleDriveFacade::update(
                $driveFile['id'],
                ['name' => $file->getClientOriginalName()]
            );
            return !$this->sync() ? false : true;
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    public function sync()
    {
        try {
            foreach (GoogleDriveFacade::all() as $file) {
                $this->fileRepo->updateOrCreate(['drive_id' => $file['id']], [
                    'drive_id' => $file['id'],
                    'user_id' => Auth::id(),
                    'parents_id' => $file['parents'] ?? null,
                    'name' => $file['name'],
                    'size' => $file['size'] ?? 0,
                    'download_url' => $file['webContentLink'] ?? null,
                    'video_url' => 'https://drive.google.com/file/d/' . $file['id'] . '/preview',
                    'thumbnail_url' => $file['thumbnailLink'] ?? asset('assets/default.png'),
                    'icon_url' => $file['iconLink'] ?? null,
                    'mime_type' => $file['mimeType'],
                    'extension' => $file['fullFileExtension'] ?? null,
                    'trashed' => $file['trashed'] ? TrashedStatus::TRASHED : TrashedStatus::NOT_TRASHED,
                    'created_at' => $file['createdTime'],
                    'updated_at' => $file['modifiedTime'],
                    'trashed_at' => $file['trashedTime'] ?? null
                ]);
            }
            return true;
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    public function show($id)
    {
        $data = collect([
            'folders' => collect([]),
            'files' => collect([])
        ]);
        $this->fileRepo->all()->each(function ($item) use ($data, $id) {
            if (collect($item->parents_id)->contains($id)) {
                $item->mime_type == 'application/vnd.google-apps.folder' ?
                    $data['folders']->push($item) :
                    $data['files']->push($item);
            }
        });
        return $data;
    }

    public function search(string $name)
    {
        $data = collect([
            'files' => collect([]),
            'folders' => collect([])
        ]);
        foreach (GoogleDriveFacade::search($name) as $item) {
            $file = $this->fileRepo->findBy('drive_id', $item['id']);
            $file->mime_type == 'application/vnd.google-apps.folder'
                ? $data['folders']->push($file)
                : $data['files']->push($file);
        }
        return $data;
    }
}
