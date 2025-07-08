<?php

namespace App\Http\Controllers;

use App\Models\Ventanilla;
use Illuminate\Http\Request;

class VentanillaController extends Controller
{
    public function index()
    {
        $ventanillas = Ventanilla::all();
        return response()->json($ventanillas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'cooperativa_id' => 'required|exists:cooperativas,id',
        ]);

        $ventanilla = Ventanilla::create($request->all());
        return response()->json($ventanilla, 201);
    }

    public function show($id)
    {
        $ventanilla = Ventanilla::findOrFail($id);
        return response()->json($ventanilla);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'sometimes|required|string|max:100',
            'cooperativa_id' => 'sometimes|required|exists:cooperativas,id',
        ]);

        $ventanilla = Ventanilla::findOrFail($id);
        $ventanilla->update($request->all());
        return response()->json($ventanilla);
    }

    public function destroy($id)
    {
        $ventanilla = Ventanilla::findOrFail($id);
        $ventanilla->delete();
        return response()->json(null, 204);
    }
}