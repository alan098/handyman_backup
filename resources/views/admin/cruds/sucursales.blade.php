@extends('adminlte::page')


@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('content_header')
<h1>Sucursales</h1>
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
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Entidad</th>
                        <th width='120px'>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!-- Tabla -->
<!-- Modal -->
<div class="modal fade" id="formCrudModal"   role="dialog" aria-labelledby="formCrudModalTitle" aria-hidden="true">
    <div class="modal-dialog agrandar" role="document">
        <form id="formCrud">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formCrudModalTitle">Nueva Sucursal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="name" class="col-form-label">Nombre: <small>(<span class="text-danger">*</span>)</small></label>
                        <input type="text" class="form-control" id="name" name="name" autofocus required>
                    </div>
                    <div class="form-group">
                        <label for="direccion" class="col-form-label">Dirección:</label>
                        <input type="text" class="form-control" id="direccion" name="direccion"  >
                    </div>
                    <div class="form-group">
                        <label for="direccion" class="col-form-label">Teléfono:</label>
                        <input type="text" class="form-control" id="telefono" name="telefono"  >
                    </div>

                    <div class="form-group">
                        <label for="entidad_id" class="col-form-label">Entidad: <small>(<span class="text-danger">*</span>)</small></label>
                        <select name="entidad_id" id="entidad_id" class="select2">
                            @foreach ($entidades as $ent)
                                <option value="{{ $ent->id }}"> {{ $ent->name }} </option>
                            @endforeach
                        </select>
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
            ajax : "{{ route('admin.sucursales.datatable') }}",
            topMsg: "",
            footerMsg: "Generado: {{ auth()->user()->name }} {{ date("d/m/Y H:i") }}",
            filename: "Listado de Sucursales",
            title: 'Listado de Sucursales',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'direccion', name: 'direccion'},
                {data: 'telefono', name: 'telefono'},
                {data: 'entidad_name', name: 'entidad'},
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
            var ruta = "{{ route('admin.sucursales.update') }}";
            var formData = new FormData($('#formCrud')[0]);
            update(formData, ruta);
        }else{
            console.log('store');
            var formData = new FormData($('#formCrud')[0]);
            var ruta = "{{ route('admin.sucursales.store') }}";
            store(formData, ruta);
        }
        console.log(ruta);
    });


</script>
@stop
