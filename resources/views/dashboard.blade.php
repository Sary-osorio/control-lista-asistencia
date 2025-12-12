<x-app-layout>
    {{-- <x-slot name="header"> --}}
    {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gr') }}
        </h2> --}}
    {{-- </x-slot> --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <div class="p-6 space-y-6">

                    {{-- Title --}}
                    <div>

                        <h1 class="text-2xl font-bold text-gray-800">Bienvenido {{ auth()->user()->name }}</h1>
                        <p class="text-gray-600">Resumen general de asistencia, ausencias y actividad reciente</p>
                    </div>

                    {{-- Cards --}}
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                        <div class="bg-white shadow rounded-xl p-4 border">
                            <p class="text-gray-500 text-sm">Asistencia de hoy</p>
                            <p class="text-3xl font-bold text-green-600">2%</p>
                        </div>

                        <div class="bg-white shadow rounded-xl p-4 border">
                            <p class="text-gray-500 text-sm">Miembros en el grupo</p>
                            <p class="text-3xl font-bold">20</p>
                        </div>

                        <div class="bg-white shadow rounded-xl p-4 border">
                            <p class="text-gray-500 text-sm">Ausentes hoy</p>
                            <p class="text-3xl font-bold text-red-500">2</p>
                        </div>

                        <div class="bg-white shadow rounded-xl p-4 border">
                            <p class="text-gray-500 text-sm">Asistencias del mes</p>
                            <p class="text-3xl font-bold">15</p>
                        </div>
                    </div>

                    {{-- Quick Action --}}
                    <div class="flex justify-end">
                        <a href="{{ route('asistencia.index') }}"
                            class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg shadow">
                            Tomar asistencia ahora
                        </a>
                    </div>

                    {{-- Tabla del día --}}
                    <div class="bg-white shadow rounded-xl border p-4">
                        <h2 class="text-lg font-semibold mb-3">Asistencia del día</h2>

                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-gray-100 text-left border-b">
                                    <th class="py-2 px-3">Nombre</th>
                                    <th class="py-2 px-3">Estado</th>
                                    <th class="py-2 px-3">Hora</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($registros as $item) --}}
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-2 px-3">Daniela Osorio</td>

                                    <td class="py-2 px-3">
                                        {{-- @if ($item->asistio) --}}
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs">
                                            Asistió
                                        </span>
                                        {{-- @else
                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs">
                                    Ausente
                                </span>
                            @endif --}}
                                    </td>

                                    {{-- <td class="py-2 px-3">
                            {{ $item->hora ?: '—' }}
                        </td> --}}
                                </tr>
                                {{-- @endforeach --}}
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-2 px-3">Daniela Osorio</td>

                                    <td class="py-2 px-3">

                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs">
                                    Ausente
                                </span>

                                    </td>

                                     <td class="py-2 px-3">
                            {{ '04:00' ?: '—' }}
                        </td>
                                </tr>

                        </table>
                    </div>

                </div>



            </div>
        </div>
    </div>
</x-app-layout>
