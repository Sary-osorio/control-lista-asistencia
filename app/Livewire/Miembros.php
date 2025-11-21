<?php

namespace App\Livewire;

use App\Models\Grupos;
use App\Models\Miembro;
use App\Models\MiembrosGrupo;
use Livewire\Component;
use Livewire\WithPagination;

class Miembros extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';

    public $openModal = false;
    public $nombre;
    public $apellido;
    public $fechaNac;
    public $grupo;

    public function abrirModal(){
        $this->openModal = true;
    }

    public function cerrarModal(){
        $this->openModal = false;
    }

    public function storeMiembro()
    {
        $validated = $this->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string',
            'fechaNac' => 'required|date|before:today|after:1945-01-01',
            'grupo' => 'required|exists:grupos,id',
        ]);

        $miembro = Miembro::create([
            'nombre' => $validated['nombre'],
            'apellidos' => $validated['apellido'],
            'fecha_nac' => $validated['fechaNac'],
        ]);

        MiembrosGrupo::create([
            'miembro_id' => $miembro->id,
            'grupo_id' => $validated['grupo'],
        ]);

        $this->reset(['nombre', 'apellido', 'fechaNac', 'grupo']);

        $this->cerrarModal();

        session()->flash('message', 'Miembro agregado exitosamente.');
    }

    public function render()
    {
        $userId= auth()->user()->id;
        $grupos = Grupos::where('user_id', $userId)->get();

        $data= MiembrosGrupo::whereHas('grupo', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(5)
        ->through(function ($item) {
            return [
                'miembro_id' => $item->miembro_id,
                'grupo_id' => $item->grupo_id,
                'nombre' => $item->miembro->getFullNameAttribute(),
                'fechaNac' => $item->miembro->fecha_nac,
                'grupo' => $item->grupo->nombre,
                'estado' => $item->estado
            ];
        });

        return view('livewire.miembros', compact('grupos', 'data'));
    }
}
