<?php

namespace App\Repositories\File;

interface FileRepositoryInterface
{
    public function search(string $column, string $value);

    public function filter(string $filter, array $orderBy = null);
}
