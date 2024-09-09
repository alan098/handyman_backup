@extends('adminlte::page')


@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<style>
    .redondo {
        display: block;
        width: 30px;
        height: 30px;
        border-radius: 50%;
    }
</style>
@stop

@section('content_header')
<h1>Descuentos</h1>
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
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Activo</th>
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
                    <h5 class="modal-title" id="formCrudModalTitle">Nuevo Servicio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="name" class="col-form-label">Nombre: <small>(<span class="text-danger">*</span>)</small></label>
                                <input type="text" class="form-control form-control-sm" id="name" name="name" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="descripcion" class="col-form-label">Descripcion:<small>(<span class="text-danger">*</span>)</small></label>
                                <input type="text" class="form-control form-control-sm" id="descripcion" name="descripcion" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="activo" name="activo" checked>
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
            ajax : "{{ route('admin.descuentos.datatable') }}",
            topMsg: "",
            footerMsg: "Generado: {{ auth()->user()->name }} {{ date("d/m/Y H:i") }}",
            filename: "Listado de Descuentos",
            title: 'Listado de Descuentos',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'descripcion', name: 'descripcion', title: 'Descripcion', className : "text-right"},
                {data: 'es_activo', name: 'es_activo'},
                {data: 'acciones', name: 'acciones', orderable: false, searchable: false, class: 'noexport'}
            ]
        };
        toDataTable(data);
    });
    
    $('[data-toggle="tooltip"]').tooltip();

    $('#formCrud').on('submit', function(e){
        e.preventDefault();
        if( $('#id').val()  ){
            console.log('update'); console.log( $('#id').val() );
            var ruta = "{{ route('admin.descuentos.update') }}";
            var formData = new FormData($('#formCrud')[0]);
            update(formData, ruta);
        }else{
            console.log('store');
            var formData = new FormData($('#formCrud')[0]);
            var ruta = "{{ route('admin.descuentos.store') }}";
            store(formData, ruta);
        }
        console.log(ruta);
    });


</script>
@stop