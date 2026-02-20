<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;    
use App\Http\Requests\AuthRequest as LoginRequest;
use App\Services\AuthService;



class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $login)
    {
        $credentials = $login->only('email', 'password');
    
        try {
            $result = $this->authService->login($credentials);
            
            $user = $result['user'];
            $token = $result['token'];
        
            return response()->json([
                'message' => 'login successful',
                'role' => $user->roles->nombre_rol ?? null,
                'user' => $user
            ], 200)
            ->cookie('token', $token, 60 * 24, null, null, false, true);
        } catch (\Exception $e) {
            $invalidCredentials = 'Invalid credentials';
            $statusCode = $e->getMessage() === $invalidCredentials ? 401 : 500;
            $errorMessage = $e->getMessage() === $invalidCredentials
                ? $invalidCredentials
                : 'could not create token';

            return response()->json(['error' => $errorMessage], $statusCode);
        }
    }
}
