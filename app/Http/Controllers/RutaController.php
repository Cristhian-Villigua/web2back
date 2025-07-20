<?php

namespace App\Http\Controllers;

use App\Models\Cooperativa;
use App\Models\Bus;
use App\Models\Ruta;
use Illuminate\Http\Request;

class RutaController extends Controller
{
    public function index()
    {
        // Carga la ruta, su cooperativa y el bus asignado
        $rutas = Ruta::with(['cooperativa', 'bus'])->get();
        return response()->json($rutas, 200);
    }

    public function store(Request $request)
    {
        // Validar todos los campos necesarios
        $request->validate([
            'origen' => 'required|string|max:100',
            'destino' => 'required|string|max:100',
            'duracion' => 'required|string|max:100',
            'fechaSalida' => 'required|date',
            'horaSalida' => 'required|date_format:H:i',
            'cooperativa_id' => 'required|exists:cooperativas,id',
            'bus_id' => 'required|exists:buses,id',
        ]);

        // Validar que el bus seleccionado pertenece a la cooperativa indicada
        $bus = Bus::where('id', $request->bus_id)
                  ->where('cooperativa_id', $request->cooperativa_id)
                  ->first();

        if (!$bus) {
            return response()->json([
                'message' => 'El bus seleccionado no pertenece a la cooperativa indicada.'
            ], 422);
        }

        $ruta = Ruta::create($request->all());

        return response()->json($ruta, 201);
    }

    public function show($id)
    {
        $ruta = Ruta::with(['cooperativa', 'bus'])->findOrFail($id);
        return response()->json($ruta);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'origen' => 'sometimes|required|string|max:100',
            'destino' => 'sometimes|required|string|max:100',
            'duracion' => 'sometimes|required|string|max:100',
            'fechaSalida' => 'sometimes|required|date',
            'horaSalida' => 'sometimes|required|date_format:H:i',
            'cooperativa_id' => 'sometimes|required|exists:cooperativas,id',
            'bus_id' => 'sometimes|required|exists:buses,id',
        ]);

        $ruta = Ruta::findOrFail($id);

        // Si vienen bus_id y cooperativa_id validar relación
        if ($request->has(['bus_id', 'cooperativa_id'])) {
            $bus = Bus::where('id', $request->bus_id)
                      ->where('cooperativa_id', $request->cooperativa_id)
                      ->first();

            if (!$bus) {
                return response()->json([
                    'message' => 'El bus seleccionado no pertenece a la cooperativa indicada.'
                ], 422);
            }
        }

        $ruta->update($request->all());

        return response()->json($ruta, 200);
    }

    public function destroy($id)
    {
        $ruta = Ruta::findOrFail($id);
        $ruta->delete();

        return response()->json(['message' => 'Ruta eliminada correctamente'], 200);
    }
}
