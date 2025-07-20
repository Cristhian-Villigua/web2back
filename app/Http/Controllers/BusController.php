<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Cooperativa;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function index()
    {
        $buses = Bus::with('cooperativa')->get();
        return response()->json($buses, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'placa' => 'required|string|max:100|unique:buses,placa',
            'cantidad_asientos' => 'required|integer',
            'cooperativa_id' => 'required|exists:cooperativas,id',
        ]);

        $bus = Bus::create($request->all());
        return response()->json(compact('bus'), 200);
    }

    public function show($id){
        $bus = Bus::with('cooperativa')->findOrFail($id);
        return response()->json($bus);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'sometimes|required|string|max:100',
            'placa' => 'sometimes|required|string|max:100|unique:buses,placa,' . $id,
            'cantidad_asientos' => 'sometimes|required|integer',
            'cooperativa_id' => 'sometimes|required|exists:cooperativas,id',
        ]);

        $bus = Bus::findOrFail($id);
        $bus->update($request->all());
        return response()->json(compact('bus'), 200);
    }

    public function destroy($id)
{
   
    $bus = Bus::findOrFail($id);

    try {
        
        $bus->delete();

        return response()->json([
            'message' => 'Bus eliminado correctamente',
            'bus' => $bus
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error al eliminar el bus',
            'error' => $e->getMessage()
        ], 500);
    }
}
}