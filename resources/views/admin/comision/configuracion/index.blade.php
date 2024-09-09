@extends('adminlte::page')

@section('title', 'Usuarios')

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('content_header')
<h1>Usuarios</h1>
@stop
comunes
@section('content')
<!-- Tabla -->
<div>
    <div class="card">
        <div class="card-body">
            <table class="table table-striped" id="tablaCrud" style="width:100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Colaborador</th>
                        <th>Activo</th>
                        <th>Entidad</th>
                        <th>Sucursal</th>
                        <th width='120px'>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!-- Tabla -->
<!-- Modal -->
<div class="modal fade" id="modal_colaborador"  role="dialog" aria-labelledby="formCrudModalTitle" aria-hidden="true">
    <div class="modal-dialog agrandar" role="document">
        <form id="formCrud">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formCrudModalTitle">Configurar los servicios del Colaborador</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="user_id" name="user_id">
                    <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-productos-tab" data-toggle="pill" href="#pills-productos"
                                role="tab" aria-controls="pills-productos" aria-selected="true">Productos y/o Servicios</a>
                        </li>
                    </ul>
                    <div class="container">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane  show active" id="pills-productos" role="tabpanel" aria-labelledby="pills-productos-tab">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <select id="articulo" class=" form-control select2" style="width: 100%">
                                                <option value="">Elija un Servicio</option>
                                                <optgroup label="Servicios">
                                                    @foreach ($articulos as $ser)
                                                        @if ($ser->tipo == 'servicio')
                                                            <option value="{{ $ser->id }}">{{ $ser->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="container">
                                    <table class="table table-striped" id="tabla-lista">
                                        <thead>
                                            <tr>
                                                <th>Servicio</th>
                                                <th>Porcentaje</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="sumbitButton" class="btn btn-primary" type="submit">
                        <span id="submitSpinner" class="spinner-border-sm" role="status" aria-hidden="true"></span>
                        Guardar
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal -->
@stop


@section('js')

<script src=" {{ asset('js/comunes.js') }} "></script>
<script>
    $( document ).ready(function() {
        var data = {
            table: "tablaCrud",
            ajax : "{{ route('admin.comisiones.datatable') }}",
            topMsg: "",
            footerMsg: "Generado",
            filename: "Listado de Usuarios",
            title: 'Listado de Usuarios',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'es_colaborador', name: 'es_colaborador', render: function(data, type, row){ return (data) ? 'SI' : 'NO' ; }, className: 'text-center'},
                {data: 'es_activo', name: 'es_activo', render: function(data, type, row){  return (data) ? 'SI' : 'NO' ; }, className: 'text-center'},
                {data: 'entidad_name', name:'entidad_name'},
                {data: 'sucursal_name', name:'sucursal_name'},
                {data: 'acciones', name: 'acciones', orderable: false, searchable: false, class: 'noexport'}
            ]
        };
        toDataTable(data);

    });
    @php
        echo ' var articulos = '.($articulos).'; ';
        echo ' var entidad_id = '.( auth()->user()->entidad_id ).'; ';
        echo ' var sucursal_id = '.( auth()->user()->sucursal_id ).'; ';
    @endphp
    function abrirServicio( ruta,id ){
    $('#user_id').val(id);
    getData(ruta).then(function(data){
        $('#tabla-lista tbody tr').remove();
        var dat=jQuery.parseJSON(data);
        if(dat.length > 0){
            $.each(dat, function (key, el){
                var ele = articulos.find( item => item.id == el.servicio_id );
                ele.porcentaje = el.porcentaje;
                $('#tabla-lista tbody').append([ele].map(Item).join(''));
            });
        }
        $('#modal_colaborador').modal('show')
        
    }).catch(function(error){
        console.log('append dio error'); console.log(error);
        Swal.fire('Ocurrio un Error', error.message, 'error');
    });
    }
    const Item = ({ id, name, costo, precio, porcentaje }) => ` 
        <tr id="tr_${id}">
        <td>${name}</td>
        <td>
            <input size="3" type="hidden" name="articulos[${id}][id]" id="opcion[][id]" value="${id}">
            <input size="3" type="numeric" name="articulos[${id}][porcentaje]" id="opcion[][porcentaje]" value="${porcentaje}" class="text-center">
        </td>
        <td>
            <a class="btn btn-danger btn-sm" role="button" onclick="eliminarProducto(${id})"> <i class="fa fa-trash"></i></a>
        </td>
    </tr>`;
    $('#articulo').on('change', function(){
        var id = $(this).val();
        if( id != '' ){
            var ele = articulos.find( item => item.id == id  );
            ele.porcentaje = 30;
            console.log($('#tabla-lista tbody #tr_'+ele.id))
            if(  $('#tabla-lista tbody #tr_'+ele.id).length > 0 ){
                toastr.options = { "closeButton": true, };
                toastr.error('Si desea puede modificar El porcentaje, pero no puede duplicar el Servicio', 'Ese Servicio ya esta en la lista!');
            }else{
                $('#tabla-lista tbody').append([ele].map(Item).join(''));
            }
            $(this).val('');
        }
    });
function eliminarProducto(articulo){
var id = $('#user_id').val();
var formData = new FormData($('#formCrud')[0]);
formData.append('articulo_id', articulo);
formData.append('id', id);
var ruta = " {{ route('admin.comisiones.destroy') }} ";
postData(ruta, formData).then(function(rta){
    $('#tr_' + articulo).remove();
    toastr.options = { "closeButton": true, };
    toastr.success(rta['msg'], 'Buen Trabajo!');
}).catch(function(error){
    console.log('postData dio error'); console.log(error);
    Swal.fire('Ocurrio un Error', error, 'error');
});
}

    $('[data-toggle="tooltip"]').tooltip();
    $('#formCrud').on('submit', function(e){
        e.preventDefault();
        var ruta = "{{ route('admin.comisiones.store') }}";
        var formData = new FormData($('#formCrud')[0]);
        postData(ruta, formData).then(function(rta){
            console.log(rta);
            toastr.options = { "closeButton": true, };
            toastr.success(rta['msg'], 'Buen Trabajo!');
        }).catch(function(error){
            console.log('postData dio error'); console.log(error);
            Swal.fire('Ocurrio un Error', error, 'error');
        });
    });



</script>
@stop
