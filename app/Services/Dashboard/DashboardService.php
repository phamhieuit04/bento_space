<?php

namespace App\Services\Dashboard;

use App\Facades\Google\GoogleDrive;
use App\Repositories\File\FileRepositoryInterface;
use Illuminate\Support\Facades\Auth;

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

    public function sync()
    {
        $driveFiles = GoogleDrive::all();
        foreach ($driveFiles as $file) {
            if (!$this->fileRepo->findBy('drive_id', $file['id'])) {
                $this->fileRepo->create([
                    'drive_id' => $file['id'],
                    'user_id' => Auth::user()->id,
                    'parents_id' => isset($file['parents']) ? $file['parents'] : null,
                    'name' => $file['name'],
                    'size' => isset($file['size']) ? $file['size'] : null,
                    'thumbnail_url' => isset($file['thumbnailLink']) ? $file['thumbnailLink'] : null,
                    'mime_type' => $file['mimeType'],
                    'created_at' => $file['createdTime'],
                    'updated_at' => $file['modifiedTime']
                ]);
            }
        }
        return true;
    }
}