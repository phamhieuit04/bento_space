<?php

namespace App\Repositories\File;

use App\Enums\Drive\TrashedStatus;
use App\Models\File;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Facades\Auth;

class FileRepository extends BaseRepository implements FileRepositoryInterface
{
    protected function getModel()
    {
        return File::class;
    }

    public function all()
    {
        return $this->model->where('user_id', Auth::id())
            ->where('trashed', TrashedStatus::NOT_TRASHED->value)
            ->orderBy('updated_at', 'desc')->get();
    }

    public function trashed()
    {
        return $this->model->where('user_id', Auth::id())
            ->where('trashed', TrashedStatus::TRASHED->value)
            ->orderBy('updated_at', 'desc')->get();
    }

    public function search(string $column, $value)
    {
        $collection = $this->model->where($column, 'like', "%$value%")
            ->where('trashed', TrashedStatus::NOT_TRASHED->value)->get();
        return $collection;
    }
}
