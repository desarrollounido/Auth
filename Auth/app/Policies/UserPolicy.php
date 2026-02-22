<?php

namespace App\Policies;

use App\Models\ModelUser;

class UserPolicy
{
    // VER USUARIO — admin ve todos, otros solo a sí mismos
    public function view(?ModelUser $userAuth, ModelUser $userRequest): bool
    {
        if (!$userAuth) {
            return false;
        }

        return $userAuth->cod_usuario === $userRequest->cod_usuario
            || $userAuth->roles->nombre_rol === 'administrador';
    }

    // CREAR USUARIO — admin crea cualquiera, público puede registrarse (validación extra en controller)
    public function create(?ModelUser $userAuth = null): bool
    {
        return true;
    }

    // ACTUALIZAR USUARIO — admin actualiza a todos, otros solo a sí mismos
    // admin NO puede ser actualizado por otro rol que no sea admin
    public function update(?ModelUser $userAuth, ModelUser $userRequest): bool
    {
        if (!$userAuth) {
            return false;
        }

        // Si el usuario a actualizar es admin, solo otro admin puede hacerlo
        if ($userRequest->roles->nombre_rol === 'administrador') {
            return $userAuth->roles->nombre_rol === 'administrador';
        }

        return $userAuth->cod_usuario === $userRequest->cod_usuario
            || $userAuth->roles->nombre_rol === 'administrador';
    }

    // ELIMINAR USUARIO — solo admin
    public function delete(?ModelUser $userAuth, ModelUser $userRequest): bool
    {
        if (!$userAuth) {
            return false;
        }

        return $userAuth->roles->nombre_rol === 'administrador';
    }
}