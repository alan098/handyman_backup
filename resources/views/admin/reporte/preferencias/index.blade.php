@extends('adminlte::page')

@section('title', 'Agendas')


@section('content_header')

@stop

@section('content')

    @include('admin.reporte.preferencias.filtro')
    <br>
@stop

@section('js')
    <script src=" {{ asset('js/comunes.js') }} "></script>

    <script>
        $(document).ready(function() {
            ($(".fas fa-bars ")).click();
            $('.select2').select2().trigger('change');
        });

        function ver() {
            if (reglas()) {
                var ventana;
                var url = "{{ route('admin.preferencias.excel') }}" + '?desde=' + $('#fecha_desde').val() + '&hasta=' + $('#fecha_hasta').val();
                ventana = window.open(url, '_');
            }
        }

        function reglas() {
            if (!$('#fecha_desde').val()) {
                toadErrores('Necesita seleccionar un rango de fecha')
                return false;
            } else if (!($('#fecha_hasta').val())) {
                toadErrores('Necesita seleccionar un rango de fecha')
                return false;
            } else {
                return true
            }
        }
    </script>


@stop
