<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $result = $this->authService->register($request->validated());
        return response()->json($result, 201);
    }

    public function login(LoginRequest $request){
        $result = $this->authService->login($request->only('email', 'password'));

        if (isset($result['error'])) {
            if ($result['error'] === 'user_not_found') {
                return response()->json(['message' => 'Para iniciar sesión necesitas crear una cuenta.'], 404);
            }
            if ($result['error'] === 'invalid_credentials') {
                return response()->json(['message' => 'Credenciales incorrectas.'], 401);
            }
        }
        $user = $result['user'];
        $userData = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
        ];

        return response()->json([
            'user' => $userData,
            'token' => $result['token'],
        ], $result['status']);
    }
}
