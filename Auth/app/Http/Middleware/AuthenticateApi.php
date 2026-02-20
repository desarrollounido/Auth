<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;

class AuthenticateApi
{
    public function handle($request, Closure $next, ...$guards) // request= a la petición, next= la siguiente función a ejecutar, guards= los guardias de autenticación
    {
        if (!auth()->guard('api')->check()) { // Verifica si el usuario no está autenticado usando el guardia 'api'
            throw new AuthenticationException('No autenticado, Inicia Sesión.');
        }

        return $next($request);
    }
}