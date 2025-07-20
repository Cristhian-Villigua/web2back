<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bus;
use App\Models\Cooperativa;
use App\Models\Ruta;

class AdminController extends Controller
{
    public function countByRole()
{
    $admin = User::where('role', 'admin')->count();
    $empleados = User::where('role', 'empleado')->count();
    $proveedores = User::where('role', 'proveedor')->count();
    $usuarios = User::where('role', 'usuario')->count();
    $cooperativa = Cooperativa::count();
    $buses = Bus::count();
    $rutas = Ruta::count();

    return response()->json([
        'admin' => $admin,
        'empleados' => $empleados,
        'proveedores' => $proveedores,
        'usuarios' => $usuarios,
        'cooperativa' => $cooperativa,
        'buses' => $buses,
        'rutas' => $rutas
    ]);
}

}
