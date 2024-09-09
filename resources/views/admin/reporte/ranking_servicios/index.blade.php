@extends('adminlte::page')

@section('title', 'Agendas')


@section('content_header')

@stop

@section('content')

    @include('admin.reporte.ranking_servicios.filtro')
    @include('admin.reporte.ranking_servicios.data')
    <br>
@stop

@section('js')
<script src=" {{ asset('js/comunes.js') }} "></script>
<script src=" {{ asset('js/logicaReporte.js') }} "></script>

<script>
$(document).ready(function() {
    grafic();  
});

function grafic(){
    $('.loader').show()
    var datos='?sucursal='+$('#sucursales').val()+'&desde='+$('#desde').val()+'&hasta='+$('#hasta').val();
    var per="{{route('admin.reporte.ranking.servicios.data')}}"+datos
        getData(per).then(function(rta){
            $('.loader').hide()
            var _labelservices = [];
            var _dataTotal = [];
            var _dataCantidad = [];
            var _dataCantidadName = [];
            $.each(rta.rankin, function(i, item) {
                _labelservices.push(item.name);
                _dataTotal.push(item.total);
                _dataCantidad.push(item.cantidad);
                _dataCantidadName.push("Cantidad");
            })
            //ranking
            grapPorColaborador('chartRanking', _labelservices, _dataTotal, _dataCantidad , _dataCantidadName);
            datatableC(rta.dias);
        
        }).catch(function(error){
            console.log('getData dio error'); console.log(error);
            Swal.fire('Ocurrio un Error', error.message, 'error');
        });
}
var table=""
    function datatableC(data){
        if (table !="") {
            table.destroy();
            $("#example >tbody").empty();
            $("#example >thead").empty(); 
        }
        table =$('#example').DataTable( {
        data: data,
        order: [[1, "desc"]],
        aLengthMenu: [
            [25, 50, 100, -1],
            [25, 50, 100, "Todos"]
        ],
        dom: 'Bfrtip',
        buttons: [
            'pageLength',
            'excelHtml5',
            'pdfHtml5'
        ],
        columns: [
            {data: 'art', title: 'Servicio', 'defaultContent': ''},
            {data: 'total', title: 'Total rango: '+$('#desde').val()+'-'+$('#hasta').val(), 'defaultContent': ''},
            {data: 'dia', title: 'Dias de mayor Demanda(especifique la sucursal)', 'defaultContent': ''},
        ]
        } );
    }
    var charset="";
    function grapPorColaborador(_id, _labelsBar, _dataBar,_dataCanti,dataName){
        if (charset != "") {
            console.log('destroy')
            charset.destroy()
        }
        var canvas = document.getElementById(_id);
        var ventasPorFechaCtx = canvas.getContext("2d");

        const data = {
            labels: _labelsBar,
            datasets: 
            [
            {// CANTIDADES
                label: 'Cantidades '+$('#desde').val()+' Hasta: '+$('#hasta').val(),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 159, 64, 0.5)'
                ],
                borderColor: 'rgb(255, 99, 132)',
                data:_dataCanti,
            },
        ]
        };

        const config = {
            type: 'horizontalBar',
            // type: 'horizontalBar',
            data: data,
            options: {}
        };

        charset = new Chart(
            ventasPorFechaCtx,
            config
        );

    }

function descargarExcel(){
    tiempoEspera()
    var fecha_desde=$('#fecha_desde').val();
    var fecha_hasta=$('#fecha_hasta').val();
    var anho_desde=$('#anho_desde').val();
    var anho_hasta=$('#anho_hasta').val();
    var colaborador=$('#colaborador_id').val();
    var af="a";
    var sucursal=$('#sucursales').val();
    if ($('#flexRadioDefault1').prop('checked')) {
        var af="f";
    }
    var datos='?sucursal='+sucursal+'&f_desde='+fecha_desde+'&f_hasta='+fecha_hasta+'&a_desde='+anho_desde+'&a_hasta='+anho_hasta+'&af='+af+'&col_id='+colaborador;
    var per="{{route('admin.ingresos.excel')}}"+datos
    var ventana;
    ventana = window.open(per , '_');
}
function tiempoEspera(){
    let timerInterval
    Swal.fire({
    title: 'Espere Mientras Se Genera el reporte',
    html: '<b></b>Tiempo en Milisegundos.',
    timer: 3000,
    timerProgressBar: true,
    didOpen: () => {
        Swal.showLoading()
        const b = Swal.getHtmlContainer().querySelector('b')
        timerInterval = setInterval(() => {
        b.textContent = Swal.getTimerLeft()
        }, 100)
    },
    willClose: () => {
        clearInterval(timerInterval)
    }
    }).then((result) => {
    if (result.dismiss === Swal.DismissReason.timer) {
    }
    })
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
      
    function ver() {
        var comision = 'fija'
        if ($('#cobrado').prop('checked')) {
            comision = 'cobrado';
        }
        if (reglas()) {
            var ventana;
            var url = "{{ route('admin.comiciones.pdf') }}" + '?colaborador_id=' + $('#colaborador_id').val() +
                '&desde=' + $('#fecha_desde').val() + '&hasta=' + $('#fecha_hasta').val() + '&comision=' + comision;
            ventana = window.open(url, '_');
        }
    }



    </script>


@stop
