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
    public $asistenciasJson = '';
    public $guardarAsistencia='0';

    public function mount()
    {
        $grupos = Grupos::where('user_id', auth()->id())->get();
        if ($grupos->count() > 0) {
            $this->grupoId = $grupos->last()->id;
        }
        $this->fecha = now()->format('d-m-Y');

        $this->buscarAsistencia();
    }

    public function changeFecha()
     {
        $this->buscarAsistencia();
     }

    public function changeGrupo()
    {
        $this->buscarAsistencia();
    }

    public function changeAsistencia($miembroId)
    {
        $this->asistenciasJson = json_encode($this->asistencias);
        \Log::info('Cambio de asistencia para miembro ID: '.$miembroId.' Nuevo valor: '.$this->asistencias[$miembroId]);
    }
    private function buscarAsistencia(){

        // try{
            $fecha = $this->fecha;
            $fecha = Carbon::parse($fecha)->format('Y-m-d');


            // $estadoFecha= AsistenciasFecha::where('fecha', $fecha)->pluck('estado')->first();

            // if(!isEmpty($estadoFecha)) $this->guardarAsistencia = $estadoFecha;

            $data = ModelsAsistencia::whereHas('asistenciaFecha', fn($q) => $q->where('fecha', $fecha))
            ->whereHas('miembroGrupo', fn($q) => $q->where('grupo_id', $this->grupoId))
            ->get();

             if (empty($this->asistencias)) {
        $this->asistencias = $data
            ->pluck('asistio', 'grupo_miembro_id')
            ->toArray();
    }

            \Log::info('Asistencias encontradas: '.json_encode($this->asistencias));

        // }catch(\Throwable $t){
        //     \Log::error('Error al buscar asistencia: '.$t->getMessage());
        //     $this->asistencias = [];
        // }

    }


    public function guardarAsistencia(){
        dd('Guardar asistencia');

         \Log::info('Entró al método guardarAsistencia');


    //     try{
            \Log::info('Asistencias encontradas guardar: '.json_encode($this->asistencias));

            $this->validate([
                'asistencias' => 'required|array',
                'fecha' => 'required|date|after:1945-01-01',
                'grupoId' => 'required|exists:grupos,id'
            ]);

        $fecha = $this->fecha;
        $fecha = Carbon::parse($fecha)->format('Y-m-d');

        $fechaAsistencia = AsistenciasFecha::create([
            'fecha' => $fecha,
            'estado' => '1',
        ]);
        // dd($fechaAsistencia);
        foreach ($this->asistencias as $miembroId => $asistencia) {

            ModelsAsistencia::create([
                'grupo_miembro_id' => $miembroId,
                'asistencias_fecha_id' => $fechaAsistencia->id,
                'asistio' => $asistencia,
                'mensaje' => false
            ]);
        }
    // }catch(\Throwable $t){
    //     \Log::error('Error al guardar asistencia: '.$t->getMessage());
    // }
    }


    public function render()
    {
        $fecha = $this->fecha;
        $fecha = Carbon::parse($fecha)->format('Y-m-d');
        $grupoId=$this->grupoId;
        $userId= auth()->user()->id;

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

        $grupos = Grupos::select('id', 'nombre')->where('user_id', $userId)
        ->orderBy('id', 'desc')
        ->get();

        \Log::info('Miembros para render: '.json_encode($miembros));


        return view('livewire.asistencia', [
            'miembros' => $miembros,
            'grupos' => $grupos,
            'fecha' => $fecha
        ]);
    }
}
