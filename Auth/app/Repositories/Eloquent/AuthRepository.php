<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\AuthInterface;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthRepository implements AuthInterface
{
    public function attemptLogin(array $credentials)
    {
        try {
            return JWTAuth::attempt($credentials);
        } catch (JWTException $e) {
            return false;
        }
    }

   public function getUser()
    {
        try {
            $user = JWTAuth::user();

            return $user;
        } catch (JWTException $e) {
            return null;
        }
    }
}