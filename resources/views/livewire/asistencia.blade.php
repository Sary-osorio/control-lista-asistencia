<div>
    @error('miembroId')
        <div class="alert alert-danger">
            {{ $message }}
        </div>
    @enderror
        {{ $fecha }}
        {{ $grupoId }}

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden  sm:rounded-lg flex justify-center items-center flex-col">
            <div class="w-full">
                <form wire:submit.prevent="guardarAsistencia" class="flex flex-row justify-between items-center">
                    <div class="flex flex-col lg:flex-row items-center w-9/12">
                        <h1 class=" pe-4">Marque la asistencia de este dia:</h1>

                        <input type="text" wire:model.defer="fecha"class="my-2 lg:my-0 max-w-72 lg:max-w-auto" id="fecha" name="fecha">

                        @error('fecha')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                        <p class="ms-2">Grupo:</p>
                        <select
                            wire:model.defer="grupoId"
                            wire:change="changeGrupo"
                            class="my-2 lg:my-0 max-w-72 lg:max-w-auto">
                            @foreach ($grupos as $grupo)
                                <option value="{{ $grupo->id }}">{{ $grupo->nombre }}</option>
                            @endforeach
                        </select>
                        @error('grupoId')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                        {{-- <button class="mx-4" type="submit" > Buscar Fecha</button> --}}
                    </div>
                    {{-- @if(isset( $guardarAsistencia ) && $guardarAsistencia == 0) --}}
                    <div class="w-3/12 flex justify-end ms-2">
                        <button class="bg-lime-500 hover:bg-lime-700 text-white font-bold py-2 px-4 rounded"
                            >Guardar asistenciaxd</button>
                    </div>
                    {{-- @endif --}}
                </form>
            </div>


            <div class="w-full h-[1px] bg-gray-200 mt-8 mb-4"></div>
            @if ($miembros->isEmpty())

                <p class="text-3xl text-center text-gray-400 font-bold my-4">No hay miembros disponibles</p>
            @else
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
                                    <td>{{ $miembro['nombre'] }} {{ $miembro['id'] }} </td>
                                    <td>
                                        {{-- @php
                                            $checkboxId = 'asistio_' . $miembro['id'];
                                        @endphp
                                        <input type="checkbox" class="asistencia-checkbox" style="display: none"
                                            id="{{ $checkboxId }}" {{-- wire:change="actualizarAsistencia({{ $miembro['id'] }})" --}}
                                            wire:model.defer="asistencias.{{ $miembro['id'] }}"
                                            wire:key="asistio-{{ $miembro['id'] }}-{{ $asistencias[$miembro['id']] ?? '0' }}"
                                            {{-- @if ($asistencias[$miembro['id']] == 1) disabled @endif --}}
                                        >

                                       {{-- <label class="switch" for="{{ $checkboxId }}"></label> --}}

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
                    @if ($errors->any())
                        <ul>
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif

                    @json($asistencias)
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
                    months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    today: 'Hoy',
                    clear: 'Limpiar',
                    close: 'Cerrar',
                    firstDay: 0
                },
                onSelect: ({date, formattedDate, datepicker}) => {
                    @this.fecha = formattedDate;
                    $wire.call('changeFecha');

                    // $wire.$refresh()
                }
            });


        })
    </script>

    <script>
    document.addEventListener('livewire:init', () => {
        Livewire.onError((error, component) => {
            console.error('Error Livewire:', error);
            alert(error.message);

            return false; // evita que Livewire lo maneje silenciosamente
        });
    });
    </script>

@endscript

