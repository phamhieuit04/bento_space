<?php

namespace App\Services\Google\Drive;

use App\Repositories\File\FileRepositoryInterface;

class StarService
{
    public function __construct(private FileRepositoryInterface $fileRepo) {}

    public function all()
    {
        $data = collect([
            'folders' => collect([]),
            'files' => collect([])
        ]);
        foreach ($this->fileRepo->filter('starred') as $item) {
            $item->mime_type == 'application/vnd.google-apps.folder' ?
                $data['folders']->push($item) :
                $data['files']->push($item);
        }
        return $data;
    }
}
