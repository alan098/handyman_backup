@extends('adminlte::page')


@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('content_header')
<h1>Cumpleaños</h1>
@stop

@section('content')
<!-- Tabla -->
<div>
    @include('admin.recordatorio.cumple.filtro')
    @include('admin.cuentas.index.historial')
    <div class="card">
        <div class="card-body">
            <table class="table table-striped" id="tablaCrud" style="width:100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Ruc</th>
                        <th>Nombre</th>
                        <th>Direccion</th>
                        <th>Telefono</th>
                        <th>Fecha Nacimiento</th>
                        <th width='120px'>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!-- Tabla -->
<!-- Modal -->

<!-- Modal -->
@stop
@section('js')
<script src=" {{ asset('js/comunes.js') }} "></script>
<script>
$( document ).ready(function() {
$('.datepicker_eclusivo').datepicker({
    language:'es',
    dateFormat: "yy-mm-dd",
});
var _url = "{{ route('admin.recordatorios.cumple.data') }}" + '?cliente_id='+$('#cliente_id').val()+'&desde='+$('#desde').val()+'&hasta='+$('#hasta').val();
    var data = {
        table: "tablaCrud",
        ajax : _url,
        topMsg: "",
        filename: "Listado",
        title: 'Listado',
        columns: [
            {data: 'id', name: 'id', title: 'ID',class: 'noexport dt-center'},
            {data: 'name', name: 'Nombre', title: 'Cliente',class: 'noexport dt-center'},
            {data: 'nombre_fantasia', name: 'nombre fantasia', title: 'Nombre fantasia',class: 'noexport dt-center'},
            {data: 'direccion', name: 'direccion', title: 'Direccion',class: 'noexport dt-center'},
            {data: 'telefono', name: 'telefono', title: 'Telefono',class: 'noexport dt-center'},
            {data: 'cumple', name: 'cumple', title: 'Fecha de Cumple',class: 'noexport dt-center'},
            {data: 'acciones', name: 'acciones',title:"Acciones", orderable: false, searchable: false, class: 'noexport dt-center'}
        ]
    };
    toDataTable(data);

});

function filtrar(){
    console.log("filtrando")
    var _url = "{{ route('admin.recordatorios.cumple.data') }}" + '?cliente_id='+$('#cliente_id').val()+'&desde='+$('#desde').val()+'&hasta='+$('#hasta').val();
    var table = $('#tablaCrud').DataTable();
    table.ajax.url(_url).load();
}
var _urlmodal = "{{ route('admin.cuenta.cliente.historial') }}" + '?cliente_id=';
var data = {
    table: "tablaListadoHistorial",
    ajax : _urlmodal,
    topMsg: "",
    filename: "Listado",
    title: 'Listado',
    columns: [
        {data: 'fecha', name: 'fecha', title: 'Fecha',class: 'noexport dt-center'},
        {data: 'servicio', name: 'servicio', title: 'Servicio / Producto',class: 'noexport dt-center'},
        {data: 'colaborador', name: 'colaborador', title: 'Colaborador',class: 'noexport dt-center'},
    ]
};
toDataTable(data)
function historial(id_cliente){
    var _url = "{{ route('admin.cuenta.cliente.historial') }}" + '?cliente_id='+id_cliente;
    var table = $('#tablaListadoHistorial').DataTable();
    table.ajax.url(_url).load();
    $('#modal_historial').modal('show')
}

</script>
@stop



