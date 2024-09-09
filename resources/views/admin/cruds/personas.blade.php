@extends('adminlte::page')


@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('content_header')
<h1>Personas</h1>
@stop

@section('content')
<!-- Tabla -->
<div>
    <div class="card shadow mb-3 col-md-12">
        <div class="card-header">
                    Filtros
        </div>
        <div class="card-body">
                <div class="form-row mb-1">
                </div>
                <div class="form-row mb-1">
                    <div class="col-2">
                        <x-jet-label value="Tipo:" />
                    </div>
                    <div class="col-4">
                        <select name="listado" id="listado" class="form-control select2" style="width: 100%" required>
                            <option value="">Todos</option>
                            <option value="proveedor">Proveedor</option>
                            <option value="cliente">Clientes</option>
                        </select>
                    </div>
                </div>
                <div class="form-row mb-1">
                    <div class="col-8"></div>
                    <div class="col-2">
                        <div class="col-4 form-inline" id="loader_WH">
                            <div class="loader"></div>
                            <button type="button" class="btn btn-primary" onclick="getListado()" id="get_lis">Buscar</button>
                        </div>                   
                    </div>
                </div>   
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-striped" id="tablaCrud" style="width:100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Ruc</th>
                        <th>Razon Social</th>
                        <th>Nombre de Fantasia</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Cliente</th>
                        <th>Proveedor</th>
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
                    <h5 class="modal-title" id="formCrudModalTitle">Nueva Persona</h5>
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
                                <label for="name" class="col-form-label">Ruc: <small>(<span class="text-danger">*</span>)</small></label>
                                <input type="text" class="form-control form-control-sm" id="ruc" name="ruc" autofocus required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="name" class="col-form-label">Razón Social: <small>(<span class="text-danger">*</span>)</small></label>
                                <input type="text" class="form-control form-control-sm" id="name" name="name" autofocus required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="nombre_fantasia" class="col-form-label">Nombre de Fantasía:</label>
                                <input type="text" class="form-control form-control-sm" id="nombre_fantasia" name="nombre_fantasia" autofocus >
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="direccion" class="col-form-label">Dirección:</label>
                                <input type="text" class="form-control form-control-sm" id="direccion" name="direccion" autofocus >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="telefono" class="col-form-label">Teléfono:</label>
                                <input type="text" class="form-control form-control-sm" id="telefono" name="telefono" autofocus >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="direccion" class="col-form-label">Cumpleaños:</label>
                                <input type="date" class="form-control form-control-sm" id="cumple" name="cumple"  >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="email" class="col-form-label">Correo Eléctronico:</label>
                                <input type="email" class="form-control form-control-sm" id="email" name="email" autofocus >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="es_cliente" name="es_cliente" checked>
                                    <label class="form-check-label" for="es_cliente">Es Cliente?</label>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="es_proveedor" name="es_proveedor">
                                    <label class="form-check-label" for="es_proveedor">Es Proveedor?</label>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">


                    {{--  <button type="submit" class="btn btn-primary">Guardar Cambios</button>  --}}

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

        $(document).on('keypress',function(e) {
            // if(e.which == 13) {
            //    if($("#formCrudModal").data('bs.modal')?._isShown){
            //         $('#formCrud').submit();
            //         return false;
            //    }
            // }
        });

        var data = {
            table: "tablaCrud",
            ajax : "{{ route('admin.personas.datatable') }}",
            topMsg: "",
            footerMsg: "Generado: {{ auth()->user()->name }} {{ date("d/m/Y H:i") }}",
            filename: "Listado de personas",
            title: 'Listado de personas',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'ruc', name: 'ruc'},
                {data: 'name', name: 'name', title: 'Razón Social' },
                {data: 'nombre_fantasia', name: 'nombre_fantasia', title: 'Nombre Fantasía'},
                {data: 'direccion', name: 'direccion', title: 'Dirección'},
                {data: 'telefono', name: 'telefono', title: 'Teléfono'},
                {data: 'email', name: 'email', title: 'Correo'},
                {data: 'es_cliente', name: 'es_cliente', title: 'Cliente'},
                {data: 'es_proveedor', name: 'es_proveedor', title: 'Proveedor'},
                {data: 'acciones', name: 'acciones', orderable: false, searchable: false, class: 'noexport'}
            ]
        };
        toDataTable(data);
        $('.select2').select2();
    });

    function getListado() {
            var url = "{{route('admin.personas.datatable') }}" + '?tipo_base='+$('#listado').val();
            var table = $('#tablaCrud').DataTable();
            table.ajax.url(url).load();
        }
    $('[data-toggle="tooltip"]').tooltip();

    $('#formCrud').on('submit', function(e){
        console.log('pasa');
        e.preventDefault();

        if( $('#id').val()  ){
            console.log('update'); console.log( $('#id').val() );
            var ruta = "{{ route('admin.personas.update') }}";
            var formData = new FormData($('#formCrud')[0]);
            update(formData, ruta);
        }else{
            console.log('store');
            var formData = new FormData($('#formCrud')[0]);
            var ruta = "{{ route('admin.personas.store') }}";
            store(formData, ruta);
        }
        console.log(ruta);
    });


</script>
@stop
