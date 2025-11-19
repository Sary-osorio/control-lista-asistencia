<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListadoRequest;
use App\Models\Asistencia;
use App\Models\Miembro;
use Illuminate\Http\Request;

use function Laravel\Prompts\error;

class AsistenciaController extends Controller
{
    public function index(Request $request)
    {
        // $fecha = $request->buscar ?? now()->toDateString(); // Si no hay búsqueda, usa la fecha actual
        // $miembros = Miembro::with(['asistencias' => function ($q) use ($fecha) {
        //     $q->select('miembro_id', 'fecha', 'asistio', 'mensaje')
        //         ->where('fecha', $fecha); // Filtra solo la asistencia del día
        // }])->get(['id', 'nombre', 'apellidos']);

        // // Transformar la colección en un array con asistencia como objeto en lugar de colección
        // $data = $miembros->map(function ($miembro) use ($fecha) {
        //     return [
        //         'id' => $miembro->id,
        //         'nombre' => $miembro->nombre,
        //         'apellidos' => $miembro->apellidos,
        //         'fecha' => $miembro->asistencias->first()?->fecha,
        //         'asistio' => $miembro->asistencias->first()?->asistio,
        //         'mensaje' => $miembro->asistencias->first()?->mensaje,
        //     ];
        // });

        // return view('asistencia', ['miembros' => $data->toArray(), 'fecha' => $fecha]);

        return view('asistencia');
    }

    public function create(Request $request)
    {
        $miembro = $request->miembro_id;
        $asistio = $request->asistio;
        $mensaje = $request->mensaje;
        $fecha = $request->fecha;

        if (!$miembro) {
            return response()->json(['error' => 'Faltan datos']);
        }

        $asistencia = Asistencia::where('miembro_id', $miembro)
            ->where('fecha', $fecha)
            ->first();


        if ($asistencia && !$mensaje) {
            return response()->json(['error' => 'Ya se ha registrado la asistencia de este miembro']);
        }

        $mensajeFind = Asistencia::where('mensaje', 1)->first();

        if ($mensajeFind && $mensaje) {
            return response()->json('Ocurrio un error');
        }


        $asistencia = Asistencia::updateOrCreate(
            // atributos de busqueda
            [
                'miembro_id' => $miembro,
                'fecha' => $fecha,
            ],
            // atributos de actualizacion
            [
                'asistio' => $asistio,
                'mensaje' => $mensaje,
            ]
        );


        return response()->json($asistencia);
    }

    public function listadoAsistencia(ListadoRequest $request)
    {
        $fecha = $request->buscar ?? now()->toDateString(); // Si no hay búsqueda, usa la fecha actual

        if ($request->has('buscar') && empty($request->buscar)) {
            return redirect()->route('asistencia.listado')->with('error', 'No se ha ingresado un dato a buscar');
        }

        $listado = Miembro::whereHas('asistencias', function ($query) use ($fecha) {
            $query->whereDate('fecha', $fecha);
        })->get();

        return view('listado', compact('listado'));
    }


    public function asistenciaAnterior(Request $request)
    {

        if ($request->has('buscar') && empty($request->buscar)) {
            return redirect()->route('asistencia.anterior')->with('error', 'No se ha ingresado un dato a buscar');
        }
        $fecha = $request->buscar;

        $miembros = Miembro::whereHas('asistencias', function ($query) use ($fecha) {
            $query->whereDate('fecha', $fecha);
        })->get();

        return view('listado', compact('miembros'));
    }

    // public function listadoAsistencia(){
    //     $miembros = Miembro::whereHas('asistencias', function($query){
    //         $query->where('fecha', now()->toDateString());
    //     })->get();
    //     // dd($miembros->toArray());
    //     return view('listado', compact('miembros'));
    // }

    // public function searchAsistencia(Request $request){
    //     $buscar =$request->buscar;

    //     if(!$buscar){
    //         return redirect()->route('asistencia.listado')->with('error', 'No se ha ingresado un dato a buscar');
    //     }

    //     $miembros = Miembro::whereHas('asistencias', function($query) use ($buscar){
    //         $query->where('fecha', $buscar);
    //     })->get();

    //     return view('listado', compact('miembros'));
    // }

    public function show($id)
    {
        return view('asistencia.show', compact('id'));
    }

    public function destroy($id)
    {
        return view('asistencia.destroy', compact('id'));
    }
}
