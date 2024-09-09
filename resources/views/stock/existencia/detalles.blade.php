@extends('adminlte::page')
@section('css')
@stop
@section('title', 'Agendas')
@section('content_header')
<h1>Existencia</h1>
@stop
@section('content')
<div class="contaier form-inline">

    <div id='errores_ventas' style='display:none' class='alert alert-danger'></div>
    <div id='success' style='display:none;' style="background: #4e73df  !important;" class='alert alert-primary'></div>
    <input class="btn button " type="hidden" id="mostrar_errores" value="1" disabled error="">

    <div class="card shadow mb-3 col-12 ">
        <div class="card-header">
            Movimientos de Articulo <strong>[ {{ $articulos->id.' - '.$articulos->name }} ] [ Saldo: {{ $saldo }} ]</strong>
        </div>
    </div>
    <div class="card shadow mb-3 col-12 ">
        <form action="#" method="POST" id="myform">
            @csrf
            <input type="hidden" id="categoria_id" name="categoria_id">
            <input type="hidden" id="deposito_id" name="deposito_id">
            <table class="table table-striped" id="tabla-venta">
            </table>
        </form>
    </div>
</div>

<div class="modal fade" id="modalDetalles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
</div>
@stop
@section('js')
<script src=" {{ asset('js/comunes.js') }} "></script>
<script>
    $( document ).ready(function() {

    @php
        echo ' var entidades = '.json_encode($entidades).'; ';
        echo ' var sucursales = '.json_encode($sucursales).'; ';
        echo ' var depositos = '.json_encode($depositos).'; ';
        echo ' var entidad_id = '.request('entidad').'; ';
        echo ' var sucursal_id = '.request('sucursal').'; ';
        echo ' var deposito_id = '.request('deposito') .'; ';
        echo ' var articulo_id = '.request('articulo') .'; ';

    @endphp
  
    var _url = "{{route('admin.existencia.detalles.data')}}" +'?entidad='+entidad_id+'&sucursal='+sucursal_id+'&deposito='+deposito_id+'&articulo='+articulo_id;
    var data = {
            table: "tabla-venta",
            ajax : _url,
            topMsg: "",
            footerMsg: "Generado",
            filename: "Listado ",
            title: 'Listado ',
            columns: [
                {data: 'id', name: 'id', className: "text-left", title:'Id'},
                {data: 'fecha',name:'fecha', className: "text-left", title:'Fecha'},
                {data: 'movimiento',name:'movimiento', className: "text-left", title:'Movimiento'},
                {data: 'suc_name',name:'deposito', className: "text-left", title:'Sucursal'},
                {data: 'dep_name',name:'deposito', className: "text-left", title:'Deposito'},
                {data: 'motivo',name:'motivo', className: "text-left", title:'Motivo'},
                {data: 'entrada', name: 'entrada', title:'Entrada', searchable: false, className: "text-right"},
                {data: 'salida', name: 'salida', title:'Salida', searchable: false, className: "text-right"},
                {data: 'detalle', name: 'detalle', title:'Ver', orderable: false, searchable: false, className:"notexport",
                    "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                        $(nTd).html("<button type='button' class='btn btn-primary' onclick='verDetalle(\""+oData.detalle+"\")'><i class='fas fa-eye'></i></button>");
                    }
                }
            ]
        };
        toDataTable(data);
    });

    function verDetalle(_url){
        var ventana;
        var url = "{{ route('admin.existencia.redirecion') }}" + '?redi='+_url;
        ventana = window.open(url , '_');
    }


</script>
@stop
