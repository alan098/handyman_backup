@extends('adminlte::page')

@section('title', 'Agendas')


@section('content_header')

@stop

@section('content')

    @include('admin.reporte.historial_servicios.filtro')
    @include('admin.reporte.historial_servicios.data')
    <br>
@stop

@section('js')
<script src=" {{ asset('js/comunes.js') }} "></script>
<script src=" {{ asset('js/logicaReporte.js') }} "></script>

<script>
$(document).ready(function() {
});
function filtar(){
    $('.loader').show();
    var url = "{{ route('admin.reporte.historial.servicios.data') }}" + '?servicio='+$('#servicio').val()+'&desde='+$('#desde').val()+'&hasta='+$('#hasta').val();
    getData(url).then(function(rta){
        $('.loader').hide();
        if (rta.cod == 200) {
            if (rta.data != null) {
                $("#p_serv").html(rta.data.name);
                $("#p_mont_fa").html(rta.data.facturado);
                $("#p_cantid").html(rta.data.cantidad);
            }
        }else{
            toastr.options = { "closeButton": true, };
            toastr.error(rta['msg'], rta['msg']);
        }
       
    }).catch(function(error){
        $('.loader').hide();
        console.log('getData dio error'); console.log(error);
        Swal.fire('Ocurrio un Error', error.message, 'error');
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
