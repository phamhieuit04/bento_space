<?php

namespace App\Repositories\Base;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    abstract protected function getModel();

    protected function setModel()
    {
        $this->model = app()->make($this->getModel());
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
        $model = self::find($id);
        $update = $model->update($attribute);

        return $update ? $this->model->find($id) : null;
    }

    public function delete($id)
    {
        $delete = self::find($id)->delete();

        return $delete ? true : false;
    }

    public function firstOrCreate(array $attributes, array $values)
    {
        $model = self::findWhere($attributes);

        return blank($model) ? self::create($values) : $model;
    }

    public function updateOrCreate(array $attributes, array $values)
    {
        $model = self::findWhere($attributes);

        return !blank($model) ?
            self::update($values, $model->id) :
            self::create($values);
    }

    public function search(string $column, $value)
    {
        $collection = $this->model->where($column, 'like', "%$value%")->get();

        return $collection;
    }
}
