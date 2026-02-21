<?php

namespace App\Policies;

use App\Models\ModelUser;

class UserPolicy
{
    // VER USUARIO
    public function view(ModelUser $userAuth, ModelUser $userRequest): bool
    {
        return $userAuth->id === $userRequest->id
            || $userAuth->roles->nombre_rol === 'administrador';
    }

    // CREAR USUARIO
    public function create(ModelUser $userAuth): bool
    {
        return $userAuth->roles->nombre_rol === 'administrador';
    }

    // ACTUALIZAR USUARIO
    public function update(ModelUser $userAuth, ModelUser $userRequest): bool
    {
        return $userAuth->id === $userRequest->id
            || $userAuth->roles->nombre_rol === 'administrador';
    }

    // ELIMINAR USUARIO
    public function delete(ModelUser $userAuth): bool
    {
        return $userAuth->roles->nombre_rol === 'administrador';
    }
}