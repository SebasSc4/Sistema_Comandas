<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comanda;
use App\Models\Mesa;

class ComandaController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validar que la información que llega del frontend sea correcta
        $request->validate([
            'mesa_id' => 'required|exists:mesas,id',
            'productos' => 'required|array', // Lista de platillos elegidos
        ]);

        // 2. Crear el registro principal de la comanda
        $comanda = Comanda::create([
            'mesa_id' => $request->mesa_id,
            'user_id' => 1, // ID temporal del mesero usando el sistema
            'estado' => 'abierta', // Pendiente = En preparación en cocina
            'total' => $request->total ?? 0,
        ]);

        // 3. Vincular los productos a esta comanda en la tabla pivote
        foreach ($request->productos as $producto) {
            $comanda->productos()->attach($producto['id'], [
                'cantidad' => $producto['cantidad'],
                'notas' => $producto['notas'] ?? null // Por si piden algo "sin cebolla"
            ]);
        }

        // 4. Cambiar automáticamente el estado de la mesa a 'ocupada'
        $mesa = Mesa::find($request->mesa_id);
        $mesa->update(['estado' => 'ocupada']);

        // 5. Responderle a la interfaz web que todo salió bien
        // Esto regresa a la página anterior enviando un mensaje de éxito
return redirect()->back()->with('success', '¡Comanda enviada a cocina exitosamente!');
    }
}
