<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserServices;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserServices $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $data = $this->userService->getAllUsers();

        return response()->json([
            'message' => 'Usuarios Listados Correctamente',
            'data' => $data
        ], 200);
    }

    public function show($id)
    {
        $data = $this->userService->getUserById($id);

        if (!$data) {
            return response()->json([
                'message' => 'Usuario No Encontrado'
            ], 404);
        }

        return response()->json([
            'message' => 'Usuario Encontrado Correctamente',
            'data' => $data
        ], 200);
    }

    public function store(UserRequest $request)
    {
        $data = $this->userService->createUser($request->validated());

        return response()->json([
            'message' => 'Usuario Creado Correctamente',
            'data' => $data
        ], 201);
    }

    public function update(UserRequest $request, $id)
    {
        $data = $this->userService->updateUser($id, $request->validated());

        if (!$data) {
            return response()->json([
                'message' => 'Usuario No Encontrado'
            ], 404);
        }

        return response()->json([
            'message' => 'Usuario Actualizado Correctamente',
            'data' => $data
        ], 200);
    }

    public function destroy($id)
    {
        $result = $this->userService->deleteUser($id);

        if (!$result) {
            return response()->json([
                'message' => 'Usuario No Encontrado'
            ], 404);
        }

        return response()->json([
            'message' => 'Usuario Eliminado Correctamente'
        ], 200);
    }
}
