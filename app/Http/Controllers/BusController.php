<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function index()
    {
        $buses = Bus::all();
        return response()->json($buses);
    }

    public function store(Request $request)
    {
        $request->validate([
            'placa' => 'required|string|max:100',
            'cantidad_asientos' => 'required|integer',
            'cooperativa_id' => 'required|exists:cooperativas,id',
        ]);

        $bus = Bus::create($request->all());
        return response()->json($bus, 201);
    }

    public function show($id)
    {
        $bus = Bus::findOrFail($id);
        return response()->json($bus);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'placa' => 'sometimes|required|string|max:100',
            'cantidad_asientos' => 'sometimes|required|integer',
            'cooperativa_id' => 'sometimes|required|exists:cooperativas,id',
        ]);

        $bus = Bus::findOrFail($id);
        $bus->update($request->all());
        return response()->json($bus);
    }

    public function destroy($id)
    {
        $bus = Bus::findOrFail($id);
        $bus->delete();
        return response()->json(null, 204);
    }
}