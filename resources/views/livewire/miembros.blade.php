<div>
    <div class="p-6 text-gray-900 flex justify-between items-center">
        <p class="">{{ __("Listado de miembros") }}</p>
        <x-primary-button wire:click="abrirModal">Agregar nuevo miembro</x-primary-button>
    </div>

    <div class=" flex justify-center p-0">
    <table class="">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Fecha de Nacimiento</th>
                <th>Grupo al que pertenece</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $miembro)
                <tr>
                    <td>{{ $miembro['nombre'] }}</td>
                    <td>{{ $miembro['fechaNac'] }}</td>
                    <td>{{ $miembro['grupo'] }}</td>
                    <td>
                        <button>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25z" fill="#3b82f6"/>
                                <path d="M20.71 7.04a1 1 0 000-1.41l-2.34-2.34a1 1 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" fill="#3b82f6"/>
                            </svg>
                        </button>
                        @if($miembro['estado'])
                        <button>
                            <svg width="24" height="24" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="50" cy="50" r="45" fill="#00c300"/>
                                <path d="M30 52 L45 67 L70 40" stroke="white" stroke-width="10" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                            </svg>
                        </button>
                        @else
                        <button>
                           <svg width="24" height="24" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="50" cy="50" r="45" fill="#ff0000"/>
                            <path d="M35 35 L65 65 M65 35 L35 65"
                                    stroke="white"
                                    stroke-width="10"
                                    stroke-linecap="round"/>
                            </svg>
                        </button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>

     @if($openModal)
        <x-modal show="true" name="crear-miembro" focusable>
           <div class="p-4">
                <h2 class="text-lg font-semibold mb-4">Agregar nuevo miembro al grupo</h2>

                <form wire:submit.prevent="storeMiembro">
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

                        <x-input-label for="apellido" :value="__('Apellido')" />

                                <x-text-input
                                id="apellido"
                                name="apellido"
                                class="block mt-1 w-full"
                                wire:model.defer="apellido">
                                </x-text-input>

                                {{-- <x-input-error :messages="$errors->get('apellido')" class="mt-2" /> --}}
                    </div>

                    <div class="py-3">

                        <x-input-label for="fechaNac" :value="__('Fecha de Nacimiento')" />

                                <x-text-input
                                type="date"
                                id="fechaNac"
                                name="fechaNac"
                                class="block mt-1 w-full"
                                wire:model.defer="fechaNac">
                                </x-text-input>

                                {{-- <x-input-error :messages="$errors->get('fecha_nacimiento')" class="mt-2" /> --}}
                    </div>

                    <div class="py-3">
                         <x-input-label for="grupo" :value="__('Grupo')" />

                        <select class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                         wire:model.defer="grupo"
                         name="grupo"
                         id="grupo">
                            <option value="">Seleccione un grupo</option>
                            @foreach ($grupos as $grupo)
                                <option value="{{ $grupo->id }}">{{ $grupo->nombre }}</option>
                            @endforeach
                        </select>

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
