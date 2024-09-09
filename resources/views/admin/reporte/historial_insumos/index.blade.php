@extends('adminlte::page')

@section('title', 'Agendas')


@section('content_header')

@stop

@section('content')

    @include('admin.reporte.historial_insumos.filtro')
    @include('admin.reporte.historial_insumos.data')
    <br>
@stop

@section('js')
<script src=" {{ asset('js/comunes.js') }} "></script>
<script src=" {{ asset('js/logicaReporte.js') }} "></script>

<script>
$(document).ready(function() {
    // grafic();  
});
function filtar(){
    historial();
    historialdos();
}

var _urlmodal = "{{ route('admin.reporte.historial.insumos.data') }}" + '?insumo=';
    var data1 = {
        table: "tablaListadoHistorial",
        ajax : _urlmodal,
        topMsg: "",
        filename: "Listado",
        title: 'Listado',
        columns: [
            {data: 'name', name: 'name', title: 'Insumo',class: 'noexport dt-center'},
            {data: 'ca', name: 'servicio', title: 'Cantidad',class: 'noexport dt-center'},
            {data: 'toto', name: 'colaborador', title: 'Gastado',class: 'noexport dt-center'},
            {data: 'costo', name: 'colaborador', title: 'Costo (Por Paquetes /Unitario)',class: 'noexport dt-center'},
        ]
};
toDataTableSimple(data1)
var _urlml = "{{ route('admin.reporte.historial.insumos.data') }}" + '?insumo=';
    var data = {
        table: "tablados",
        ajax : _urlml,
        topMsg: "",
        filename: "Listado",
        title: 'Listado',
        columns: [
            {data: 'name', name: 'fecha', title: 'Insumo',class: 'noexport dt-center'},
            {data: 'ca', name: 'servicio', title: 'Cantidad',class: 'noexport dt-center'},
            {data: 'toto', name: 'colaborador', title: 'Gastado',class: 'noexport dt-center'},
            {data: 'costo', name: 'colaborador', title: 'Costo (Por Paquetes /Unitario)',class: 'noexport dt-center'},
        ]
    };
    toDataTableSimple(data)
function activos (algo){
    if ($(algo).prop('checked')) {
        $('#fecha_dos').css('display','block')
        $('#comparacion').css('display','block')
    }else{
        $('#fecha_dos').css('display','none')
        $('#comparacion').css('display','none')
    }
}
function callback(){
        $('.loader').hide()
}  
function historial(){
    if ($('#insumo').val()) {
        $('.loader').show()
        var _url = "{{ route('admin.reporte.historial.insumos.data') }}" + '?insumo='+$('#insumo').val()+'&desde='+$('#desde').val()+'&hasta='+$('#hasta').val();
        var table = $('#tablaListadoHistorial').DataTable();
        table.ajax.url(_url).load(callback);
    }
}
function historialdos(){
    if ($('#insumo').val()) {
        var _url = "{{ route('admin.reporte.historial.insumos.data') }}" + '?insumo='+$('#insumo').val()+'&desde='+$('#desde_c').val()+'&hasta='+$('#hasta_c').val();
        var table = $('#tablados').DataTable();
        table.ajax.url(_url).load();
    }
}
    function getFormatGS(num)
    {
            if(!isNaN(num)){
                num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
                num = num.split('').reverse().join('').replace(/^[\.]/,'');
                return num;
            }
            return 0;
    }
    </script>
@stop
