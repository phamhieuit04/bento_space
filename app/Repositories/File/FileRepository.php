<?php

namespace App\Repositories\File;

use App\Models\File;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Facades\Auth;

class FileRepository extends BaseRepository implements FileRepositoryInterface
{
    public function __construct(private File $file)
    {
        parent::__construct($file);
    }

    public function all()
    {
        return $this->file->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')->get();
    }
}