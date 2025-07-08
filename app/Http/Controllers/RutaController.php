<?php

namespace App\Http\Controllers;

use App\Models\Ruta;
use Illuminate\Http\Request;

class RutaController extends Controller
{
    public function index()
    {
        $rutas = Ruta::all();
        return response()->json($rutas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'origen' => 'required|string|max:100',
            'destino' => 'required|string|max:100',
            'duracion' => 'required|string|max:100',
            'fechaSalida' => 'required|date',
            'horaSalida' => 'required|time',
            'cooperativa_id' => 'required|exists:cooperativas,id',
        ]);

        $ruta = Ruta::create($request->all());
        return response()->json($ruta, 201);
    }

    public function show($id)
    {
        $ruta = Ruta::findOrFail($id);
        return response()->json($ruta);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'origen' => 'sometimes|required|string|max:100',
            'destino' => 'sometimes|required|string|max:100',
            'duracion' => 'sometimes|required|string|max:100',
            'fechaSalida' => 'sometimes|required|date',
            'horaSalida' => 'sometimes|required|time',
            'cooperativa_id' => 'sometimes|required|exists:cooperativas,id',
        ]);

        $ruta = Ruta::findOrFail($id);
        $ruta->update($request->all());
        return response()->json($ruta);
    }

    public function destroy($id)
    {
        $ruta = Ruta::findOrFail($id);
        $ruta->delete();
        return response()->json(null, 204);
    }
}