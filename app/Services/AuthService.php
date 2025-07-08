<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(array $data)
    {   
        $existingUser = $this->userRepository->findByEmail($data['email']);
        if ($existingUser) {
            return [
                'error' => 'El correo ya está registrado.',
                'status' => 404,
            ];
        }
        $user = $this->userRepository->create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $token = JWTAuth::fromUser($user);

        return [
            'user' => $user,
            'token' => $token,
            'status' => 201,
        ];
    }

    public function login(array $credentials)
    {
        $user = $this->userRepository->findByEmail($credentials['email']);
        
        if (!$user) {
            return [
                'error' => 'user_not_found',
                'status' => 404,
            ];
        }
        if (!$token = JWTAuth::attempt($credentials)) {
            return [
                'error' => 'invalid_credentials',
                'status' => 401,
            ];
        }
        return [
            'user' => $user,
            'token' => $token,
            'status' => 200,
        ];
    }
}
