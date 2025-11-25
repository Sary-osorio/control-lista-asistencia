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
    public $asistencias=[];

    public function mount()
    {
        $grupos = Grupos::where('user_id', auth()->id())->get();

        if ($grupos->count() > 0) {
            $this->grupoId = $grupos->last()->id;
        }

        $this->fecha = now()->format('d-m-Y');

    }

    public function changeFecha($fecha)   {
        $this->fecha = $fecha;
     }//$this->fecha = Carbon::parse($this->fecha)->format('d-m-Y');  }

    public function changeGrupo(){}

    public function guardarAsistencia(){

        $this->validate([
            'asistencias' => 'required|array',
            'fecha' => 'required|date|before:today|after:1945-01-01',
            'grupoId' => 'required|exists:grupos,id'
        ]);

        $fecha = $this->fecha;
        $fecha = Carbon::parse($fecha)->format('Y-m-d');

        foreach ($this->asistencias as $miembroId => $asistencia) {

            ModelsAsistencia::create([
                'grupo_miembro_id' => $miembroId,
                'fecha' => $fecha,
                'asistio' => $asistencia,
                'mensaje' => false
            ]);
        }


    }

    // public function actualizarAsistencia($miembroId)
    // {
    //     if (!$miembroId) {
    //         return response()->json(['error' => 'Faltan datos']);
    //     }

    //     $miembro = MiembrosGrupo::findOrFail($miembroId);

    //     ModelsAsistencia::create([
    //         'grupo_miembro_id' => $miembroId,
    //         'fecha' => Carbon::parse($this->fecha)->format('Y-m-d'),
    //         'asistio' => true,
    //         'mensaje' => false
    //     ]);
    // }

    public function render()
    {

        $fecha = $this->fecha; // Si no hay búsqueda, usa la fecha actual
        $grupoId=$this->grupoId;
        $userId= auth()->user()->id;

        $miembros= MiembrosGrupo::with(['asistencias' => function ($q) use ($fecha) {
            // $q->select('fecha', 'asistio')
            // ->where('fecha', '2025-11-23');
        },
        'miembro'])
        ->whereHas('grupo', function ($query) use ($userId, $grupoId) {
            $query->where('user_id', $userId);
            $query->where('id', 1);
        })
        // ->whereHas('asistencias', function ($query) use ($fecha) {
        //     $query->where('fecha', $fecha);
        // })
        ->where('estado', 1)
        ->get();

        // dd($miembros);

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
            'miembros' => $data,
            'grupos' => $grupos,
            'fecha' => $fecha
        ]);
    }
}
