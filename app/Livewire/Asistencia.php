<?php

namespace App\Livewire;

use App\Models\Asistencia as ModelsAsistencia;
use App\Models\Grupos;
use App\Models\MiembrosGrupo;
use Carbon\Carbon;
use Livewire\Component;

class Asistencia extends Component
{
    public $fecha;
    public $grupoId;
    public $miembroId;

    public function mount($fecha=null)
    {
        $this->fecha = $fecha ? Carbon::parse($fecha)->format('Y-m-d') : now()->format('Y-m-d');
    }

    public function buscarFecha()   {
        $this->fecha = Carbon::parse($this->fecha)->format('d-m-Y');
    }

    public function changeGrupo(){}

    public function actualizarAsistencia($miembroId)
    {
        if (!$miembroId) {
            return response()->json(['error' => 'Faltan datos']);
        }

        $miembro = MiembrosGrupo::findOrFail($miembroId);

        ModelsAsistencia::create([
            'grupo_miembro_id' => $miembroId,
            'fecha' => Carbon::parse($this->fecha)->format('Y-m-d'),
            'asistio' => true,
            'mensaje' => false
        ]);
    }

    public function render()
    {

        $fecha = $this->fecha; // Si no hay búsqueda, usa la fecha actual
        $grupoId=$this->grupoId;
        $userId= auth()->user()->id;

        $miembros= MiembrosGrupo::with('asistencias', 'miembro')
        ->whereHas('grupo', function ($query) use ($userId, $grupoId) {
            $query->where('user_id', $userId);
            $query->where('id', $grupoId);
        })
        ->whereHas('asistencias', function ($query) use ($fecha) {
            $query->where('fecha', $fecha);
        })
        ->where('estado', 1)
        ->get();

        $data = $miembros->map(function ($miembro) use ($fecha) {
            return [
                'id' => $miembro->id,
                'nombre' => $miembro->miembro->getFullNameAttribute(),
                'fecha' => $miembro->asistencias->first()?->fecha,
                'asistio' => $miembro->asistencias->first()?->asistio,
                'mensaje' => $miembro->asistencias->first()?->mensaje,
            ];
        });

        $grupos = Grupos::select('id', 'nombre')->where('user_id', $userId)
        ->orderBy('id', 'desc')
        ->get();

        return view('livewire.asistencia', [
            'miembros' => $data->toArray(),
            'grupos' => $grupos,
            'fecha' => $fecha
        ]);
    }
}
