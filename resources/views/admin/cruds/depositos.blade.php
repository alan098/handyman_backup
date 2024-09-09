@extends('adminlte::page')


@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('content_header')
<h1>Depositos</h1>
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
<div class="modal fade" id="formCrudModal"  role="dialog" aria-labelledby="formCrudModalTitle"
    aria-hidden="true">
    <div class="modal-dialog agrandar" role="document">
        <form id="formCrud">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formCrudModalTitle">Nuevo Deposito</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="name" class="col-form-label">Nombre: <small>(<span
                                    class="text-danger">*</span>)</small></label>
                        <input type="text" class="form-control" id="name" name="name" autofocus required>
                    </div>
                    <div class="form-group">
                        <label for="entidad_id" class="col-form-label">Entidad: <small>(<span
                                    class="text-danger">*</span>)</small></label>
                        <select name="entidad_id" id="entidad_id" class="select2">
                            @foreach ($entidades as $ent)
                            <option value="{{ $ent->id }}"> {{ $ent->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sucursal_id" class="col-form-label">Sucursal: <small>(<span
                                    class="text-danger">*</span>)</small></label>
                        <select name="sucursal_id" id="sucursal_id" class="select2">
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
            ajax : "{{ route('admin.depositos.datatable') }}",
            topMsg: "",
            footerMsg: "Generado: {{ auth()->user()->name }} {{ date("d/m/Y H:i") }}",
            filename: "Listado de Sucursales",
            title: 'Listado de Sucursales',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'entidad_name', name: 'entidad'},
                {data: 'sucursal_name', name: 'sucursal'},
                {data: 'acciones', name: 'acciones', orderable: false, searchable: false, class: 'noexport'}
            ]
        };
        toDataTable(data);

        @php
            echo ' var entidades = '.json_encode($entidades).'; ';
            echo ' var sucursales = '.json_encode($sucursales).'; ';
        @endphp


        rellenarSucursales();

        $('#entidad_id').on('change', () => rellenarSucursales() );

        function rellenarSucursales() {

            console.log('rellenarDefecto');
            console.log(sucursales);

            var entidad_id = $('#entidad_id').val();
            console.log( 'entidad_id => ' + entidad_id);
            $('#sucursal_id option').remove().promise().done(function(){
                $.each(sucursales, function(i, item) {
                    console.log('recorriendo');
                    console.log(entidad_id+', '+item.entidad_id);
                    if (entidad_id == item.entidad_id) {
                        console.log(entidad_id +' == '+ item.entidad_id);
                        if (sucursal_id == item.id) {
                            $("#sucursal_id").append("<option value="+item.id+" selected>"+item.name+"</option>");
                        }else{
                            $("#sucursal_id").append("<option value="+item.id+">"+item.name+"</option>");
                        }
                    }

                });
            });
        }



    });


    $('.select2').select2();


    $('[data-toggle="tooltip"]').tooltip();

    $('#formCrud').on('submit', function(e){
        e.preventDefault();

        if( $('#id').val()  ){
            console.log('update'); console.log( $('#id').val() );
            var ruta = "{{ route('admin.depositos.update') }}";
            var formData = new FormData($('#formCrud')[0]);
            update(formData, ruta);
        }else{
            console.log('store');
            var formData = new FormData($('#formCrud')[0]);
            var ruta = "{{ route('admin.depositos.store') }}";
            store(formData, ruta);
        }
        console.log(ruta);
    });


</script>
@stop
