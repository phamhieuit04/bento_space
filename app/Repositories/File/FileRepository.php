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

    public function filter(string $filter, array $orderBy = null)
    {
        $collection = $this->model->where('user_id', Auth::id());
        $result = match ($filter) {
            'starred' => $collection->where('starred', StarredStatus::STARRED->value)
                ->where('trashed', TrashedStatus::NOT_TRASHED->value),
            'trashed' => $collection->where('trashed', TrashedStatus::TRASHED->value),
            'all' => $collection->where('trashed', TrashedStatus::NOT_TRASHED->value),
        };
        !blank($orderBy) ?
            $result->orderBy($orderBy[0], $orderBy[1]) :
            $result->orderBy('created_at', 'desc');
        return $result->get();
    }
}
