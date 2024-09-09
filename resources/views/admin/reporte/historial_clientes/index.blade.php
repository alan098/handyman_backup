@extends('adminlte::page')

@section('title', 'Agendas')


@section('content_header')

@stop

@section('content')

    @include('admin.reporte.historial_clientes.filtro')
    @include('admin.reporte.historial_clientes.data')
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
    language: {
        noResults: function() {
        return "No hay resultado";        
        },
        searching: function() {
        return "Buscando..";
        },
        inputTooShort: function() {
        return "Debe Colocar por lo menos 2 caracteres";
        }
    },
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
@unless(empty($cliente))
    setTimeout(function(){$("#fi").click()},2000); 
@endunless
function filtar(){
    $('.loader').show();
    var url = "{{ route('admin.reporte.historial.clientes.data') }}" + '?cliente_id='+$('#cliente_id').val()+'&desde='+$('#desde').val()+'&hasta='+$('#hasta').val()+'&sucursal_id='+$('#sucursales').val();
    getData(url).then(function(rta){
        $('.loader').hide();
        if (rta.cod == 200) {
            historial();
            if (rta.data) {
               $("#c_name").html(rta.data.cliente.name);
                $("#c_gast").html(rta.data.total);
                $("#c_cant").html(rta.data.cantidad_visitas);
                $("#c_dias").html(rta.data.dias.dias);
                $("#nun_tel").html(rta.data.telefono);
                $("#correo").html(rta.data.email);
                $("#cump").html(rta.data.cumple);
                $("#primer").html(rta.data.fecha_pri.fecha);
                $("#serv_fav").html(rta.data.serv_fav.name);
                $("#pro_fav").html(rta.data.prof_fav.name);  
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
var _urlmodal = "{{ route('admin.reporte.historial.clientes.data.h') }}" + '?cliente_id=';
    var data = {
        table: "tablaListadoHistorial",
        ajax : _urlmodal,
        topMsg: "",
        filename: "Listado",
        title: 'Listado',
        columns: [
            {data: 'fecha', name: 'fecha', title: 'Fecha',class: 'noexport dt-center'},
            {data: 'servicio', name: 'servicio', title: 'Servicio / Producto',class: 'noexport dt-center'},
            {data: 'colaborador', name: 'colaborador', title: 'Colaborador',class: 'noexport dt-center'},
        ]
    };
    toDataTableSimple(data)

function historial(){
    if ($('#cliente_id').val()) {
        var _url = "{{ route('admin.reporte.historial.clientes.data.h') }}" + '?cliente_id='+$('#cliente_id').val()+'&desde='+$('#desde').val()+'&hasta='+$('#hasta').val()+'&sucursal_id='+$('#sucursales').val();
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
