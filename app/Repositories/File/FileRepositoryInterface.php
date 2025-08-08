<?php

namespace App\Repositories\File;

interface FileRepositoryInterface
{
    public function all();

    public function trashed();

    public function search(string $column, string $value);
}
