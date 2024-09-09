@extends('adminlte::page')

@section('title', 'Agendas')


@section('content_header')

@stop

@section('content')

    @include('admin.reporte.ranking_profesionales.filtro')
    @include('admin.reporte.ranking_profesionales.data')
    <br>
@stop

@section('js')
<script src=" {{ asset('js/comunes.js') }} "></script>
<script src=" {{ asset('js/logicaReporte.js') }} "></script>

<script>
$(document).ready(function() {
    // grafic();  
    $('.js-data-clientes-ajax').select2({
    minimumInputLength: 2,
    minimumResultsForSearch: 10,
    placeholder: "Seleccion un cliente para ver su historial",
    allowClear: true,
    ajax: {
        url: '{{route("admin.lista_reserva.clientes")}}',
        dataType: "json",
        type: "GET",
        data: function (params) {
            var queryParameters = {
                term: params.term
            }
            return queryParameters;
        },
        processResults: function (data) {
            return {
                results: $.map(data, function (item) {
                    return {
                        text: item.text,
                        id: item.id
                    }
                })
            };
        }
    }
});
});

var _urlmodal = "{{ route('admin.reporte.rankingprofesionales.data') }}" + '?col_id=';
    var data = {
        table: "tablaListadoHistorial",
        ajax : _urlmodal,
        topMsg: "",
        filename: "Listado",
        title: 'Listado',
        columns: [
            {data: 'name', name: 'c', title: 'Nombre',class: 'noexport dt-center'},
            {data: 'facturado', name: 'c', title: 'Monto Facturado',class: 'noexport dt-center'},
            {data: 'comisionado', name: 'c', title: 'Monto Comisionado',class: 'noexport dt-center'},
            {data: 'atendidos', name: 'c', title: 'Atendidos',class: 'noexport dt-center'},
            {data: 'repetidos', name: 'c', title: 'Repetidos',class: 'noexport dt-center'},

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
            // console.log( '#'+data.table+'_filter label input' );
            // console.log( $('#'+data.table+'_filter label input') );
            // $('#'+data.table+'_filter label input').focus();
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
        var _url = "{{ route('admin.reporte.rankingprofesionales.data') }}" + '?col_id='+$('#colaborador').val()+'&desde='+$('#desde').val()+'&hasta='+$('#hasta').val();
        console.log(_url)
        var table = $('#tablaListadoHistorial').DataTable();
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
