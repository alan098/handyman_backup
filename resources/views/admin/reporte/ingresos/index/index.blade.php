@extends('adminlte::page')

@section('title', 'Agendas')


@section('content_header')

@stop

@section('content')
    {{--//todo: Loader  --}}
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__wobble" src="{{ asset('img/bonicalogo.png')}}" alt="AdminLTELogo" height="300" width="300">
    </div>
    {{--//todo: Loader  --}}
     
    @include('admin.reporte.ingresos.index.filtro')
    @include('admin.reporte.ingresos.index.botones')
    <br>

@stop

@section('js')
    <script src=" {{ asset('js/comunes.js') }} "></script>
    <script type="text/javascript">
        let url_01 = "{{ route('admin.ingresosa.datatable') }}";
        let url_02 = "{{ route('admin.ingresosi.datatable') }}";
        let url_03 = "{{ route('admin.ingresos.comision.datatable') }}";
        let url_04 = "{{ route('admin.ingresos.sucursal.datatable') }}";
        let url_05 = "{{ route('admin.resumen.datatable') }}";
        let url_06 = "{{ route('admin.profesional.comision.datatable') }}";
      </script>
    <script>
    
function marcas(algo){
    if ($(algo).val() == "f") {
        $('#por_fecha').css('display','block')
        $('#por_anho').css('display','none')
        $('#por_fecha>.col').css('display', 'inline-block')
    }else if($(algo).val() == "a"){
        $('#por_fecha').css('display','none')
        $('#por_anho').css('display','block')
    }
}

function tablesRecarge(){
    var af="a";
    if ($('#flexRadioDefault1').prop('checked')) {
        var af="f";
    }
    if (af=='a') {
        $("[id^='fe_de_fil']").text($('#anho_desde').val() + '-01')
        $("[id^='fe_ha_fil']").text($('#anho_hasta').val() + '-30')
    }else{
        $("[id^='fe_de_fil']").text($('#fecha_desde').val())
        $("[id^='fe_ha_fil']").text($('#fecha_hasta').val())
    }
    $('.botonGroup .btn').each(function(e,data) {
        var cadena = $(this).attr('class');
        if(cadena.indexOf("secondary") > -1){
           var id=$(this).attr('id');
            $('#'+id).trigger('click');
        }
    });
   
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


        // funciones generales
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

//seccion de graficos
function grafic(datos){
    var per="{{route('admin.ingresos.resumen.datatable')}}"+datos
        getData(per).then(function(rta){
            var _labelColaborador = [];
            var _dataColaborador = [];
            $.each(rta, function(i, item) {
                _labelColaborador.push(item.mes);
                _dataColaborador.push(item.total);
            })
            grapPorColaborador('ventas_resumen', _labelColaborador, _dataColaborador);
        
        }).catch(function(error){
            console.log('getData dio error'); console.log(error);
            Swal.fire('Ocurrio un Error', error.message, 'error');
        });
}
       







    function grapPorColaborador(_id, _labelsBar, _dataBar){

        var canvas = document.getElementById(_id);
        var ventasPorFechaCtx = canvas.getContext("2d");

        const data = {
            labels: _labelsBar,
            datasets: [{
            label: 'Por Mes {{ date('m-Y') }}',
            backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)'
            ],
            borderColor: 'rgb(255, 99, 132)',
            data:_dataBar,
            }]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {}
        };

        const myChart = new Chart(
            ventasPorFechaCtx,
            config
        );

    }




    </script>
    <script src=" {{ asset('js/logicaReporteIngreso.js') }} "></script>
@stop
