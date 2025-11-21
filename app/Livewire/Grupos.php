<?php

namespace App\Livewire;

use App\Models\Grupos as ModelsGrupos;
use GuzzleHttp\Psr7\Request;
use Livewire\Component;
use Livewire\WithPagination;

class Grupos extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';

    public $openModal = false;
    public $nombre;
    public $descripcion;

    public function abrirModal(){
        $this->openModal = true;
    }

    public function cerrarModal(){
        $this->openModal = false;
    }


    public function store()
    {
        $user=auth()->user()->id;

        $validated = $this->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        ModelsGrupos::create([
            'user_id' => $user,
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'] ?? null,
        ]);

        $this->reset(['nombre', 'descripcion']);
        $this->cerrarModal();

        session()->flash('message', 'Grupo creado exitosamente.');
    }

    public function render()
    {
        $userId=auth()->user()->id;
        $grupos = ModelsGrupos::where('user_id', $userId)
        ->orderBy('id', 'desc')
        ->paginate(5);

        return view('livewire.grupos', ['grupos' => $grupos]);
    }



}
