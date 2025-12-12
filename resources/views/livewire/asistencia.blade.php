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
            <h1 class=" text-center">Registre la asistencia del día</h1>
            <div class="">
                <form wire:submit.prevent="guardarAsistencia" class="flex items-center justify-center">
                    <div class="p-4 w-full grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="">
                            <label class="text-sm font-semibold">Fecha</label>
                            <input type="text" wire:model.defer="fecha"
                                class="my-2 lg:my-0 w-full rounded-lg border-gray-300 lg:max-w-auto" id="fecha"
                                name="fecha">

                            @error('fecha')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="">
                            <label class="text-sm font-semibold">Grupo</label>
                            <select wire:model.defer="grupoId" wire:change="changeGrupo"
                                class="my-2 lg:my-0  lg:max-w-auto w-full rounded-lg border-gray-300">
                                @foreach ($grupos as $grupo)
                                    <option value="{{ $grupo->id }}">{{ $grupo->nombre }}</option>
                                @endforeach
                            </select>
                            @error('grupoId')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror

                        </div>
                        {{-- <button class="mx-4" type="submit" > Buscar Fecha</button> --}}
                        @if (isset($estado_fecha) && $estado_fecha == '0')
                            <div class="flex items-end">
                                <button
                                    class="bg-lime-500 hover:bg-lime-700 text-white font-bold py-2 px-4 rounded-lg shadow w-full max-w-full"
                                    id="openModal">Guardar asistencia</button>
                            </div>
                        @elseif(isset($estado_fecha) && $estado_fecha == '1')
                        <div class="flex items-end">
                            <div class="flex items-center bg-lime-50 border border-lime-200
                                text-lime-600  px-4 py-[10px] rounded-xl shadow-sm">

                                {{-- Icono check --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-lime-700" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>

                                <p class="text-sm font-medium ps-2">
                                    La asistencia de este día ya fue registrada.
                                </p>
                            </div>
                            </div>
                        @endif
                    </div>
                </form>
            </div>


            <div class="w-full h-[1px]  mt-4 mb-4"></div>
            @if ($miembros->isEmpty())
                <p class="text-3xl text-center text-gray-400 font-bold my-4">No hay miembros disponibles</p>
            @else
                <div class="w-full">
                    <div class="flex justify-between items-center px-2">
                        <h2 class="font-medium text-gray-800">
                            Marca quién asistió
                        </h2>

                        <!-- Contador dinámico -->
                        <span class="text-gray-600 text-sm bg-gray-100 px-3 py-1 rounded-full">
                            Asistieron:
                            <strong>{{ collect($asistencias)->filter(fn($a) => $a)->count() }}</strong>
                            /
                            {{ count($miembros) }}
                        </span>
                    </div>
                    <div class="w-full h-[0.5px] bg-gray-200 mt-1 mb-6"></div>
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
                                            id="{{ $checkboxId }}"
                                            wire:change="changeAsistencias"
                                            wire:model="asistencias.{{ $miembro['id'] }}"
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
                    {{-- @json($asistencias)    --}}
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
