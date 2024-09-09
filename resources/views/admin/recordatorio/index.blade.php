@extends('adminlte::page')


@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('content_header')
<h1>Recordatorios</h1>
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
                        <th>Servicio Primario</th>
                        <th>Mensaje</th>
                        <th>Periodo(dias)</th>
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
                    <h5 class="modal-title" id="formCrudModalTitle">RECORDATORIOS</h5>
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
                                            <label for="name" class="col-form-label">Nombre: <small>(<spanclass="text-danger">*</span>)</small></label>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col col-12">
                                        <div class="form-group">
                                            <label for="name" class="col-form-label">Mensaje: <small>(<spanclass="text-danger">*</span>)</small></label>
                                            <textarea name="mensaje" id="mensaje" cols="80" rows="5" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="desde" class="col-form-label">Servicio Principal: <small>(<spanclass="text-danger">*</span>)</small></label>
                                            <select name="articulo_id" id="articulo_id" class="form-control">
                                                @foreach ($articulos as $ar)
                                                    <option value="{{$ar->id}}">{{$ar->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="desde" class="col-form-label">Periodicidad:(dias) <small>(<spanclass="text-danger">*</span>)</small></label>
                                            <input type="number" class="form-control form-control-sm" id="perioridad" name="perioridad" required  onkeyup="this.value=this.value.replace(/[^0-9]/g,'');">
                                        </div>
                                    </div>
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
    ajax : "{{ route('admin.recordatorios.datatable') }}",
    topMsg: "",
    footerMsg: "Generado: {{ auth()->user()->name }} {{ date("d/m/Y H:i") }}",
    filename: "Listado ",
    title: 'Listado',
    columns: [
        {data: 'id', name: 'id'},
        {data: 'name', name: 'Nombre', title:'Nombre'},
        {data: 'articulo_name', name: 'Articulo', title:'Servicio Primario'},
        {data: 'mensaje', name: 'Mensaje', title:'Mensaje'},
        {data: 'perioridad', name: 'Periodo', title:'Perioridad(Dias)'},
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
            var ruta = "{{ route('admin.recordatorios.update') }}";
            var formData = new FormData($('#formCrud')[0]);
            update(formData, ruta);
        }else{
            console.log('store');
            var formData = new FormData($('#formCrud')[0]);
            var ruta = "{{ route('admin.recordatorios.store') }}";
            store(formData, ruta);
        }
        console.log(ruta);
    });
</script>
@stop



