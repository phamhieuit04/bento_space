<?php

namespace App\Repositories\Base;

use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    public function __construct(private Model $model)
    {
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function findBy(string $column, $value)
    {
        return $this->model->where($column, $value)->first();
    }

    public function findWhere(array $attributes)
    {
        return $this->model->where($attributes)->first();
    }

    public function create(array $attribute)
    {
        return $this->model->create($attribute);
    }

    public function update(array $attribute, $id)
    {
        $update = $this->model->where('id', $id)->update($attribute);
        return $update ? $this->model->find($id) : null;
    }

    public function firstOrCreate(array $attributes, array $values)
    {
        $model = $this->findWhere($attributes);
        return blank($model) ? $this->create($values) : $model;
    }
}