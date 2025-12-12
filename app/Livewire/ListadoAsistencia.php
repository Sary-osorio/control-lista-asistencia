<?php

namespace App\Livewire;

use App\Models\Asistencia;
use App\Models\AsistenciasFecha;
use App\Models\Grupos;
use App\Models\MiembrosGrupo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ListadoAsistencia extends Component
{
    public $fechaListado;
    public $grupoId;

    public function mount()
    {
        $grupos = Grupos::where('user_id', auth()->id())->get();
        if ($grupos->count() > 0) {
            $this->grupoId = $grupos->last()->id;
        }
        $this->fechaListado = now()->format('d-m-Y');
    }

    public function changeFecha()
    {
        //
    }

    public function changeGrupo()
    {
        //
    }

    public function render()
    {
        $userId = auth()->user()->id;
        $grupoId = $this->grupoId;
        $fecha = $this->fecha ?? now()->toDateString();
        $fecha = Carbon::parse($fecha)->format('Y-m-d');
        $fechaBuscar = AsistenciasFecha::where('fecha', $fecha)->first();

        $asistencias = MiembrosGrupo::query()
            ->select(
                'grupos_miembros.id as id',
                DB::raw("CONCAT(m.nombre, ' ', m.apellidos) as nombre"),
                'a.asistio',
                'g.nombre as grupo',
                'af.fecha as fecha'
            )
            ->join('grupos as g', 'g.id', '=', 'grupos_miembros.grupo_id')
            ->join('miembros as m', 'm.id', '=', 'grupos_miembros.miembro_id')

            ->leftJoin('asistencias as a', function ($join) use ($fechaBuscar) {
                $join->on('a.grupo_miembro_id', '=', 'grupos_miembros.id')
                ->join('asistencias_fecha as af', 'af.id', '=', 'a.asistencias_fecha_id')
                    ->where('af.estado', '1')
                    ->where('a.asistencias_fecha_id', '=', $fechaBuscar->id);
            })
            ->where('grupos_miembros.grupo_id', $grupoId)
            ->get()
            ->map(function ($miembro) use ($fechaBuscar) {
                return [
                    'id' => $miembro->id,
                    'nombre' => $miembro->nombre,
                    'fecha' => $fechaBuscar->fecha. ' '. $fechaBuscar->estado,
                    'asistio' => $miembro->asistio,
                    'grupo' => $miembro->grupo
                ];
            });

        $grupos = Grupos::select('id', 'nombre')->where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->get();

        return view('livewire.listado-asistencia', [
            'asistencias' => $asistencias,
            'grupos' => $grupos,
        ]);
    }
}
