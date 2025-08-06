<?php

namespace App\Repositories\File;

interface FileRepositoryInterface
{
    public function all();

    public function trashed();
}
