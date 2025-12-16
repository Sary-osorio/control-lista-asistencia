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

    public function buscarAsistencia()
    {
        $this->render();
    }

    public function render()
    {
        $userId = auth()->user()->id;
        $grupoId = $this->grupoId;
        $fecha = Carbon::parse($this->fechaListado)->format('Y-m-d');

         $fechaBuscar = AsistenciasFecha::firstOrCreate(
                        ['fecha' => $fecha],
                        ['estado' => AsistenciasFecha::ESTADO_PENDIENTE]
                        );

        $asistencias = MiembrosGrupo::query()
            ->select(
                'grupos_miembros.id as id',
                DB::raw("CONCAT(m.nombre, ' ', m.apellidos) as nombre"),
                'a.asistio',
                'g.nombre as grupo'
            )
            ->join('grupos as g', 'g.id', '=', 'grupos_miembros.grupo_id')
            ->join('miembros as m', 'm.id', '=', 'grupos_miembros.miembro_id')
            ->leftJoin('asistencias as a', function ($join) use ($fechaBuscar) {
                $join->on('a.grupo_miembro_id', '=', 'grupos_miembros.id')
                    ->where('a.asistencias_fecha_id', '=', $fechaBuscar->id);
            })
            ->where('grupos_miembros.grupo_id', $grupoId)
            ->paginate(5)
            ->through(fn ($miembro) => [
            'id'      => $miembro->id,
            'nombre'  => $miembro->nombre,
            'fecha'   => $fechaBuscar->fecha,
            'asistio' => $miembro->asistio,
            'grupo'   => $miembro->grupo,
        ]);

        $grupos = Grupos::select('id', 'nombre')->where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->get();

        return view('livewire.listado-asistencia', [
            'asistencias' => $asistencias,
            'grupos' => $grupos,
        ]);
    }
}
