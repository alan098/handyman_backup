@extends('adminlte::page')

@section('title', 'Agendas')


@section('content_header')

@stop

@section('content')
@if (session('status'))
<div class="alert alert-success">
    {{ session('status') }}
</div>
@endif

 @include('admin.transferencias.list.filtro')
 @include('admin.transferencias.list.data')
<br>
@stop
@section('js')
<script src=" {{ asset('js/comunes.js') }} "></script>
<script>  
$( document ).ready(function() {
    // $('.select2').select2().trigger('change');
    $(document).on("change", function(){
        console.log("buscando...")
        buscar();
    })
        var urlcomision= "{{ route('admin.transfer.datatable') }}";
        var datacomi = {
            table: "tablaListado",
            ajax : urlcomision,
            topMsg: "",
            filename: "Listado",
            title: 'Listado',
            columns: [
                {data:'name_en_pro', name:'name_en_pro',title:'Entidad Procedente',class: 'noexport dt-center'},
                {data:'name_su_pro', name:'name_su_pro',title:'Sucursal Procedente',class: 'noexport dt-center'},
                {data:'name_de_pro', name:'name_de_pro',title:'Deposito Procedente',class: 'noexport dt-center'},
                {data:'name_en_de', name:'name_en_de',title:'Entidad Destino',class: 'noexport dt-center'},
                {data:'name_su_de', name:'name_su_de',title:'Sucursal Destino',class: 'noexport dt-center'},
                {data:'name_de_de', name:'name_de_de',title:'Deposito Destino',class: 'noexport dt-center'},
                {data:'acciones', name:'acciones',title:'Acciones',class: 'noexport dt-center'},
            ],
            // columnDefs: [
            // {
            // targets: [1,2],
            //     render: $.fn.dataTable.render.number(',', '.', '')
            // }
            // ],
            drawCallback:function( settings ) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        };
        
        //sucursales
        SimpleDataTable(datacomi);
        function SimpleDataTable(data) {
            jQuery.fn.dataTable.Api.register( 'sum()', function ( ) {
                return this.flatten().reduce( function ( a, b ) {
                    if ( typeof a === 'string' ) {
                        a = a.replace(/[^\d.-]/g, '') * 1;
                    }
                    if ( typeof b === 'string' ) {
                        b = b.replace(/[^\d.-]/g, '') * 1;
                    }
                    return a + b;
                }, 0 );
            } );
              var tablebase=  $('#' + data.table).DataTable({
                order: [[0, "desc"]],
                // pageLength: 20,
                autoWidth: true,
                paging: true,
                ajax: data.ajax,
                columns: data.columns,
                language: espanis_data,
                searching: false,
                dom: 'Bfrtip',
                columnDefs:data.columnDefs,
                "lengthMenu": [ [10, 25, 100, -1], [10, 25, 100, "Todos"] ],
                buttons: [{
                    extend: 'pageLength',
                }  
                ],
                drawCallback: data.drawCallback,
                
            });
            return tablebase
        }

        
});
function eliminar(ruta){
    const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger'
    },
    buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
    title: 'No podras revertir esta accion!',
    text: "Estas seguro de eliminar la Transferencias?",
    html: "",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Si, borrarlo ya!',
    cancelButtonText: 'No, Cancelar!',
    reverseButtons: true
    }).then((result) => {
    if (result.isConfirmed) {
        var formData = new FormData();
        formData.append( '_token', '{{ csrf_token() }}');
        postData(ruta, formData).then(function(rta){
            alertaTipo('Exito al Eliminar','success')
            buscar();
        }).catch(function(error){
            console.log('postData dio error'); 
            cargando('hide','50px','#btn-guardar');
            Swal.fire('Hola esta es una alerta', error.msg, 'warning');
        })  
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
function buscar(){
    var _url = "{{ route('admin.transfer.datatable') }}" + '?filtro='+$('#filtro').val()+'&desde='+$('#fecha_desde').val()+'&hasta='+$('#fecha_hasta').val();
    var table = $('#tablaListado').DataTable();
    table.ajax.url(_url).load();
}
//constantes generales


</script>


@stop