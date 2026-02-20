<?php

namespace App\Repositories\Eloquent;

use App\Models\ModelUser;
use App\Repositories\Interfaces\UserInterface;

class UserRepository implements UserInterface
{
    public function getAllUsers()
    {
        $users = ModelUser::all();

        return $users;
    }

    public function getUserById($id)
    {
        $user = ModelUser::find($id);

        return !$user ? null : $user;
    }

    public function createUser(array $data)
    {
        $user = ModelUser::create($data);

        return $user;
    }

    public function updateUser($id, array $data)
    {
        $user = ModelUser::find($id);

        if (!$user) {
            return null;
        }

        $user->update($data);

        return $user;
    }

    public function deleteUser($id)
    {
        $user = ModelUser::find($id);

        if (!$user) {
            return null;
        }

        $user->delete();

        return true;
    }
}
