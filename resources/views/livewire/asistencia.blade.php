<div>
    @error('miembroId')
        <div class="alert alert-danger">
            {{ $message }}
        </div>
    @enderror
    {{ $grupoId, $fecha}}
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex justify-center items-center flex-col">
            <div class="flex flex-row justify-between items-center w-full">
                {{-- <form wire:submit.prevent="buscarFecha"> --}}
                <div class="flex flex-col lg:flex-row items-center w-9/12">
                    <h1 class=" pe-4">Marque la asistencia de este dia:</h1>
                    <input type="date"
                        wire:model="fecha"
                        wire:change="buscarFecha"
                        class="my-2 lg:my-0 max-w-72 lg:max-w-auto"
                        id="buscar" name="buscar" {{-- value="{{ $fecha}}"   --}} max="{{ date('Y-m-d') }}"
                        min="{{ '1945-01-01' }}">
                        <p>Grupo:</p>
                        <select wire:model="grupoId" wire:change="changeGrupo" class="my-2 lg:my-0 max-w-72 lg:max-w-auto">
                            @foreach ($grupos as $grupo)
                                <option value="{{ $grupo->id }}">{{ $grupo->nombre }}</option>
                            @endforeach
                        </select>
                    {{-- <button class="mx-4" type="submit" > Buscar Fecha</button> --}}
                </div>
                {{-- </form> --}}

                <div class="w-3/12 flex justify-end">
                    <button class="bg-lime-500 hover:bg-lime-700 text-white font-bold py-2 px-4 rounded"
                        id="openModal">Guardar asistencia</button>
                </div>
            </div>
            <div class="w-full mt-6">
                <table class="w-full p-0 m-0">
                    <thead class="">
                        <tr>
                            <th>Nombre</th>
                            <th>Fecha {{ $fecha }}</th>
                            {{-- <th>Mensaje</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($miembros as $miembro)
                            <tr>
                                <td>{{ $miembro['nombre'] }} </td>
                                <td>
                                    @php
                                        $checkboxId = 'asistio_' . $miembro['id'];
                                        $nu = 'aqui';
                                    @endphp
                                    <input type="checkbox" class="asistencia-checkbox" style="display: none"
                                        id="{{ $checkboxId }}"
                                        wire:change="actualizarAsistencia({{ $miembro['id'] }})"
                                        @if ($miembro['asistio']) checked @endif>

                                    <label class="switch" for="{{ $checkboxId }}"></label>

                                </td>
                                {{-- <td>
                                            @php
                                                $mensajeId = 'mensaje_' . $miembro['id'];
                                            @endphp
                                            <input type="checkbox" class="mensaje-checkbox" id="{{ $mensajeId }}" style="display: none"  data-id-mensaje="{{ $miembro['id'] }}" @if ($miembro['mensaje']) checked disabled @endif>
                                            <label class="switch" for="{{ $mensajeId }}"></label>
                                        </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
