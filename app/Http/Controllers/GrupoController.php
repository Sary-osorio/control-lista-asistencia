<?php

namespace App\Http\Controllers;

use App\Models\Grupos;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    public function store(Request $request)
    {
        $user=auth()->user()->id;

         $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        ]);

        Grupos::create([
            'user_id' => $user,
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'] ?? null,
        ]);

        return redirect()->route('dashboard')->with('success', 'Grupo creado exitosamente.');
    }
}
