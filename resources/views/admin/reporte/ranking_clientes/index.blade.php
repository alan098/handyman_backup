@extends('adminlte::page')

@section('title', 'Agendas')


@section('content_header')

@stop

@section('content')

    @include('admin.reporte.ranking_clientes.filtro')
    @include('admin.reporte.ranking_clientes.data')
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
    placeholder: "El Cliente es Opcional",
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
var _urlmodal = "{{ route('admin.reporte.ranking.clientes.data') }}";
    var data = {
        table: "table_data",
        ajax : _urlmodal,
        topMsg: "",
        filename: "Listado",
        title: 'Listado',
        columns: [
            {data: 'name', name: 'fecha', title: 'Nombre',class: 'noexport dt-center'},
            {data: 'cd', name: 'servicio', title: 'Cantidad de Visitas',class: 'noexport dt-center'},
            {data: 'importe', name: 'colaborador', title: 'Monto Sin Descuento',class: 'noexport dt-center'},
            {data: 'total', name: 'colaborador', title: 'Monto Gastado',class: 'noexport dt-center'},
            {data: 'descuento', name: 'colaborador', title: 'Descuentos dados',class: 'noexport dt-center'},
        ]
    };
    toDataTablefa(data)
 

    function callback(){
        $('.loader').hide()
    }
          
    function filtrar(){
        $('.loader').show()
        var data='&mayor_m='+$('#mayor_a_m').val()+'&menor_m='+$('#menor_que_m').val()+'&mayor_v='+$('#mayor_a_v').val()+'&menor_v='+$('#menor_que_v').val();
        var _url = "{{ route('admin.reporte.ranking.clientes.data') }}" + '?cliente_id='+$('#cliente_id').val()+'&desde='+$('#desde').val()+'&hasta='+$('#hasta').val()+data;
        var table = $('#table_data').DataTable();
        table.ajax.url(_url).load(callback);
    }
    function toDataTablefa(data) {
    $('#' + data.table).DataTable({
        order: [[1, "desc"]],
        aLengthMenu: [
            [25, 50, 100, -1],
            [25, 50, 100, "Todos"]
        ],
        responsive: true,
        autoWidth: false,
        ajax: data.ajax,
        columns: data.columns,
        language: espanis_data,
        dom: 'Bfrtip',
        buttons: getButtons(data),
        drawCallback: function( settings ) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
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
