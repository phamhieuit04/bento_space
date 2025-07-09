<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    public function findByEmail(string $email);

    public function firstOrCreate(array $attributes, array $values);
}