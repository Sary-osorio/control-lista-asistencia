<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">


                <livewire:listado-asistencia />

            </div>

            {{-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-2 flex justify-center items-center flex-col">
                <h1 class="mt-4 text-blue-500 text-lg font-bold">Lista de asistencia de la fecha {{ \Carbon\Carbon::parse(request('buscar', date('Y-m-d')))->format('d/m/Y') }}</h1>
                <table class="table-auto border w-[90%] m-4">
                    <thead>
                      <tr>
                        <th>Nombre</th>

                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($listado as $miembro)
                      <tr>
                        <td>{{ $miembro->nombre }} {{ $miembro->apellidos }}</td>
                      </tr>
                        @endforeach
                    </tbody>
                  </table>
            </div> --}}
        </div>
    </div>
</x-app-layout>
