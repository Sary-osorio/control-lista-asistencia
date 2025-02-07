<?php

namespace App\Http\Controllers;

use App\Http\Requests\MiembroRequest;
use Illuminate\Http\Request;
use App\Models\Miembro;

class MiembroController extends Controller
{
    public function index()
    {
        $miembros = Miembro::all();
        return view('miembro', compact('miembros'));
    }

    public function create(MiembroRequest $request)
    {

        $validated = $request->validated();

        $miembro = new Miembro();
        $miembro->nombre = $validated['nombre'];
        $miembro->apellidos = $validated['apellidos'];
        $miembro->fecha_nac = $validated['fecha_nac'];
        $miembro->grupo_extra = $validated['grupo_extra'] ?? null;
        $miembro->save();

        return redirect()->route('miembro.index');
    }

    public function update()
    {
        return view('miembro.update');
    }

    public function show($id)
    {
        return view('miembro.show', compact('id'));
    }

    public function destroy($id)
    {
        return view('miembro.destroy', compact('id'));
    }

}
