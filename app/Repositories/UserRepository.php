<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\User;

class UserRepository implements UserInterface
{
    public function findMany()
    {
        return User::paginate(20);
    }

    public function create(array $data) : User
    {
        $data['password'] = bcrypt($data['password']);
        return User::create($data);
    }

    public function update(User $user, array $data): bool
    {
        return $user->update($data);
    }

    public function delete(User $user): ?bool
    {
        return $user->delete();
    }
}
