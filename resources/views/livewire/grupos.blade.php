<div>
    <div class="p-6 text-gray-900 flex justify-between items-center">
        <p class="">{{ __("Mis grupos") }}</p>
        <x-primary-button wire:click="abrirModal">Agregar nuevo grupo</x-primary-button>
    </div>
    <div class="flex justify-center">
        <table>
            <thead>
                <tr>
                    <th>Nombre del grupo</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($grupos as $grupo)
                    <tr>
                        <td>{{ $grupo->nombre }}</td>
                        <td>{{ $grupo->descripcion }}</td>
                        <td>
                            {{-- <x-primary-button>Ver detalles</x-primary-button>
                            <x-primary-button>Editar</x-primary-button>
                            <x-primary-button>Eliminar</x-primary-button> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
   @if($openModal)
        <x-modal show="true" name="crear-grupo" focusable>
           <div class=" p-4">
                <h2 class="text-lg font-semibold mb-4">Nuevo Grupo</h2>



                <form wire:submit.prevent="store">
                    @csrf
                    <div class="py-2">
                        <x-input-label for="nombre" :value="__('Nombre')" />

                        <x-text-input
                        id="nombre"
                        name="nombre"
                        class="block mt-1 w-full"
                        wire:model.defer="nombre">
                        </x-text-input>

                    </div>

                    <div class="py-3">

                        <x-input-label for="descripcion" :value="__('Descripción')" />

                        <x-text-input
                        id="descripcion"
                        name="descripcion"
                        class="block mt-1 w-full"
                        wire:model.defer="descripcion">
                        </x-text-input>
                    </div>

                    <div class="flex justify-center gap-4 mt-4">
                        <button type="button" wire:click="cerrarModal"
                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                            Cancelar
                        </button>

                        <x-primary-button class="flex justify-center px-4 py-2">
                            Guardar
                        </x-primary-button>
                    </div>

                </form>


            </div>
        </x-modal>
    @endif
</div>



