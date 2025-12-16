<div>
    <div class="flex flex-col justify-center ">
        {{$fechaListado}}
         {{$grupoId}}
        {{-- <div class="bg-yellow-300 m-0 p-0"> --}}
            <h1 class="text-center mb-4">Listado de Asistencia</h1>
            <form wire:submit.prevent="buscarAsistencia" class="flex items-center justify-center">
                    <div class="p-4 w-full grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="">
                            <label class="text-sm font-semibold">Fecha</label>
                            <input
                                type="text"
                                wire:model.defer="fechaListado"
                                class="my-2 lg:my-0 w-full rounded-lg border-gray-300"
                                id="fecha" name="fecha">
                            @error('fecha')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="">
                            <label class="text-sm font-semibold">Grupo</label>
                            <select
                                wire:model.defer="grupoId"
                                wire:change="changeGrupo"
                                class="my-2 lg:my-0 w-full rounded-lg border-gray-300">
                                @foreach ($grupos as $grupo)
                                    <option value="{{ $grupo->id }}">{{ $grupo->nombre }}</option>
                                @endforeach
                            </select>
                            @error('grupoId')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex items-end ">
                            <button class="w-full block max-w-full bg-blue-600 text-white py-2 rounded-lg shadow hover:bg-blue-700"
                                id="openModal">Buscar asistencia</button>
                        </div>
                    </div>
                </form>
        {{-- </div> --}}
        <div class="w-full h-[1px] bg-gray-200 mt-6 mb-8"></div>

        <!-- Resumen -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="p-4 bg-green-100 text-green-700 rounded-xl text-center">
            <span class="text-3xl font-bold">{{ count($asistencias->filter(fn($a) => $a['asistio'] == 1)) }}</span>
            <p>Asistieron</p>
        </div>

        <div class="p-4 bg-red-100 text-red-700 rounded-xl text-center">
            <span class="text-3xl font-bold">{{ count($asistencias->filter(fn($a) => $a['asistio'] == 0)) }}</span>
            <p>No asistieron</p>
        </div>

        <div class="p-4 bg-gray-200 text-gray-700 rounded-xl text-center">
            <span class="text-3xl font-bold">{{ count($asistencias) }}</span>
            <p>Total</p>
        </div>
    </div>
    @json($asistencias)
        <div class="mt-6">
                    <table class="w-full p-0 m-0   ">
                        <thead class="">
                            <tr>
                                <th class=" px-3 py-2">Nombre</th>
                                <th class=" px-3 py-2">Fecha</th>
                                <th class=" px-3 py-2">Estado</th>
                                <th class=" px-3 py-2">Grupo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($asistencias as $asistencia)
                                <tr>
                                    <td class=" px-3 py-2">
                                        {{ $asistencia['nombre'] }}
                                    </td>
                                    <td class=" px-3 py-2">
                                        {{ $asistencia['fecha'] }}
                                    </td>
                                    <td class=" px-3 py-2">
                                            @if($asistencia['asistio'])
                                                <span class="inline-flex items-center gap-1 px-6 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full ">
                                                    Asistió
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-4 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">
                                                    No asistió
                                                </span>
                                            @endif
                                    </td>
                                    <td class=" px-3 py-2">
                                        {{ $asistencia['grupo'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="flex items-center justify-center space-x-1 mt-2">
            @foreach ($asistencias->links()->elements[0] ?? [] as $page => $url)
                @if ($page == $asistencias->currentPage())
                    <span class="px-4 py-2 bg-gray-800 text-white rounded-lg shadow-md font-semibold">
                        {{ $page }}
                    </span>
                @else
                    <button wire:click="gotoPage({{ $page }})"
                        class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-blue-100 transition">
                        {{ $page }}
                    </button>
                @endif
            @endforeach
        </div>
            </div>

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
                    @this.fechaListado = formattedDate;
                    $wire.call('changeFecha');

                    // $wire.$refresh()
                }
            });


        });
    </script>
@endscript
