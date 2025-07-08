<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function countByRole()
{
    $admin = User::where('role', 'admin')->count();
    $empleados = User::where('role', 'empleado')->count();
    $proveedores = User::where('role', 'proveedor')->count();
    $usuarios = User::where('role', 'usuario')->count();

    return response()->json([
        'admin' => $admin,
        'empleados' => $empleados,
        'proveedores' => $proveedores,
        'usuarios' => $usuarios
    ]);
}

}
