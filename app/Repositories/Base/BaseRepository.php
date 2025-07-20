<?php

namespace App\Repositories\Base;

use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    public function __construct(protected Model $model)
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
        $model = $this->model->find($id);
        $update = $model->update($attribute);
        return $update ? $this->model->find($id) : null;
    }

    public function firstOrCreate(array $attributes, array $values)
    {
        $model = $this->findWhere($attributes);
        return blank($model) ? $this->create($values) : $model;
    }

    public function updateOrCreate(array $attributes, array $values)
    {
        $model = self::findWhere($attributes);
        return !blank($model) ?
            self::update($values, $model->id) :
            self::create($values);
    }
}