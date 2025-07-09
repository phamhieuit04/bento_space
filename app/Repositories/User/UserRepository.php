<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\Base\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new User());
    }

    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    public function firstOrCreate(array $attributes, array $values)
    {
        $user = User::where($attributes)->first();
        return blank($user) ? $this->create($values) : $user;
    }
}