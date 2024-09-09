@extends('adminlte::page')

@section('title', 'Agendas')


@section('content_header')

@stop

@section('content')

    @include('admin.reporte.historial_profesionales.filtro')
    @include('admin.reporte.historial_profesionales.data')
    <br>
@stop

@section('js')
<script src=" {{ asset('js/comunes.js') }} "></script>
<script src=" {{ asset('js/logicaReporte.js') }} "></script>

<script>
$(document).ready(function() {
});
function filtar(){
    $('.loader').show()
    var url = "{{ route('admin.reporte.historial.profesionales.data') }}" + '?profesional='+$('#profesional').val()+'&desde='+$('#desde').val()+'&hasta='+$('#hasta').val();
    getData(url).then(function(rta){
        console.log(rta)
        $('.loader').hide()
        if (rta.cod == 200) {
            if (rta.data != null) {
                historial();
                $("#p_name").html(rta.data.cliente.name);
                $("#p_factu").html(rta.data.facturado);
                $("#p_comi_p").html(rta.data.comisionado);
                $("#p_cant_aten").html(rta.data.atendidos);
                $("#p_cant_rep").html(rta.data.repetidos);
                $("#nun_tel").html(rta.data.cliente.telefono);
                $("#correo").html(rta.data.cliente.email);
                $("#cump").html(rta.data.cliente.cumple); 
            }
           
            
            // $("#pro_fav").html(rta.data.prof_fav.name);

        }else{
            toastr.options = { "closeButton": true, };
            toastr.error(rta['msg'], rta['msg']);
        }
       
    }).catch(function(error){
        $('.loader').hide()
        console.log('getData dio error'); console.log(error);
        Swal.fire('Ocurrio un Error', error.message, 'error');
    });

}
var _urlmodal = "{{ route('admin.reporte.historial.profesionales.data.h') }}" + '?cliente_id=';
    var data = {
        table: "tablaListadoHistorial",
        ajax : _urlmodal,
        topMsg: "",
        filename: "Listado",
        title: 'Listado',
        columns: [
            {data: 'cantidad', name: 'fecha', title: 'Cantidad',class: 'noexport dt-center'},
            {data: 'servicio', name: 'servicio', title: 'Servicio / Producto',class: 'noexport dt-center'},
            {data: 'top', name: 'top', title: 'Top',class: 'noexport dt-center'},
        ]
    };
    toDataTableSimple(data)

function historial(){
    if ($('#profesional').val()) {
        var _url = "{{ route('admin.reporte.historial.profesionales.data.h') }}" + '?profesional='+$('#profesional').val()+'&desde='+$('#desde').val()+'&hasta='+$('#hasta').val();
        console.log(_url)
        var table = $('#tablaListadoHistorial').DataTable();
        table.ajax.url(_url).load();
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
@stop
