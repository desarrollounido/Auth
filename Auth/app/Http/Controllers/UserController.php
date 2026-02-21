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

    // LISTAR USUARIOS
    public function index()
    {
        $data = $this->userService->getAllUsers();

        return response()->json([
            'success' => true,
            'message' => 'Usuarios Listados Correctamente',
            'data' => $data
        ], 200);
    }


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

    // CREAR USUARIO
    public function store(UserRequest $request)
    {
        if (Gate::denies('create', request()->user('api')) && $request['cod_rol'] === 1) {
            return response()->json([
                'success' => false,
                'message' => 'No cuentas con permisos para la creación de usuarios'
            ], 403);
        }

        $data = $this->userService->createUser($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Usuario Creado Correctamente',
            'data' => $data
        ], 201);
    }

    // ACTUALIZAR USUARIO
    public function update(UserRequest $request, $id)
    {
        $data = $this->userService->getUserById($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario No Encontrado'
            ], 404);
        }

        if (Gate::denies('update', $data)) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permisos para actualizar este usuario'
            ], 403);
        }

        $updated = $this->userService->updateUser($id, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Usuario Actualizado Correctamente',
            'data' => $updated
        ], 200);
    }

    // ELIMINAR USUARIO
    public function destroy($id)
    {
        if (Gate::denies('delete',request()->user('api'))) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permisos para eliminar este usuario'
            ], 403);
        }

        $result = $this->userService->deleteUser($id);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario No Encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Usuario Eliminado Correctamente'
        ], 200);
    }
}