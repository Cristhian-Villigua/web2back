<?php

namespace App\Http\Controllers;

use App\Models\Cooperativa;
use App\Models\User;
use Illuminate\Http\Request;

class CooperativaController extends Controller
{
    public function index()
    {
        $cooperativas = Cooperativa::with('owner')->get();
        return response()->json($cooperativas);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
        'nombres' => 'required|string|max:255',
        'dirrecion' => 'required|string|max:255',
        'celular' => 'required|string|max:20',
        ]);

        // Asociar al proveedor actual autenticado
        $validated['user_id'] = auth()->id();

        $cooperativa = Cooperativa::create($validated);

        return response()->json($cooperativa, 201);
    }

    public function show($id)
    {
        $cooperativa = Cooperativa::findOrFail($id);
        return response()->json($cooperativa);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombres' => 'sometimes|required|string|max:100',
            'dirrecion' => 'sometimes|required|string|max:100',
            'celular' => 'sometimes|required|string|max:100',
        ]);

        $cooperativa = Cooperativa::findOrFail($id);
        $cooperativa->update($request->all());
        return response()->json($cooperativa);
    }

    public function destroy($id)
    {
        $cooperativa = Cooperativa::findOrFail($id);
        $cooperativa->delete();
        return response()->json(compact('cooperativa'), 200);
    }
}