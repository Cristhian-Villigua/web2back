<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function index()
    {
        $reservas = Reserva::all();
        return response()->json($reservas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha_reserva' => 'required|date',
            'hora_reserva' => 'required|time',
            'ruta_id' => 'required|exists:rutas,id',
            'bus_id' => 'required|exists:buses,id',
            'ventanilla_id' => 'required|exists:ventanillas,id',
            'usuario_id' => 'required|exists:usuarios,id',
        ]);

        $reserva = Reserva::create($request->all());
        return response()->json($reserva, 201);
    }

    public function show($id)
    {
        $reserva = Reserva::findOrFail($id);
        return response()->json($reserva);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha_reserva' => 'date',
            'hora_reserva' => 'time',
            'ruta_id' => 'exists:rutas,id',
            'bus_id' => 'exists:buses,id',
            'ventanilla_id' => 'exists:ventanillas,id',
            'usuario_id' => 'exists:usuarios,id',
        ]);

        $reserva = Reserva::findOrFail($id);
        $reserva->update($request->all());
        return response()->json($reserva);
    }

    public function destroy($id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->delete();
        return response()->json(null, 204);
    }
}