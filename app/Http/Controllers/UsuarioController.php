<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::with('user')->get();

        $usuarios = $usuarios->map(function ($usuario) {
            return [
                'id' => $usuario->id,
                'nombres' => $usuario->nombres,
                'apellidos' => $usuario->apellidos,
                'cedula' => $usuario->cedula,
                'celular' => $usuario->celular,
                'dirrecion' => $usuario->dirrecion,
                'role' => $usuario->user->role ?? null,
            ];
        });

        return response()->json($usuarios);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'cedula' => 'required|string|unique:usuarios,cedula|max:100',
            'celular' => 'required|string|max:100',
            'dirrecion' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:5',
            'role' => 'required|in:proveedor,empleado', // validamos el rol
        ]);

        $user = new User();
        $user->name = $request->nombres . ' ' . $request->apellidos;
        $user->email = $request->email;
        $user->password = \Hash::make($request->password);
        $user->role = $request->role; // asignamos el rol
        $user->save();

        $usuario = new Usuario();
        $usuario->nombres = $request->nombres;
        $usuario->apellidos = $request->apellidos;
        $usuario->cedula = $request->cedula;
        $usuario->celular = $request->celular;
        $usuario->dirrecion = $request->dirrecion;
        $usuario->user_id = $user->id;
        $usuario->save();

        return response()->json($usuario, 200);
    }

    public function show($id)
    {
        $usuario = Usuario::with('user')->findOrFail($id);
        return response()->json(compact('usuario'), 200);
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);
        $request->validate([
            'nombres' => 'sometimes|required|string|max:100',
            'apellidos' => 'sometimes|required|string|max:100',
            'cedula' => 'sometimes|required|string|max:100|unique:usuarios,cedula,' . $usuario->id,
            'celular' => 'sometimes|required|string|max:100',
            'dirrecion' => 'sometimes|required|string|max:100',
            'email' => 'sometimes|required|email|unique:users,email,' . $usuario->user->id,
            'password' => 'nullable|string|min:6|confirmed', 
        ]);

        

        // Actualizar datos en la tabla users
        $user = User::findOrFail($usuario->user_id);
        if ($request->has('nombres') || $request->has('apellidos')) {
            $user->name = ($request->nombres ?? $usuario->nombres) . ' ' . ($request->apellidos ?? $usuario->apellidos);
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // Actualizar datos en la tabla usuarios
        $usuario->update($request->all());

        return response()->json($usuario, 200);
    }

    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);

        // Eliminar al usuario asociado en la tabla users
        if ($usuario->user) {
            $usuario->user->delete();
        }

        // Eliminar el registro en la tabla usuarios
        $usuario->delete();

        return response()->json(compact('usuario'), 200);
    }
}