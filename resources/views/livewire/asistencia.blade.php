<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex justify-center items-center flex-col">
                <div class="flex  flex-row items-center w-full justify-around">
                    <div class=" text-center">
                        <h1 class="mt-4 text-blue-500 text-lg font-bold">Marque la asistencia de este dia:</h1>
                        <form wire:submit.prevent="buscarFecha">
                            <div class="flex flex-col lg:flex-row items-center justify-center">

                                    <label for="buscar" class="me-2"> </label>
                                    <input type="date"
                                    wire:model.defer="fecha"
                                    class="my-2 lg:my-0 max-w-72 lg:max-w-auto"
                                    id="buscar"
                                    name="buscar"
                                    {{-- value="{{ $fecha}}"   --}}
                                    max="{{ date('Y-m-d')}}"
                                    min="{{"1945-01-01" }}">


                                    <button class="mx-4" type="submit" > Buscar Fecha</button>

                              </div>

                        </form>
                    </div>
                    <div class="">
                        <button class="bg-lime-500 hover:bg-lime-700 text-white font-bold py-2 px-4 rounded mt-4" id="openModal">Guardar asistencia de otra fecha</button>
                    </div>
                </div>
                @error('miembroId')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror
                <div class="p-6 text-gray-900 w-full flex justify-center items-center">

                    <table class="">
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
                                                $nu='aqui';
                                            @endphp
                                            <input type="checkbox"
                                            class="asistencia-checkbox"
                                            style="display: none"
                                            id="{{ $checkboxId }}"
                                            wire:change="actualizarAsistencia({{ $miembro['id'] }})"
                                            @if($miembro['asistio']) checked @endif
                                            >

                                            <label
                                            class="switch"
                                            for="{{ $checkboxId }}"

                                            ></label>

                                        </td>
                                        {{-- <td>
                                            @php
                                                $mensajeId = 'mensaje_' . $miembro['id'];
                                            @endphp
                                            <input type="checkbox" class="mensaje-checkbox" id="{{ $mensajeId }}" style="display: none"  data-id-mensaje="{{ $miembro['id'] }}" @if($miembro['mensaje']) checked disabled @endif>
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
