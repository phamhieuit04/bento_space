<?php

namespace App\Repositories\File;

use App\Enums\Drive\StarredStatus;
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

    public function search(string $column, $value)
    {
        $collection = $this->model->where($column, 'like', "%$value%")
            ->where('trashed', TrashedStatus::NOT_TRASHED->value)->get();
        return $collection;
    }

    public function filter(string $filter)
    {
        $collection = $this->model->where('user_id', Auth::id());
        return match ($filter) {
            'starred' => $collection->where('starred', StarredStatus::STARRED->value)
                ->where('trashed', TrashedStatus::NOT_TRASHED->value)
                ->orderBy('updated_at', 'desc')->get(),
            'trashed' => $collection->where('trashed', TrashedStatus::TRASHED->value)
                ->orderBy('updated_at', 'desc')->get(),
            'all' =>  $collection->where('trashed', TrashedStatus::NOT_TRASHED->value)
                ->orderBy('created_at', 'desc')->get()
        };
    }
}
