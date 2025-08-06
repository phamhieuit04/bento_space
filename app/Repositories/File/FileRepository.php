<?php

namespace App\Repositories\File;

use App\Enums\Drive\TrashedStatus;
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
            ->where('trashed', TrashedStatus::NOT_TRASHED->value)
            ->orderBy('updated_at', 'desc')->get();
    }

    public function trashed()
    {
        return $this->file->where('user_id', Auth::id())
            ->where('trashed', TrashedStatus::TRASHED->value)
            ->orderBy('updated_at', 'desc')->get();
    }
}
