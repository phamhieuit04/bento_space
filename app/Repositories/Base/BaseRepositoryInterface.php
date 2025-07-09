<?php

namespace App\Repositories\Base;

interface BaseRepositoryInterface
{
    public function all();

    public function find($id);

    public function create(array $attribute);

    public function update(array $attribute, $id);
}