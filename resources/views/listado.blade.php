<x-app-layout>
    <x-slot name="header">

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('asistencia.listado') }}" method="GET">
                        <div class="flex flex-col lg:flex-row items-center justify-center">

                                <label for="buscar" class="me-2">Fecha de lista:</label>
                                <input type="date" class="my-2 lg:my-0 max-w-72 lg:max-w-auto" id="buscar" name="buscar" max="{{ date('Y-m-d')}}" min="{{"1945-01-01" }}">


                                <button class="mx-4" type="submit" > Buscar</button>

                          </div>
                          @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                    </form>

                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-2 flex justify-center items-center flex-col">
                <h1 class="mt-4 text-blue-500 text-lg font-bold">Lista de asistencia de la fecha {{ \Carbon\Carbon::parse(request('buscar', date('Y-m-d')))->format('d/m/Y') }}</h1>
                <table class="table-auto border w-[90%] m-4">
                    <thead>
                      <tr>
                        <th>Nombre</th>

                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($miembros as $miembro)
                      <tr>
                        <td>{{ $miembro->nombre }} {{ $miembro->apellidos }}</td>
                      </tr>
                        @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
</x-app-layout>
