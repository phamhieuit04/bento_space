<?php

namespace App\Services\Dashboard;

use App\Facades\Google\GoogleDrive;
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
        $file->image_url = GoogleDrive::getImageUrl($id);
        $file->video_url = GoogleDrive::getVideoUrl($id);
        return $file;
    }

    public function download($id)
    {
        return GoogleDrive::download($id);
    }
}