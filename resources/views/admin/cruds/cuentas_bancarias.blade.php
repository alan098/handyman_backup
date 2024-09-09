@extends('adminlte::page')


@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('content_header')
<h1>Cuentas Bancarias</h1>
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
                        <th>Entidad</th>
                        <th>Banco</th>
                        <th>Numero de Cuenta</th>
                        <th>Tipo de Cuenta</th>
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
                    <h5 class="modal-title" id="formCrudModalTitle">Nueva Cuenta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <div class="alert alert-danger" role="alert" id="alertError" style="display: none"></div>
                        <div class="alert alert-info" role="alert" id="alertInfo" style="display: none"></div>
                    </div>
                    <div class="form-group">
                        <label for="" class="mb-1">Numero de Cuenta</label>
                        <input type="text" class="form-control"  name="name" id="name" required>
                    </div>
                    <div class="form-group ">
                        <label for="" class="mb-1">Banco</label> <br>
                        <select name="banco_id" id="banco_id" class="form-control" style="width: 100%" required>
                            <option value="" selected disabled>Seleccione El Banco</option>
                             @foreach($bancos as $l)
                                <option value="{{ $l->id }}">{{ $l->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="mb-1">Tipo de Cuenta</label><br>
                        <select name="tipo" id="tipo" class="form-control" style="width: 100%" required>
                            <option value="" selected disabled>Seleccione el tipo </option>
                            <option value="ahorro" >Caja de Ahorro</option>
                            <option value="ctacte" >Cuenta Corriente</option>  
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="mb-1">Entidad</label><br>
                        <select name="entidad_id" id="entidad_id" class="form-control" style="width: 100%" required>
                             @foreach($entidades as $l)
                                <option value="{{ $l->id }}">{{ $l->name }}</option>
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
            ajax : "{{ route('admin.cuentas_bancarias.datatable') }}",
            topMsg: "",
            footerMsg: "Generado: {{ auth()->user()->name }} {{ date("d/m/Y H:i") }}",
            filename: "Listado de Bancos",
            title: 'Listado de Bancos',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'entidad_name', name: 'entidad_name'},
                {data: 'banco_name', name: 'banco_name'},
                {data: 'name', name: 'name'},
                {data: 'tipo', name: 'tipo'},
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
            var ruta = "{{ route('admin.cuentas_bancarias.update') }}";
            var formData = new FormData($('#formCrud')[0]);
            update(formData, ruta);
        }else{
            console.log('store');
            var formData = new FormData($('#formCrud')[0]);
            var ruta = "{{ route('admin.cuentas_bancarias.store') }}";
            store(formData, ruta);
        }
        console.log(ruta);
    });


</script>
@stop
