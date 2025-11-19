<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <livewire:miembros />
                    {{-- <form action="{{ route('miembro.create') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2 md:col-span-1">
                                <label for="nombre" class="">Nombre:</label>
                                <input type="text" class="" id="nombre" name="nombre">
                                @if($errors->has('nombre'))
                                    <p class="text-red-800">{{ $errors->first('nombre') }}</p>
                                @endif
                              </div>
                              <div class="col-span-2 md:col-span-1">
                                <label for="apellidos" class="">Apellido</label>
                                <input type="text" class="" id="apellidos" name="apellidos">
                                @if($errors->has('apellidos'))
                                    <p class="text-red-800">{{ $errors->first('apellidos') }}</p>
                                @endif
                              </div>
                              <div class="col-span-2 md:col-span-1">
                                <label for="fecha_nac" class="">Fecha de Nacimiento:</label>
                                <input type="date" class="" id="fecha_nac" name="fecha_nac" max="{{ date('Y-m-d')}}" min="{{"1945-01-01" }}">
                                @if($errors->has('fecha_nac'))
                                    <p class="text-red-800">{{ $errors->first('fecha_nac') }}</p>
                                @endif
                              </div>
                              <div class="col-span-2 md:col-span-1">
                                <label for="grupo_extra" class="">Pertenece a:</label>
                                <select id="grupo_extra" class="" name="grupo_extra">
                                  <option selected disabled>Seleccione un grupo</option>
                                  <option value="EBD">EBD</option>
                                  <option value="CDR">CDR</option>
                                  <option value="MA">MA</option>
                                </select>
                                @if($errors->has('grupo_extra'))
                                    <p class="text-red-800">{{ $errors->first('grupo_extra') }}</p>
                                @endif
                              </div>
                        </div>

                        <div class="flex justify-center mt-4">
                        <div class="">
                            <button type="submit" class="">Submit</button>
                        </div>
                        </div>
                    </form> --}}

                </div>
            </div>

            {{-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-2 flex justify-center">
                <table class="table-auto border border-gray-300 rounded-lg w-[90%] m-4 shadow-lg">
                    <thead class="bg-gray-400 text-white">
                        <tr>
                            <th class="py-3 px-4 text-left">Nombre</th>
                            <th class="py-3 px-4 text-left">Fecha de Nacimiento</th>
                            <th class="py-3 px-4 text-left">Grupo extra</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($miembros as $miembro)
                        <tr class="hover:bg-gray-100">
                            <td class="py-2 px-4 text-gray-700">{{ $miembro->nombre }} {{ $miembro->apellidos }}</td>
                            <td class="py-2 px-4 text-gray-700">{{ $miembro->fecha_nac }}</td>
                            <td class="py-2 px-4 text-gray-700">{{ $miembro->grupo_extra }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> --}}
        </div>
    </div>
</x-app-layout>
