@extends('adminlte::page')


@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('content_header')
<h1>Dias Libres</h1>
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
                        <th>Colaborador</th>
                        <th>Hora Inicio</th>
                        <th>Hora Fin</th>
                        <th>Dias</th>
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
<div class="modal fade" id="formCrudModal"   role="dialog" aria-labelledby="formCrudModalTitle"
    aria-hidden="true">
    <div class="modal-dialog agrandar" role="document">
        <form id="formCrud">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formCrudModalTitle">ASIGNAR DIAS LIBRES</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <div class="container">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-datos" role="tabpanel"
                                aria-labelledby="pills-datos-tab">
                                <div class="row">
                                    <div class="col col-12">
                                        <div class="form-group">
                                            <label for="name" class="col-form-label">Colaborador: <small>(<spanclass="text-danger">*</span>)</small></label>
                                            <select name="user_id" id="user_id" class="form-control">
                                                @foreach ($colaborador as $col)
                                                <option value="{{$col->id}}">{{$col->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    @foreach ($entidades as $ent)
                                            <div class="col col-12">
                                                <div class="form-group">
                                                    <label for="name" class="col-form-label">Sucursal: <small>(<spanclass="text-danger">*</span>)</small></label>
                                                    <select name="sucursal_id" id="sucursal_id" class="form-control">
                                                        @foreach ($sucursales as $col)
                                                        <option value="{{$col->id}}">{{$col->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="desde" class="col-form-label">Desde:</label>
                                            <input autocomplete="off" type="time" class="form-control form-control-sm" id="hora_inicio"
                                                name="hora_inicio" >
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="hasta" class="col-form-label">Hasta:</label>
                                            <input autocomplete="off" type="time" class="form-control form-control-sm" id="hora_fin"
                                                name="hora_fin" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    @foreach ($dias as $key => $val)
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input dias" type="checkbox" value="" name="dias['{{ $key }}']" id="{{ $key }}" checked>
                                                <label class="form-check-label" for="{{ $key }}">
                                                  {{ ucwords($key) }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
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

            
$('.datepicker_eclusivo').datepicker({
                language:'es',
                dateFormat: "yy-mm-dd",
});
var data = {
    table: "tablaCrud",
    ajax : "{{ route('admin.diaslibres.datatable') }}",
    topMsg: "",
    footerMsg: "Generado: {{ auth()->user()->name }} {{ date("d/m/Y H:i") }}",
    filename: "Listado ",
    title: 'Listado',
    columns: [
        {data: 'id', name: 'id'},
        {data: 'users_name', name: 'Usuario', title:'Colaborador'},
        {data: 'hora_inicio', name: 'Inicio', title:'Desde'},
        {data: 'hora_fin', name: 'Final', title:'Hasta'},
        {data: 'diasP', name: 'diasP', title:'Dias'},
        {data: 'sucursal_name', name: 'Sucursales', title:'Sucursales'},
        {data: 'acciones', name: 'acciones', orderable: false, searchable: false, class: 'noexport'}
    ]
};
toDataTable(data);
});

function rellenar(ruta){
    getData(ruta).then(function(rta){
        populateForm('formCrud', JSON.parse(rta));
        $('#formCrudModal').modal('show');
    }).catch(function(error){
        console.log('populate dio error'); console.log(error);
        Swal.fire('Ocurrio un Error', error.message, 'error');
    });
}

$('[data-toggle="tooltip"]').tooltip();
    $('#formCrud').on('submit', function(e){
        e.preventDefault();
        if( $('#id').val()  ){
            console.log('update'); console.log( $('#id').val() );
            var ruta = "{{ route('admin.diaslibres.update') }}";
            var formData = new FormData($('#formCrud')[0]);
            update(formData, ruta);
        }else{
            console.log('store');
            var formData = new FormData($('#formCrud')[0]);
            var ruta = "{{ route('admin.diaslibres.store') }}";
            store(formData, ruta);
        }
        console.log(ruta);
    });
</script>
@stop



