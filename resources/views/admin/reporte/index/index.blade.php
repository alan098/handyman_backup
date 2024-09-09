@extends('adminlte::page')

@section('title', 'Agendas')


@section('content_header')

@stop

@section('content')

 @include('admin.reporte.index.filtro')
 {{-- @include('admin.reporte.index.detalles')
 @include('admin.reporte.index.data') --}}
<br>
@stop
@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">

@stop

@section('js')
<script src=" {{ asset('js/comunes.js') }} "></script>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/locales-all.js"></script>

<script>  
$( document ).ready(function() {
    ($(".fas fa-bars ")).click();
    $('.select2').select2().trigger('change');
    // getListado();
});
//constantes generales
//seccion resumen 
function format ( d ) {
    var html = '<table class="display" style="width:100%">';
    html += '<thead><tr><th>&nbsp;</th><th>Articulo</th><th>Cantidad</th><th>Precio</th><th>Costo</th><th>Iva</th>';
    html += '<th>Precio Unitaro</th><th>Importe</th></tr>';
    html += '</thead>';
    html += '<tbody>';
    d.detalles.forEach(function(valor, indice, array){
    html += '<tr>';
        html += '<td>&nbsp;</td>';
        html += '<td>'+valor.name+'</td>';
        html += '<td>'+valor.cantidad+'</td>';
        html += '<td>'+valor.precio+'</td>';
        html += '<td>'+valor.costo+'</td>';
        html += '<td>'+valor.iva+'</td>';
        html += '<td class="dt-right">'+valor.precio_unitario+'</td>';
        html += '<td class="dt-right">'+valor.importe+'</td>';
    html += '</tr>';

    });
    html += '</tbody>';
    html += '</table>';
    return html;
}     
var table;   
function getListado(){
    $('#esperando').show()
        if ( $.fn.dataTable.isDataTable( '#tablaListado' ) ) { 
            $('#tablaListado').DataTable().destroy();
            $('div').each(function(){
                if( $(this).hasClass('DataTables_sort_wrapper') ){
                    $(this).remove();
                }
            });
            $('#tablaListado tbody').unbind('click');
            }
            var childRows = null;
            table = $('#tablaListado').DataTable({
            responsive: false,
            autoWidth: false,
            dom: 'Bfrtip',
            'ajax': {
                url: "{{ route('admin.listado.data') }}",
                    data : function(d){
                        d.cliente= $('#cliente_id').val();
                        d.desde= $('#fecha_desde').val();
                        d.hasta= $('#fecha_hasta').val();
                        d.estado= $('#estados').val();
                        d.sucursal= $('#sucursales').val();
                        d.entidad= $('#sucursales').val();
                    },
            },
            "language": {
                "decimal": ",",
                "thousands": "."
            },
            "columns": [
                { "data": "id", "title":"Venta", "className": 'details-control' },
                { "data": "fecha", "title":"Fecha", "className": 'details-control' },
                { "data": "start", "title":"Hora Inicio", "className": 'dt-center' },
                { "data": "end", "title":"Hora Fin", "className": 'details-control' },
                { "data": "cliente", "title":"Cliente", "className":"dt-right details-control" },
                { "data": "numero_factura", "title":"Nro Factura", "className": 'details-control' },
                { "data": "estado", "title":"Estado", "className": 'details-control' },
                { "data": "total", "title":"Total de la Cta", "className":"dt-right details-control" },
                { "data": "cobrado", "title":"Total Cobrado", "className":"dt-right details-control" },
                { "data": "descuentos", "title":"Descuento", "className":"dt-right details-control" },
                { "data": "ancticipo", "title":"Anticipo", "className":"dt-right details-control" },
                { "data": "gift", "title":"Giftcard", "className":"dt-right details-control" },
                { "data": "acciones", "title":"Acciones", "className":"dt-right details-control" },
            ],
            "initComplete": function () {
                childRows = table.rows($('.shown'));
                $('#esperando').hide()
            },
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;
        
                // converting to interger to find total
                var intValEntero = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$.]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };
                var intValDecimal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '.')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };
                // computing column Total of the complete result
                var comTotal = api //total de la cuenta
                    .column( 8 )
                    .data()
                    .reduce( function (a, b) {
                        return intValDecimal(a) + intValDecimal(b);
                    }, 0 );
                var bruTotal = api //total cobrado
                    .column( 9 )
                    .data()
                    .reduce( function (a, b) {
                        return intValDecimal(a) + intValDecimal(b);
                    }, 0 );
                    var desTotal = api //descuento
                        .column( 10 )
                        .data()
                        .reduce( function (a, b) {
                            return intValEntero(a) + intValEntero(b);
                        }, 0 );
        
                    var monTotal = api //anticipo
                        .column( 11 )
                        .data()
                        .reduce( function (a, b) {
                            return intValEntero(a) + intValEntero(b);
                        }, 0 );
                    var montgif = api //gitf card
                    .column( 12 )
                    .data()
                    .reduce( function (a, b) {
                        return intValEntero(a) + intValEntero(b);
                    }, 0 );
                    $('#total_cuenta').html(comTotal);
                    $("#total_cobrado").html(bruTotal);
                    $("#total_descuento").html(parseInt(desTotal));
                    $("#total_facturado").html(monTotal);
                    $("#total_cerrados").html(bruTotal);
                    $("#total_pendientes").html(comTotal);
                    $( api.column( 7 ).footer() ).html('Total');
                    $( api.column( 8 ).footer() ).html(  comTotal  );
                    $( api.column( 9 ).footer() ).html( getFormatGS( bruTotal ) );
                    $( api.column( 10 ).footer() ).html( getFormatGS( desTotal ) );
                    $( api.column( 11 ).footer() ).html( getFormatGS( monTotal ) );
            },
            });
        
    var isMobile = false; //initiate as false
    // device detection
    if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
        || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) {
        isMobile = true;
    }
    if(!isMobile){
        $('#tablaListado tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );
            if ( row.child.isShown() ) {
                row.child.hide();
                tr.removeClass('shown');
            }else {
                row.child( format(row.data()) ).show();
                tr.addClass('shown');
            }
        } );
    } 
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
{{-- <script src=" {{ asset('js/logicaCuentas.js') }} "></script> --}}


@stop