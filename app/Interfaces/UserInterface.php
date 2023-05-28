<?php

namespace App\Interfaces;

use App\Models\User;

interface UserInterface
{
    public function findMany();

    public function create(array $data) : User;

    public function update(User $user, array $data) : bool;

    public function delete(User $user) : ?bool;
}
