<?php

namespace App\Services\Google\Drive;

use App\Facades\Google\GoogleDriveFacade;
use App\Repositories\File\FileRepositoryInterface;
use Illuminate\Support\Number;

class InfoService
{
    public function __construct(private FileRepositoryInterface $fileRepo)
    {
    }

    public function show($id)
    {
        $file = $this->fileRepo->findBy('drive_id', $id);
        $file->readable_size = Number::fileSize($file->size);
        return $file;
    }

    public function stream($id)
    {
        $mime = $this->fileRepo->findBy('drive_id', $id)->mime_type;
        $content = GoogleDriveFacade::download($id);
        return response($content)
            ->header('Content-Type', $mime);
    }

    public function download($id)
    {
        return GoogleDriveFacade::download($id);
    }

    public function rename($id, string $name)
    {
        try {
            $driveUpdate = GoogleDriveFacade::update($id, $name);
            $file = $this->fileRepo->findBy('drive_id', $id);
            $update = $this->fileRepo->update([
                'name' => $driveUpdate['name'],
                'updated_at' => $driveUpdate['modifiedTime']
            ], $file->id);
            if (blank($update)) {
                return false;
            }
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}