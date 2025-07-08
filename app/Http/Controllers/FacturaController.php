<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Reserva;
use Illuminate\Http\Request;

class FacturaController extends Controller
{
    public function index()
    {
        $facturas = Factura::all();
        return response()->json($facturas);
    }

    public function show($id)
    {
        $factura = Factura::findOrFail($id);
        return response()->json($factura);
    }

    public function store(Request $request)
    {
        $request->validate([
            'monto' => 'required|numeric',
            'reserva_id' => 'required|exists:reservas,id|unique:faturas,reserva_id',
            'usuario_id' => 'required|exists:usuarios,id',
        ]);

        $factura = Factura::create($request->all());
        return response()->json($factura, 201);
    }

    public function update(Request $request, $id)
    {
        $factura = Factura::findOrFail($id);
        $request->validate([
            'monto' => 'sometimes|required|numeric',
            'reserva_id' => 'sometimes|required|exists:reservas,id|unique:faturas,reserva_id,' . $factura->id,
            'usuario_id' => 'sometimes|required|exists:usuarios,id',
        ]);

        $factura->update($request->all());
        return response()->json($factura);
    }

    public function destroy($id)
    {
        $factura = Factura::findOrFail($id);
        $factura->delete();
        return response()->json(null, 204);
    }
}