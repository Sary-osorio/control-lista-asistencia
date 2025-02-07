<x-app-layout>
    <x-slot name="header">

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex justify-center items-center flex-col">
                <h1 class="mt-4 text-blue-500 text-lg font-bold">Marque la asistencia de este dia:</h1>
                <div class="p-6 text-gray-900 w-full">
                    <table class="">
                        <thead class="">
                              <tr>
                                <th>Nombre</th>
                                <th>Fecha {{ now()->format('d-m-Y') }}</th>
                                <th>Mensaje</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($miembros as $miembro)
                                    <tr>
                                        <td>{{ $miembro['nombre'] }} {{ $miembro['apellidos'] }}</td>
                                        <td>
                                            @php
                                                $checkboxId = 'asistio_' . $miembro['id'];
                                            @endphp

                                            <input type="checkbox" class="asistencia-checkbox" id="{{ $checkboxId }}" style="display: none" data-id="{{ $miembro['id'] }}" @if($miembro['asistio']) checked @endif >
                                            <label class="switch" for="{{ $checkboxId }}"></label>

                                        </td>
                                        <td>
                                            @php
                                                $mensajeId = 'mensaje_' . $miembro['id'];
                                            @endphp
                                            <input type="checkbox" class="mensaje-checkbox" id="{{ $mensajeId }}" style="display: none"  data-id-mensaje="{{ $miembro['id'] }}" @if($miembro['mensaje']) checked disabled @endif>
                                            <label class="switch" for="{{ $mensajeId }}"></label>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                          </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function() {
        $('input[type="checkbox"]').change(function() {
            var id = $(this).data('id') || $(this).data('id-mensaje');

            let asistio = $("#asistio_" + id).is(":checked") ? 1 : 0;
            let mensaje = $("#mensaje_" + id).is(":checked") ? 1 : 0;

            if (asistio) {
            $("#asistio_" + id).prop("disabled", true);
            }

            if (mensaje) {
            $("#mensaje_" + id).prop("disabled", true);
            }


            var url = "{{ route('asistencia.create') }}";
            var data = {
                _token: "{{ csrf_token() }}",
                miembro_id: id,
                asistio: asistio,
                mensaje: mensaje
            };
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function(response) {
                    console.log(response);
                }
            });
        });

    //     (".mensaje-checkbox").on("change", function() {
    //     let mensajeActivo = $(this).is(":checked"); // Verifica si se activó

    //     // Deshabilita todos los demás checkboxes de mensaje si uno está activo
    //     if (mensajeActivo) {
    //         $(".mensaje-checkbox").not(this).prop("disabled", true);
    //     } else {
    //         // Si se desactiva, habilita todos los checkboxes de mensaje nuevamente
    //         $(".mensaje-checkbox").prop("disabled", false);
    //     }
    // });

    });
</script>

<style>
    .switch {
    display: inline-block;
    position: relative;
    width: 50px;
    height: 25px;
    border-radius: 20px;
    background: #dfd9ea;
    transition: background 0.28s cubic-bezier(0.4, 0, 0.2, 1);
    vertical-align: middle;
    cursor: pointer;
    }
    .switch::before {
        content: '';
        position: absolute;
        top: 1px;
        left: 2px;
        width: 22px;
        height: 22px;
        background: #fafafa;
        border-radius: 50%;
        transition: left 0.28s cubic-bezier(0.4, 0, 0.2, 1), background 0.28s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.28s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .switch:active::before {
        box-shadow: 0 2px 8px rgba(0,0,0,0.28), 0 0 0 20px rgba(128,128,128,0.1);
    }
    input:checked + .switch {
        background: #72da67;
    }
    input:checked + .switch::before {
        left: 27px;
        background: #fff;
    }
    input:checked + .switch:active::before {
        box-shadow: 0 2px 8px rgba(0,0,0,0.28), 0 0 0 20px rgba(0,150,136,0.2);
    }
    #asisitio {
        display: none;
    }
</style>
