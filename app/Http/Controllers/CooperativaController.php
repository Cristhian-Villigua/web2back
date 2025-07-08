<?php

namespace App\Http\Controllers;

use App\Models\Cooperativa;
use Illuminate\Http\Request;

class CooperativaController extends Controller
{
    public function index()
    {
        $cooperativas = Cooperativa::all();
        return response()->json($cooperativas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string|max:100',
            'dirrecion' => 'required|string|max:100',
            'celular' => 'required|string|max:100',
        ]);

        $cooperativa = Cooperativa::create($request->all());
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
        return response()->json(null, 204);
    }
}