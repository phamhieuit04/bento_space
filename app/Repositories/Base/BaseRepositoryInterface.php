<?php

namespace App\Repositories\Base;

interface BaseRepositoryInterface
{
    public function all();

    public function find($id);

    public function findBy(string $column, $value);

    public function findWhere(array $attributes);

    public function create(array $attributes);

    public function update(array $attributes, $id);

    public function delete($id);

    public function firstOrCreate(array $attributes, array $values);

    public function updateOrCreate(array $attributes, array $values);

    public function search(string $column, $value);
}
