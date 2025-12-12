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
    public $asistencias = [];

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

    public function changeAsistencias()
    {
        // $this->actualizarAsistencia();
    }
    private function actualizarAsistencia()
    {
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



    public function guardarAsistencia()
    {
        $this->validate([
            'asistencias' => 'required|array',
            'fecha' => 'required|date|after:1945-01-01',
            'grupoId' => 'required|exists:grupos,id'
        ]);

        $fecha = $this->fecha;
        $fecha = Carbon::parse($fecha)->format('Y-m-d');

        $fechaRegistrada = AsistenciasFecha::where('fecha', $fecha)->first();

        if(!$fechaRegistrada){
            $fechaRegistrada = AsistenciasFecha::create([
                'fecha' => $fecha,
                'estado' => AsistenciasFecha::ESTADO_PENDIENTE
            ]);
        }

        try {
            DB::beginTransaction();

            if ($fechaRegistrada->estado == AsistenciasFecha::ESTADO_COMPLETADO) {
                throw new \Exception('La asistencia para esta fecha ya ha sido registrada.');
            }

            foreach ($this->asistencias as $miembroId => $asistencia) {

                ModelsAsistencia::create([
                    'grupo_miembro_id' => $miembroId,
                    'asistencias_fecha_id' => $fechaRegistrada->id,
                    'asistio' => $asistencia,
                    'mensaje' => 1,
                ]);
            }

            $fechaRegistrada->estado = AsistenciasFecha::ESTADO_COMPLETADO;
            $fechaRegistrada->save();

            DB::commit();
        } catch (\Throwable $th) {
            \Log::error('Error al guardar la asistencia: ' . $th->getMessage());
            DB::rollBack();
            // $this->dispatch('error', message: 'Ocurrió un error al guardar la asistencia');
            $this->addError('general', 'Error al guardar');

        }

    }


    public function render()
    {

        $fecha = $this->fecha ?? now()->toDateString();
        $fecha = Carbon::parse($fecha)->format('Y-m-d');
        $grupoId = $this->grupoId;
        $userId = auth()->user()->id;

        $fechaBuscar = AsistenciasFecha::where('fecha', $fecha)->first();

        if (!$fechaBuscar) {
            $fechaBuscar = AsistenciasFecha::create([
                'fecha' => $fecha,
                'estado' => '0',
            ]);
        }

        $miembros = MiembrosGrupo::query()
            ->select(
                'grupos_miembros.id as id',
                DB::raw("CONCAT(m.nombre, ' ', m.apellidos) as nombre"),
                'a.asistio',
            )
            ->join('grupos as g', 'g.id', '=', 'grupos_miembros.grupo_id')
            ->join('miembros as m', 'm.id', '=', 'grupos_miembros.miembro_id')
            ->leftJoin('asistencias as a', function ($join) use ($fechaBuscar) {
                $join->on('a.grupo_miembro_id', '=', 'grupos_miembros.id')
                // ->join('asistencias_fecha as af', 'af.id', '=', 'a.asistencias_fecha_id')
                    ->where('a.asistencias_fecha_id', '=', $fechaBuscar->id);
            })
            ->where('grupos_miembros.grupo_id', $grupoId)
            ->get()
            ->map(function ($miembro) use ($fechaBuscar) {
                return [
                    'id' => $miembro->id,
                    'nombre' => $miembro->nombre,
                    'fecha' => $fechaBuscar->fecha,
                    'asistio' => $miembro->asistio
                ];
            });

        $grupos = Grupos::select('id', 'nombre')->where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->get();

        return view('livewire.asistencia', [
            'miembros' => $miembros,
            'grupos' => $grupos,
            'fecha' => $fecha,
            'estado_fecha' => $fechaBuscar->estado,
        ]);
    }
}
