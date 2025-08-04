<?php

namespace App\Services\Google\Drive;

use App\Facades\Google\GoogleDriveFacade;
use App\Repositories\File\FileRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardService
{
    public function __construct(private FileRepositoryInterface $fileRepo)
    {
    }

    public function all()
    {
        $data = collect([
            'folders' => collect([]),
            'files' => collect([])
        ]);
        $rootId = Auth::user()->root_id;
        $items = $this->fileRepo->all();
        $items->each(function ($item) use ($data, $rootId) {
            if (!blank($item->parents_id)) {
                if ($item->parents_id->contains($rootId)) {
                    $item->mime_type == 'application/vnd.google-apps.folder' ?
                        $data['folders']->push($item) :
                        $data['files']->push($item);
                }
            }
        });
        return $data;
    }

    public function upload(UploadedFile $file)
    {
        try {
            $driveFile = GoogleDriveFacade::upload($file);
            GoogleDriveFacade::update($driveFile['id'], $file->getClientOriginalName());
            if (!$this->sync()) {
                return false;
            }
            return true;
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
                    'size' => $file['size'] ?? null,
                    'video_url' => 'https://drive.google.com/file/d/' . $file['id'] . '/preview',
                    'thumbnail_url' => $file['thumbnailLink'] ?? asset('assets/default.png'),
                    'icon_url' => $file['iconLink'] ?? null,
                    'mime_type' => $file['mimeType'],
                    'created_at' => $file['createdTime'],
                    'updated_at' => $file['modifiedTime']
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
            if ($file->mime_type == 'application/vnd.google-apps.folder') {
                $data['folders']->push($file);
            } else {
                $data['files']->push($file);
            }
        }
        return $data;
    }
}