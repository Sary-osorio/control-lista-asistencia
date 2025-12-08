<?php

namespace App\Livewire;

use App\Models\Asistencia as ModelsAsistencia;
use App\Models\AsistenciasFecha;
use App\Models\Grupos;
use App\Models\MiembrosGrupo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Asistencia extends Component
{
    public $fecha;
    public $grupoId;
    public $asistencias=[];

    public function mount()
    {
        $grupos = Grupos::where('user_id', auth()->id())->get();
        if ($grupos->count() > 0) {
            $this->grupoId = $grupos->last()->id;
        }
        $this->fecha = now()->format('d-m-Y');

        $this->actualizarAsistencia();
    }

    public function changeFecha()
     {
        $this->actualizarAsistencia();
     }

    public function changeGrupo()
    {
        $this->actualizarAsistencia();
    }
    private function actualizarAsistencia(){
        $fecha = $this->fecha;
        $fecha = Carbon::parse($fecha)->format('Y-m-d');

        // $data = ModelsAsistencia::where('fecha', $fecha)
        // ->whereHas('miembroGrupo', fn($q) => $q->where('grupo_id', $this->grupoId))
        // ->get();

        $data = ModelsAsistencia::with('fecha')
        ->whereHas('fecha', fn($q) => $q->where('fecha', $fecha))
        ->whereHas('miembroGrupo', fn($q) => $q->where('grupo_id', $this->grupoId))
        ->get();

         $this->asistencias = $data
        ->pluck('asistio', 'grupo_miembro_id')
        ->map(fn($asistio) => (bool)$asistio)
        ->toArray();

    }

    public function guardarAsistencia(){

        $this->validate([
            'asistencias' => 'required|array',
            'fecha' => 'required|date|after:1945-01-01',
            'grupoId' => 'required|exists:grupos,id'
        ]);

        $fecha = $this->fecha;
        $fecha = Carbon::parse($fecha)->format('Y-m-d');

        $fechaRegistrada = AsistenciasFecha::create([
            'fecha' => $fecha,
            'estado' => 1,
        ]);

        foreach ($this->asistencias as $miembroId => $asistencia) {

            ModelsAsistencia::create([
                'grupo_miembro_id' => $miembroId,
                'asistencias_fecha_id' => $fechaRegistrada->id,
                'asistio' => $asistencia,
                'mensaje' => 1,
            ]);
        }


    }


    public function render()
    {

        $fecha = $this->fecha; // Si no hay búsqueda, usa la fecha actual
        $fecha = Carbon::parse($fecha)->format('Y-m-d');
        $grupoId=$this->grupoId;
        $userId= auth()->user()->id;

        // $miembros= MiembrosGrupo::with(['asistencias' => function ($q) use ($fecha) {
        //     // $q->select('fecha', 'asistio')
        //     // ->where('fecha', '2025-11-23');
        // },
        // 'miembro'])
        // ->whereHas('grupo', function ($query) use ($userId, $grupoId) {
        //     $query->where('user_id', $userId);
        //     $query->where('id', 1);
        // })
        // // ->whereHas('asistencias', function ($query) use ($fecha) {
        // //     $query->where('fecha', $fecha);
        // // })
        // ->where('estado', 1)
        // ->get();

        // $miembros = DB::table('grupos_miembros as gm')
        //             ->select(
        //                 'gm.id as id',
        //                 'g.user_id',
        //                 DB::raw("CONCAT(m.nombre, ' ', m.apellidos) as miembro"),
        //                 'a.fecha',
        //                 'a.asistio'
        //             )
        //             ->join('grupos as g', 'g.id', '=', 'gm.grupo_id')
        //             ->join('miembros as m', 'm.id', '=', 'gm.miembro_id')
        //             ->leftJoin('asistencias as a', function($join) use ($fecha) {
        //                 $join->on('a.grupo_miembro_id', '=', 'gm.id')
        //                     ->where('a.fecha', '=', $fecha);
        //             })
        //             ->where('gm.grupo_id', $grupoId)
        //             ->get()
        //             ->map(function ($miembro) {
        //                 return [
        //                     'id' => $miembro->id,
        //                     'nombre' => $miembro->miembro,
        //                     'fecha' => $miembro->fecha,
        //                     'asistio' => $miembro->asistio,
        //                 ];
        //             });

                     $miembros = MiembrosGrupo::query()
                    ->select(
                        'grupos_miembros.id as id',
                        DB::raw("CONCAT(m.nombre, ' ', m.apellidos) as nombre"),
                        'af.fecha',
                        'a.asistio'
                    )
                    ->join('grupos as g', 'g.id', '=', 'grupos_miembros.grupo_id')
                    ->join('miembros as m', 'm.id', '=', 'grupos_miembros.miembro_id')
                    ->leftJoin('asistencias as a', 'a.grupo_miembro_id', '=', 'grupos_miembros.id')
                    ->leftJoin('asistencias_fecha as af', function ($join) use ($fecha) {
                        $join->on('af.id', '=', 'a.asistencias_fecha_id')
                            ->where('af.fecha', $fecha);
                    })
                    // ->leftJoin('asistencias as a', function($join) use ($fecha) {
                    //     $join->on('a.grupo_miembro_id', '=', 'grupos_miembros.id')
                    //         ->where('a.fecha', '=', $fecha);
                    // })
                    ->where('grupos_miembros.grupo_id', $grupoId)
                    ->get()
                    ->map(function ($miembro) {
                        return [
                            'id' => $miembro->id,
                            'nombre' => $miembro->nombre,
                            'fecha' => $miembro->fecha,
                            'asistio' => $miembro->asistio,
                        ];
                    });


        // $data = $miembros->map(function ($miembro) use ($fecha) {
        //     return [
        //         'id' => $miembro->id,
        //         'nombre' => $miembro->miembro->getFullNameAttribute(),
        //         'fecha' => $miembro->asistencias->first()?->fecha,
        //         'asistio' => $miembro->asistencias->first()?->asistio,
        //         'mensaje' => $miembro->asistencias->first()?->mensaje,
        //     ];
        // });



        $grupos = Grupos::select('id', 'nombre')->where('user_id', $userId)
        ->orderBy('id', 'desc')
        ->get();

        return view('livewire.asistencia', [
            'miembros' => $miembros,
            'grupos' => $grupos,
            'fecha' => $fecha
        ]);
    }
}
