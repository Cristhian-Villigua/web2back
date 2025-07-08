<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Listar todos los usuarios
    public function index()
    {
        $users = User::all();
        return response()->json(compact('users'), 200);
    }

    // Mostrar un usuario específico
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json(compact('user'), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:5|confirmed',
            'role' => 'required|in:admin,proveedor,empleado,usuario',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return response()->json(['message' => 'Usuario creado exitosamente', 'user' => $user], 201);
    }
    // Actualizar un usuario
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|min:5|confirmed',
            'role' => 'required|in:admin,proveedor,empleado,usuario',
        ]);
        if (!$user) {
            return [
                'error' => 'User not found',
                'status' => 404,
            ];
        }

        $data = $request->only(['name', 'email', 'role']); // <-- Incluye role
        if ($request->filled('password')) {
            if ($request->password !== $request->password_confirmation) {
                return [
                    'errors' => ['password_confirmation' => 'Las contraseñas no coinciden'],
                    'status' => 422,
                ];
            }
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
    }

    // Eliminar un usuario
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->delete();
        return response()->json(['message' => 'User deleted'], 200);
    }
}