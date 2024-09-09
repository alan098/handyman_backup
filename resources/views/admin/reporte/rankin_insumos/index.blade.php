@extends('adminlte::page')

@section('title', 'Agendas')


@section('content_header')

@stop

@section('content')

    @include('admin.reporte.rankin_insumos.filtro')
    @include('admin.reporte.rankin_insumos.data')
    <br>
@stop

@section('js')
<script src=" {{ asset('js/comunes.js') }} "></script>
<script src=" {{ asset('js/logicaReporte.js') }} "></script>

<script>
$(document).ready(function() {
    $('.select3').select2({
    allowClear: true,
    placeholder: 'Seleccione un Insumo (opcional)'
});
});
var _urlmodal = "{{ route('admin.reporte.rankin.insumo.data') }}" + '?insumo=';
    var data = {
        table: "table_insumo",
        ajax : _urlmodal,
        topMsg: "",
        filename: "Listado",
        title: 'Listado',
        columns: [
            {data: 'name', name: 'fecha', title: 'Insumo',class: 'noexport dt-center'},
            {data: 'ca', name: 'servicio', title: 'Cantidad',class: 'noexport dt-center'},
            {data: 'toto', name: 'colaborador', title: 'Gastado',class: 'noexport dt-center'},
            {data: 'costo', name: 'colaborador', title: 'Costo (Por Paquetes /Unitario)',class: 'noexport dt-center'},

        ]
    };
    DataTabletwo(data)
    function DataTabletwo(data) {
    $('#' + data.table).DataTable({
        order: [[1, "desc"]],
        responsive: true,
        autoWidth: false,
        ajax: data.ajax,
        columns: data.columns,
        language: espanis_data,
        dom: 'Bfrtip',
        buttons: getButtons(data),
        initComplete: function () {
        },
        drawCallback: function( settings ) {
            $('[data-toggle="tooltip"]').tooltip();
            // $('search').focus();
            // $('#example_filter label input').focus();
            $('#tablaCrud_filter label input').on('keydown',function(e) {
                console.log( 'entra => ' + e.which );
                if ( (e.which == 78)) {
                    $('#formCrudModal').modal('show');
                }
            });

        }
    });
    }

function callback(){
        $('.loader').hide()
}   
function historial(){
    $('.loader').show()
        var _url = "{{ route('admin.reporte.rankin.insumo.data') }}" + '?insumo='+$('#insumo').val()+'&desde='+$('#desde').val()+'&hasta='+$('#hasta').val();
        console.log(_url)
        var table = $('#table_insumo').DataTable();
        table.ajax.url(_url).load(callback);
    
}


    function getFormatGS(num)
    {
            if(!isNaN(num)){
                num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
                num = num.split('').reverse().join('').replace(/^[\.]/,'');
                return num;
            }
            return 0;
    }
    </script>
@stop
