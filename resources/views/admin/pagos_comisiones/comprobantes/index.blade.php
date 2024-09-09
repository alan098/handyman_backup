@extends('adminlte::page')
@section('title', 'Comisiones')
@section('content_header')
@stop
@section('content')
<div>
    <div class="card">
        <div class="card-header">
                <div class="form-row mb-1">
                    <div class="col-sm-1" style="display: none; float: right;" id="esperando">
                        <div class="loader" ></div>
                    </div>
                </div>
                <div class="form-row mb-1">
                    <div class="col-2">
                        <x-jet-label value="Colaborador:" />
                    </div>
                    <div class="col-4">
                        <select name="colaborador_id" id="colaborador_id" class="form-control select2" style="width: 100%" required>
                            <option value="">Ingrese el Nombre</option>
                                @foreach ($colaboradores as $cli)
                                <option value="{{ $cli->id }}">{{ $cli->ruc }}-{{
                                    $cli->name }}</option>
                                @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row mb-1">
                    <div class="col-2">
                        <x-jet-label value="Fecha Desde:"  />
                    </div>
                    <div class="col-3">
                        <input autocomplete="off" type="text" class="form-control form-control-sm datepicker" id="desde" value="{{date("Y-m-d")}}" name="desde" >
                    </div>
                    <div class="col-2">
                        <x-jet-label value="Fecha Hasta:"/>
                    </div>
                    <div class="col-3">
                        <input autocomplete="off" type="text" class="form-control form-control-sm datepicker" id="hasta" value="{{date("Y-m-d")}}" name="hasta" >
                    </div>
                </div>
                <div class="form-row mb-1 mt-5">
                    <div class="col-8"></div>
                    <div class="col-2">
                        <button type="button" class="btn btn-primary" onclick="filtrar()" >Buscar</button>
                    </div>
                </div>
                
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover" id="tablaCrud" style="width:100%">
                <thead>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop
@section('js')
<script src=" {{ asset('js/comunes.js') }} "></script>
<script>
$( document ).ready(function() {
var _url = "{{ route('admin.pagos.comprobante.data') }}" + '?colaborador='+$('#colaborador_id').val()+'&desde='+$('#desde').val()+'&hasta='+$('#hasta').val();
var data = {
    table: "tablaCrud",
    ajax : _url,
    topMsg: "",
    filename: "Listado de Compras sin Detalle",
    title: 'Listado de Compras sin Detalle',
    columns: [
        {data: 'name', name: 'Nombre', title: 'Nombre',class: 'noexport dt-center'},
        {data: 'fecha', name: 'fecha', title: 'Fecha',class: 'noexport dt-center'},
        {data: 'user_name', name: 'name', title: 'Colaborador',class: 'noexport dt-center'},
        {data: 'importe', name: 'importe', title: 'Importe',class: 'noexport dt-center'},
        // {data: 'medio_name', name: 'pago', title: 'Metodo de pago',class: 'noexport dt-center'},
        {data: 'acciones', name: 'acciones',title:"Acciones", orderable: false, searchable: false, class: 'noexport dt-center'}
    ]
};
toDataTable(data);
});
function filtrar(){
console.log('filtrando');
var _newUrl = "{{ route('admin.pagos.comprobante.data') }}" + '?colaborador='+$('#proveedor').val()+'&desde='+$('#desde').val()+'&hasta='+$('#hasta').val();
var table = $('#tablaCrud').DataTable();
table.ajax.url(_newUrl).load();
}

function eliminar(ruta){
    console.log(ruta);
    const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger'
    },
    buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
    title: 'No podras revertir esta accion!',
    text: "Estas seguro de eliminar el comprobante de pago?",
    html: "",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Si, borrarlo ya!',
    cancelButtonText: 'No, Cancelar!',
    reverseButtons: true
    }).then((result) => {
    if (result.isConfirmed) {
        getData(ruta).then(function(rta){
            alertaTipo('Eliminado con exito','success')
            filtrar()
        }).catch(function(error){
            console.log('populate dio error'); console.log(error);
            Swal.fire('Ocurrio un Error', error.message, 'error');
        });
     }
    });

}
function alertaTipo(messa,tipo){
    toastr.options = { 
        "closeButton": true,
        "positionClass": "toast-top-right",
        "showDuration": "1500",
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "preventDuplicates": false,
        "onclick": null,
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    if (tipo == "error") {
        toastr.error('',messa);
    }else if (tipo == "warning") {
        toastr.warning('',messa);
    }else if (tipo == "info") {
        toastr.info('',messa);
    }else if(tipo == 'success'){
        toastr.success('',messa);
    }
}
</script>
@stop
