<?php

namespace App\Http\Controllers;

use App\Services\UserServices;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserServices $userService)
    {
        $this->userService = $userService;
    }

    // LISTAR USUARIOS — solo admin
    public function index()
    {
        $userAuth = request()->user('api');

        if (!$userAuth) {
            return response()->json([
                'success' => false,
                'message' => 'Debes estar autenticado'
            ], 401);
        }

        if ($userAuth->roles->nombre_rol !== 'administrador') {
            return response()->json([
                'success' => false,
                'message' => 'Solo los administradores pueden listar usuarios'
            ], 403);
        }

        $data = $this->userService->getAllUsers();

        return response()->json([
            'success' => true,
            'message' => 'Usuarios Listados Correctamente',
            'data'    => $data
        ], 200);
    }

    // VER USUARIO — admin ve cualquiera, otros solo a sí mismos
    public function show($id)
    {
        $usuario = $this->userService->getUserById($id);

        if (!$usuario) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario No Encontrado'
            ], 404);
        }

        if (Gate::denies('view', $usuario)) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permisos para acceder'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Usuario Encontrado Correctamente',
            'usuario' => $usuario
        ], 200);
    }

    // CREAR USUARIO — público para roles normales, solo admin puede crear admins
    public function store(UserRequest $request)
    {
        $userAuth = request()->user('api');
        $codRol   = (int) $request['cod_rol'];

        if ($codRol === 1) {
            if (!$userAuth) {
                return response()->json([
                    'success' => false,
                    'message' => 'Debes estar autenticado para crear un administrador'
                ], 401);
            }

            if ($userAuth->roles->nombre_rol !== 'administrador') {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo los administradores pueden crear otros administradores'
                ], 403);
            }
        }

        $data = $this->userService->createUser($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Usuario Creado Correctamente',
            'data'    => $data
        ], 201);
    }

    // ACTUALIZAR USUARIO — admin actualiza a todos, otros solo a sí mismos
    // nadie que no sea admin puede modificar a un admin
    public function update(UserRequest $request, $id)
    {
        $usuario = $this->userService->getUserById($id);

        if (!$usuario) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario No Encontrado'
            ], 404);
        }

        if (Gate::denies('update', $usuario)) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permisos para actualizar este usuario'
            ], 403);
        }

        $updated = $this->userService->updateUser($id, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Usuario Actualizado Correctamente',
            'data'    => $updated
        ], 200);
    }

    // ELIMINAR USUARIO — solo admin
    public function destroy($id)
    {
        $userAuth = request()->user('api');

        if (!$userAuth) {
            return response()->json([
                'success' => false,
                'message' => 'Debes estar autenticado para eliminar usuarios'
            ], 401);
        }

        $usuario = $this->userService->getUserById($id);

        if (!$usuario) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario No Encontrado'
            ], 404);
        }

        if (Gate::denies('delete', $usuario)) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permisos para eliminar este usuario'
            ], 403);
        }

        $result = $this->userService->deleteUser($id);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el usuario'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Usuario Eliminado Correctamente'
        ], 200);
    }
}