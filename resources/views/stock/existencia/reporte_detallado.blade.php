@extends('layouts.admin')
@section('main-content')
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<div class="contaier form-inline">
    <div id='errores_ventas' style='display:none' class='alert alert-danger'></div>
    <div id='success' style='display:none;' style="background: #4e73df  !important;" class='alert alert-primary'></div>
    <input class="btn button " type="hidden" id="mostrar_errores" value="1" disabled error="">

    <div class="card shadow mb-3 col-12 ">
        <div class="card-header">
            Reporte Detallado &nbsp; &nbsp;
        </div>
        <form action="#">
                <div class="form-group">
                    <label for="entidad">Entidad:</label>
                    <select class="form-control ml-5" id="entidad" name="entidad">
                    </select>
                </div>
                <div class="form-group mt-2">
                    <label for="exampleFormControlSelect1">Sucursal:</label>
                    <select class="form-control ml-5" id="sucursal" name="sucursal">
                    </select>
                </div>
                <div class="form-group mt-2">
                    <label for="exampleFormControlSelect1">Deposito:</label>
                    <select class="form-control ml-5" id="deposito" name="deposito">
                    </select>
                </div>
                <div class="form-group mt-2 ">
                    <label for="exampleFormControlSelect1">Fecha Desde</label>
                    <input type="date" class="form-control ml-4" aria-label="Hasta" aria-describedby="basic-addon1" value="<?php echo date("Y-m-d")?>" id="fecha_desde">
                </div>
                <div class="form-group mt-2 ">
                    <label for="exampleFormControlSelect1">Fecha Hasta</label>
                    <input type="date" class="form-control ml-4" aria-label="Hasta" aria-describedby="basic-addon1" value="<?php echo date("Y-m-d")?>" id="fecha_hasta">
                </div>
                <div class="form-group mt-2 ">
                    <label for="exampleFormControlSelect1">Articulo Desde</label>
                    <input type="text" class="form-control ml-2" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');">
                </div>
                <div class="form-group mt-2">
                    <label for="exampleFormControlSelect1">Articulo Hasta</label>
                    <input type="text" class="form-control ml-2" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');">
                </div>
                <button id="buscar" type="button" class="btn btn-success ml-1 mt-2">Buscar</button>
        </form>


    </div>
    <div class="card shadow mb-3 col-12 ">
        <form action="#" method="POST" id="myform">
            @csrf
            <input type="hidden" id="categoria_id" name="categoria_id">
            <input type="hidden" id="deposito_id" name="deposito_id">
            <table class="table" id="tabla-venta">
                <thead class="thead-dark">
                    <tr>
                        <th>Fecha</th>
                        <th>Tipo Movimiento</th>
                        <th>Motivo</th>
                        <th>Entrada</th>
                        <th>Salida</th>
                        <th>Ajuste</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </form>
    </div>
</div>
@endsection
@section('script')
<script>
    $( document ).ready(function() {

@php
    echo ' var entidades = '.json_encode($entidades).'; ';
    echo ' var sucursales = '.json_encode($sucursales).'; ';
    echo ' var depositos = '.json_encode($depositos).'; ';
    echo ' var entidad_id = '.json_encode(auth()->user()->entidad_id).'; ';
    echo ' var sucursal_id = '.json_encode(env('SUCURSAL')).'; ';
@endphp
rellenarDefecto();
function rellenarDefecto() {
        $('#entidad option').remove().promise().done(function(){
            $("#entidad").append("<option value='0'>Todas</option>");
            $.each(entidades, function(i, item) {
                if ( entidad_id == item.id) {
                    $("#entidad").append("<option value="+item.id+" selected>"+item.name+"</option>");
                }else{
                    $("#entidad").append("<option value="+item.id+">"+item.name+"</option>");
                }
            });
        });

            $('#sucursal option').remove().promise().done(function(){
                $("#sucursal").append("<option value='0'>Todas</option>");
            $.each(sucursales, function(i, item) {
                if (entidad_id == item.entidad_id) {
                    if (sucursal_id == item.id) {
                        $("#sucursal").append("<option value="+item.id+" selected>"+item.name+"</option>");
                    }else{
                        $("#sucursal").append("<option value="+item.id+">"+item.name+"</option>");
                    }
                }

            });
        });

            $('#deposito option').remove().promise().done(function(){
            $("#deposito").append("<option value='0'>Todas</option>");
            $.each(depositos, function(i, item) {
                if (entidad_id== item.entidad_id) {
                    if (sucursal_id == item.sucursal_id) {
                        $("#deposito").append("<option value="+item.id+">"+item.name+"</option>");
                    }
                }

            });
        });
}
$("#entidad").change(function() {
    var numero_entidad=$('#entidad').val();
    if (numero_entidad == 0) {
        $('#sucursal option').remove().promise().done(function(){
            $("#sucursal").append("<option value='0' selected>Todas</option>");
            $("#sucursal").attr('disabled',true);
            $("#deposito").attr('disabled',true);
            $.each(sucursales, function(i, item) {
                if (numero_entidad == item.entidad_id) {
                    $("#sucursal").append("<option value="+item.id+">"+item.name+"</option>");
                }

            });
        });
            $('#deposito option').remove().promise().done(function(){
                $("#deposito").append("<option value='0' selected>Todas</option>");
            $.each(depositos, function(i, item) {
                if (numero_entidad == item.entidad_id) {
                    if ($("#sucursal").val() == item.sucursal_id) {
                        $("#deposito").append("<option value="+item.id+">"+item.name+"</option>");
                    }
                }

            });
        });
        
    }else{
        $("#sucursal").attr('disabled',false);
        $("#deposito").attr('disabled',false);
        $('#sucursal option').remove().promise().done(function(){
            $("#sucursal").append("<option value='0' selected>Todas</option>");
            $.each(sucursales, function(i, item) {
                if (numero_entidad == item.entidad_id) {
                    $("#sucursal").append("<option value="+item.id+">"+item.name+"</option>");
                }

            });
        });
            $('#deposito option').remove().promise().done(function(){
            $("#deposito").append("<option value='0' selected>Todas</option>");
            $.each(depositos, function(i, item) {
                if (numero_entidad == item.entidad_id) {
                    if ($("#sucursal").val() == item.sucursal_id) {
                        $("#deposito").append("<option value="+item.id+">"+item.name+"</option>");
                    }
                }

            });
        });
    }
});
$("#sucursal").change(function() {
    var numero_entidad=$('#entidad').val();
    var numero_sucursal=$('#sucursal').val();
    if (numero_sucursal == 0) {
        $('#deposito option').remove().promise().done(function(){
            $("#deposito").append("<option value='0' selected>Todas</option>");
            $("#deposito").attr('disabled',true);
            $.each(depositos, function(i, item) {
                if (numero_entidad== item.entidad_id) {
                    if (numero_sucursal == item.sucursal_id) {
                        $("#deposito").append("<option value="+item.id+">"+item.name+"</option>");
                    }
                }

            });
        });
    }else{
        $("#deposito").attr('disabled',false);
        $('#deposito option').remove().promise().done(function(){
            $("#deposito").append("<option value='0' selected>Todas</option>");
            $.each(depositos, function(i, item) {
                if (numero_entidad== item.entidad_id) {
                    if (numero_sucursal == item.sucursal_id) {
                        $("#deposito").append("<option value="+item.id+">"+item.name+"</option>");
                    }
                }

            });
        });
    }  
});

});

$('#buscar').on( 'click', function (e) {
    e.preventDefault();
});


</script>
@endsection