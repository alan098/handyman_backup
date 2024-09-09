@extends('adminlte::page')


@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('content_header')
<h1>Bancos</h1>
@stop

@section('content')
<!-- Tabla -->
<div>
    <div class="card">
        <div class="card-body">
            <table class="table table-striped" id="tablaCrud" style="width:100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Siglas</th>
                        <th>Activo</th>
                        <th>Codigo Iso</th>
                        <th>Nombre Iso</th>
                        <th width='120px'>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!-- Tabla -->
<!-- Modal -->
<div class="modal fade" id="formCrudModal" role="dialog" aria-labelledby="formCrudModalTitle" aria-hidden="true">
    <div class="modal-dialog agrandar" role="document">
        <form id="formCrud">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formCrudModalTitle">Nuevo Banco</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="" class="mb-1">Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control"  name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="" class="mb-1">Siglas</label>
                        <input type="text" class="form-control"  name="siglas" id="siglas" >
                    </div>
                    <div class="form-group">
                        <label for="" class="mb-1">Codigo Iso</label>
                        <input type="text" class="form-control"  name="cod_iso" id="cod_iso">
                    </div>
                    <div class="form-group">
                        <label for="" class="mb-1">Nombre Iso</label>
                        <input type="text" class="form-control"  name="nombre_iso" id="nombre_iso" >
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="activo" name="activo" >
                            <label for="activo" class="custom-control-label">Activo?</label>
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
            ajax : "{{ route('admin.bancos.datatable') }}",
            topMsg: "",
            footerMsg: "Generado: {{ auth()->user()->name }} {{ date("d/m/Y H:i") }}",
            filename: "Listado de Bancos",
            title: 'Listado de Bancos',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'siglas', name: 'siglas'},
                {data: 'activo', name: 'activo'},
                {data: 'cod_iso', name: 'cod_iso'},
                {data: 'nombre_iso', name: 'nombre_iso'},
                {data: 'acciones', name: 'acciones', orderable: false, searchable: false, class: 'noexport'}
            ]
        };
        toDataTable(data);
        $('.select2').select2();
    });


    $('[data-toggle="tooltip"]').tooltip();

    $('#formCrud').on('submit', function(e){
        e.preventDefault();

        if( $('#id').val()  ){
            console.log('update'); console.log( $('#id').val() );
            var ruta = "{{ route('admin.bancos.update') }}";
            var formData = new FormData($('#formCrud')[0]);
            update(formData, ruta);
        }else{
            console.log('store');
            var formData = new FormData($('#formCrud')[0]);
            var ruta = "{{ route('admin.bancos.store') }}";
            store(formData, ruta);
        }
        console.log(ruta);
    });


</script>
@stop
