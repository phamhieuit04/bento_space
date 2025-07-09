<?php

namespace App\Repositories\File;

use App\Models\File;
use App\Repositories\Base\BaseRepository;

class FileRepository extends BaseRepository implements FileRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new File());
    }
}