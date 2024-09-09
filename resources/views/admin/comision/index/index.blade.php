@extends('adminlte::page')

@section('title', 'Agendas')


@section('content_header')

@stop

@section('content')

 @include('admin.comision.index.filtro')
 @include('admin.comision.index.resumen')
 @include('admin.comision.index.data')
<br>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">

@stop

@section('js')
<script src=" {{ asset('js/comunes.js') }} "></script>

<script>  
$( document ).ready(function() {
    ($(".fas fa-bars ")).click();
    $('.select2').select2().trigger('change');
    getListado();
    $(document).on("change", function(){
        console.log("getListado")
        getListado();
    })
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
        // html += '<td>'+valor.colaborador_id+'</td>';
        // html += '<td>'+valor.colaborador+'</td>';
        // html += '<td>'+valor.articulo+'</td>';
        // html += '<td>'+valor.cantidad+'</td>';
        // html += '<td>'+valor.total+'</td>';
        // html += '<td class="dt-right">'+valor.porcentaje+'</td>';
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
            var tipo=null
            var comision='fija'
            if ($('#cobrado').prop('checked')) {
                comision='cobrado';
            }
            if($('#exampleRadios2').prop('checked')){
                tipo="producto";
            }else if($('#exampleRadios3').prop('checked')){
                tipo="servicio";
            }
            var agrupacion=null;
            if($('#example2').prop('checked')){
                agrupacion="afiliado";
            }else if($('#example3').prop('checked')){
                agrupacion="colaborador";
            }
            console.log(agrupacion);
            table = $('#tablaListado').DataTable({
            responsive: false,
            autoWidth: false,
            dom: 'Bfrtip',
            'ajax': {
                url: "{{ route('admin.comisiones.data') }}",
                    data : function(d){
                        d.colaborador= $('#colaborador_id').val();
                        d.desde= $('#fecha_desde').val();
                        d.hasta= $('#fecha_hasta').val();
                        d.tipo= tipo;
                        d.comision= comision;
                        d.agrupacion= agrupacion;
                    },
            },
            "language": {
                "decimal": ",",
                "thousands": "."
            },
            "columns": [
                { "data": "colaborador_id", "title":"Identificador", "className": 'details-control' },
                { "data": "colaborador", "title":"Colaborador", "className": 'dt-center' },
                { "data": "articulo", "title":"Servicio", "className": 'details-control' },
                { "data": "cantidad", "title":"Cantidad", "className": 'dt-center' },
                { "data": "total", "title":"Total", "className":"dt-right details-control" },
                { "data": "porcentaje", "title":"Comision", "className": 'dt-center' },
            ],
            pageLength: 50,
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
                var comTotal = api //total de la comision
                    .column( 4 )
                    .data()
                    .reduce( function (a, b) {
                        return intValDecimal(a) + intValDecimal(b);
                    }, 0 );
                var bruTotal = api //total cobrado
                    .column( 5 )
                    .data()
                    .reduce( function (a, b) {
                        return intValDecimal(a) + intValDecimal(b);
                    }, 0 );
        
                    $( api.column( 3 ).footer() ).html('Total');
                    $( api.column( 4 ).footer() ).html(  puntearNum(comTotal)  );
                    $( api.column( 5 ).footer() ).html(  puntearNum(bruTotal)  );
                    $("#importe_servi").html(  puntearNum(comTotal)  );
                    $("#comision_servi").html(  puntearNum(bruTotal)  );
                    if(comTotal > 0){
                        $('#descargar').prop('disabled',false)
                    }else{
                        $('#descargar').prop('disabled',true)
                    }
                    
                    
                    // $( api.column( 7 ).footer() ).html( getFormatGS( desTotal ) );
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
                // row.child.hide();
                // tr.removeClass('shown');
            }else {
                // row.child( format(row.data()) ).show();
                // tr.addClass('shown');
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
    function ver(){
        var comision='fija'
        if ($('#cobrado').prop('checked')){
            comision='cobrado';
        }
        var agrupacion=null;
            if($('#example2').prop('checked')){
                agrupacion="afiliado";
            }else if($('#example3').prop('checked')){
                agrupacion="colaborador";
            }
        if(reglas()){
            var ventana;
            var url = "{{ route('admin.comiciones.pdf') }}" + '?colaborador_id='+$('#colaborador_id').val()+'&desde='+$('#fecha_desde').val()+'&hasta='+$('#fecha_hasta').val()+'&comision='+comision+'&agrupacion='+agrupacion;
            ventana = window.open(url , '_');
        }
    }
function reglas(){
if (($('#colaborador_id').val() == '')){
    toadErrores('Necesita seleccionar un colaborador')
    return false;
}else if(!$('#fecha_desde').val()){
    toadErrores('Necesita seleccionar un rango de fecha')
    return false;
}else if(!($('#fecha_hasta').val() )){
    toadErrores('Necesita seleccionar un rango de fecha')
    return false;
}else{
    return true
}
}

</script>


@stop