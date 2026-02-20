<?php

namespace App\Repositories\Eloquent;

use App\Models\ModelRol;
use App\Repositories\Interfaces\RolInterface;

class RolRepository implements RolInterface
{
    public function getAllRoles()
    {
        $roles = ModelRol::all();

        return $roles;
    }

    public function getRoleById($id)
    {
        $role = ModelRol::find($id);

        return !$role ? null : $role;
    }

    public function createRole(array $data)
    {
        $role = ModelRol::create($data);

        return $role;
    }

    public function updateRole($id, array $data)
    {
        $role = ModelRol::find($id);

        if (!$role) {
            return null;
        }

        $role->update($data);

        return $role;
    }

    public function deleteRole($id)
    {
        $role = ModelRol::find($id);

        if (!$role) {
            return null;
        }

        $role->delete();

        return true;
    }
}

