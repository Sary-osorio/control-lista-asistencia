<div>
    @error('miembroId')
        <div class="alert alert-danger">
            {{ $message }}
        </div>
    @enderror

    @error('general')
        <div class="bg-red-500 text-white px-4 py-2 rounded mb-3">
            {{ $message }}
        </div>
    @enderror

    {{-- {{ $fecha }} -
    {{ $grupoId }} --}}
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="">
            <div class="">
                <form wire:submit.prevent="guardarAsistencia" class="flex flex-row justify-between items-center">
                    <div class="flex flex-col  lg:flex-row items-center w-9/12 bg-red">
                        <h1 class="pe-4">Marque la asistencia de este dia:</h1>
                        <div class=" w-1/4">
                            <input type="text" wire:model.defer="fecha"class="my-2 lg:my-0 max-w-72 lg:max-w-auto"
                                id="fecha" name="fecha">

                            @error('fecha')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <p class="mx-2">Grupo:</p>
                        <div class=" w-1/4">
                            <select wire:model.defer="grupoId" wire:change="changeGrupo"
                                class="my-2 lg:my-0 max-w-72 lg:max-w-auto">
                                @foreach ($grupos as $grupo)
                                    <option value="{{ $grupo->id }}">{{ $grupo->nombre }}</option>
                                @endforeach
                            </select>
                            @error('grupoId')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror

                        </div>
                        {{-- <button class="mx-4" type="submit" > Buscar Fecha</button> --}}
                    </div>
                    @if (isset($estado_fecha) && $estado_fecha == '0')
                        <div class="w-3/12 flex justify-end ms-2">
                            <button class="bg-lime-500 hover:bg-lime-700 text-white font-bold py-2 px-4 rounded"
                                id="openModal">Guardar asistencia</button>
                        </div>
                    @endif
                </form>
            </div>


            <div class="w-full h-[1px]  mt-8 mb-4"></div>
            @if ($miembros->isEmpty())
                <p class="text-3xl text-center text-gray-400 font-bold my-4">No hay miembros disponibles</p>
            @else
                <div class="w-full mt-6 ">
                    <table class="w-full p-0 m-0 rounded-xl overflow-hidden">
                        <thead class="">
                            <tr>
                                <th class="px-3 py-2">Nombre</th>
                                <th class="px-3 py-2">Fecha {{ $fecha }}</th>
                                {{-- <th>Mensaje</th> --}}
                            </tr>
                        </thead>
                        {{-- @json($miembros) --}}
                        <tbody>
                            @foreach ($miembros as $miembro)
                                <tr>
                                    <td>{{ $miembro['nombre'] }} </td>
                                    <td>
                                        @php
                                            $checkboxId = 'asistio_' . $miembro['id'];
                                        @endphp
                                        <input type="checkbox" class="asistencia-checkbox" style="display: none"
                                            id="{{ $checkboxId }}" {{-- wire:change="actualizarAsistencia({{ $miembro['id'] }})" --}}
                                            wire:model.defer="asistencias.{{ $miembro['id'] }}"
                                            wire:key="asistio-{{ $miembro['id'] }}-{{ $asistencias[$miembro['id']] ?? '0' }}"
                                            @if (
                                                (isset($asistencias[$miembro['id']]) && $asistencias[$miembro['id']] == true) ||
                                                    (isset($estado_fecha) && $estado_fecha != '0')) disabled @endif>

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
                    {{-- @json($asistencias) --}}
                </div>
            @endif
        </div>
    </div>



</div>



@script
    <script>
        $(document).ready(function() {
            new AirDatepicker('#fecha', {
                lang: 'es',
                minDate: new Date('1945-01-01'),
                maxDate: new Date(),
                dateFormat: 'dd-MM-yyyy',
                position: 'bottom left',
                autoClose: true,
                locale: {
                    days: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                    daysMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                    months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
                        'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                    ],
                    monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct',
                        'Nov', 'Dic'
                    ],
                    today: 'Hoy',
                    clear: 'Limpiar',
                    close: 'Cerrar',
                    firstDay: 0
                },
                onSelect: ({
                    date,
                    formattedDate,
                    datepicker
                }) => {
                    @this.fecha = formattedDate;
                    $wire.call('changeFecha');

                    // $wire.$refresh()
                }
            });


        });
    </script>
@endscript
