@extends('adminlte::page')
@section('title', 'Usuarios')
{{-- @section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop --}}
@section('content_header')
<h1>Anular</h1>
@stop
@section('content')
{{--  --}}

  {{-- url()->current() --}}
  <div class="modal" tabindex="-1" role="dialog" id="modal_borrar">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Alerta..!</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Estas seguro que desea Anular la venta...?</p>
          <input type="hidden" name="" id="id_a_eliminar">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" id="eliminacion">Si</button>
          <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
        </div>
      </div>
    </div>
  </div>
{{--  --}}
<div id='errores_consulta' style='display:none' class='alert alert-danger'></div>
  <div id='correcto_consulta' style='display:none' class='alert alert-success'></div>
  <div id="super_oculto">
<div class="card shadow mb-3 ml-5 col-10 ">
  
  @if (auth()->user()->perfil != 1)
  <div class="card-header">Buscar en Ventas del dia</div>
  @else
  <div class="card-header">Buscar ventas por fecha</div>
  @endif
  <div class="card shadow mb-1" style="margin: 20px 0px 0px 0px;">
    <div class="card-body" style="padding: 0;">
        <div class="col-sm-12" style="padding: 10px 0; overflow: hidden;">
            <div class="col-sm-3" style="float: left;">
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Desde</span>
                    </div>
                    <input type="date" class="form-control" aria-label="Desde" aria-describedby="basic-addon1" value="<?php echo date("Y-m-d")?>" id="fecha_desde" 
                    >
                </div>
            </div>
            <div class="col-sm-3" style="float: left;">
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Hasta</span>
                    </div>
                    <input type="date" class="form-control" aria-label="Hasta" aria-describedby="basic-addon1" value="<?php echo date("Y-m-d")?>" id="fecha_hasta" >
                </div>
            </div>
            <div class="col-sm-3" style="float: left;" id="des_ilegal">
                <a href="javascript:void(0);"  type="button" class="btn btn-success btn-icon-split" id="buscar" style="font-size: 0.64rem;" onclick="filtrarRegistro();">
                    <span class="icon text-white-50">
                      <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Filtrar</span>
                </a>
               
            </div>
            <div class="col-sm-1" style="display: none; float: right;" id="esperando">
              <div class="loader" ></div>
            </div>
        </div>
    </div>
</div>

</div>
        
<style>
.loader {
    border: 16px solid #f3f3f3;
    border-radius: 50%;
    border-top: 16px solid blue;
    border-right: 16px solid green;
    border-bottom: 16px solid red;
    border-left: 16px solid pink;
    width: 80px;
    height: 80px;
    -webkit-animation: spin 2s linear infinite;
    animation: spin 2s linear infinite;
    position: relative;

  }
  @-webkit-keyframes spin {
      0% { -webkit-transform: rotate(0deg); }
      100% { -webkit-transform: rotate(360deg); }
  }
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }

  </style>
  
  <div id="ocultardos">
      <table class="table table-sm table-striped" id="tabla-venta-elegir">
                <thead>
                  <tr>
                    <th>Tipo de Coprobante</th>
                    <th>Numero de Comprobante</th>
                    <th>Cliente</th>
                    <th>Ruc</th>
                    <th>Total</th>
                    <th style="text-align: center">Acciones</th>
                  </tr>
                </thead>
                <tbody id="tbodyid">
                </tbody>
          </table>
  </div>
</div>
{{--  --}}
<style>
  #ocultar {
    display: none;
  }
  #ocultardos {
    display: none;
  }
  #ilegal {
    display: none;
  }
  #tabla-venta-elegir_filter label input {
  border-radius: 5px;
  height: 80px; 
  float: center;
  font-size: 40px !important;
} 
  .redondo{
              display: block;
              width: 30px;
              height: 30px;
              border-radius: 50%;
              }
</style>

<div id="ocultar">
  <input type="hidden" id="venta_id">
  <div class="col-sm-12" style="font-size: 13px; padding: 0;">
    <div id='errores_ventas' style='display:none' class='alert alert-danger'></div>
    <div id='correcto_ventas' style='display:none' class='alert alert-success'></div>

    <div class="col-sm-12" style="float: left; padding: 0 5px;">

      <div class="card shadow mb-1">
        <div class="card-body" style="padding: 10px 0;">

          <div class="col-sm-12" style="padding: 0; overflow: hidden;">
            <div class="col-sm-3" style="float: left;">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">RUC / C.I.Nro.</span>
                </div>
                <input type="text" id="venta_CI" class="form-control" aria-label="Username"
                  aria-describedby="basic-addon1">
              </div>
            </div>
            <div class="col-sm-4" style="float: left;">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">Cliente</span>
                </div>
                <input type="text" id="venta_razonSocial" class="form-control" placeholder="Username"
                  aria-label="Username" aria-describedby="basic-addon1">
                <div class="input-group-append">
                </div>
              </div>
            </div>

            <input type="hidden" id="id_cliente">
            <p id="errors" hidden="true">El cliente no esta registrado</p>
            
            <div class="col-sm-4" style=" float: left;">
              <button class="btn btn-outline-success btn-sm" style="width: 100%; padding: 10px 0; text-align: center;"
                id="btn-ticket">
                <i class="fas fa-print"></i>Guardar y Devolver</button>
            </div>


          </div>

        </div>
      </div>
    </div>

    <div class="col-sm-12" style="float: left; padding: 0 5px;">

      <div class="card shadow mb-1">
        <div class="card-body" style="padding: 10px; height: 300px; overflow-y: scroll;">
          <table class="table table-sm table-striped" style="width: 100%; border: 1px solid #e5e5e5; font-size: 11px;"
            id="tabla-venta">
            <thead>
              <tr>
                <th>Cantidad</th>
                <th>#Lista Asociada</th>
                <th>Descuento</th>
                <th>Codigo Articulo</th>
                <th>Descripcion</th>
                <th>Unitario</th>
                <th>Total</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody id="tbodyid">
            </tbody>
          </table>
        </div>
      </div>
    </div>
    {{-- Devuelucion --}}
    <input type="hidden" id="comprados">
    <div class="card shadow mb-1">
      <div class="card-header">
       <h6> Devoluciones</h6>
      </div>
      <div class="card-body" style="padding: 10px; height: 300px; overflow-y: scroll;">
        <table class="table table-sm table-striped" style="width: 100%; border: 1px solid #e5e5e5; font-size: 11px;"
          id="tabla-venta_devoluion">
          <thead>
            <tr>
                <th>Cantidad</th>
                <th>#Lista Asociada</th>
                <th>Descuento</th>
                <th>Descripcion</th>
                <th>Unitario</th>
                <th>Total</th>
            </tr>
          </thead>
          <tbody id="tbodyid_devolucion">
          </tbody>
        </table>
      </div>
    </div>
  </div>
  </div>
  <input type="hidden" id="datos_venta_existe" value="no">
  <input type="hidden" id="datos_venta">
  <input type="hidden" id="factura_comprobante">
  <input type="hidden" id="datos_venta_ilegales">
  <input type="hidden" id="metodos_de_pago">
  <input type="hidden" id="articulos">

 

 

</div>
{{--  --}}
@stop
@section('js')
<script src=" {{ asset('js/comunes.js') }} "></script>
<script>

$( document ).ready(function() {
  sessionStorage.removeItem('datos_venta');
var productosJson=null;
var personasJson=null;
var autocomplete=null;
var selectJson=null;

});//document ready
//cosas negras
jQuery.multipress = function (keys, handler) {
    'use strict';

    if (keys.length === 0) {
        return;
    }
    var down = {};
    jQuery(document).keydown(function (event) {
        down[event.keyCode] = true;
    }).keyup(function (event) {
        // Copy keys array, build array of pressed keys
        var remaining = keys.slice(0),
            pressed = Object.keys(down).map(function (num) { return parseInt(num, 10); }),
            indexOfKey;
        // Remove pressedKeys from remainingKeys
        jQuery.each(pressed, function (i, key) {
            if (down[key] === true) {
                down[key] = false;
                indexOfKey = remaining.indexOf(key);
                if (indexOfKey > -1) {
                    remaining.splice(indexOfKey, 1);
                }
            }
        });
        // If we hit all the keys, fire off handler
        if (remaining.length === 0) {
            handler(event);
        }
    });
};
function ajustar(tam, num) {
if (num.toString().length <= tam) return ajustar(tam, "0" + num)
else return num;
}

function filtrarRegistro(){
// var buscar_numero_comprobante = $('#buscar_numero_comprobante').val();
$("#des_ilegal").hide();
$('#esperando').show()
var desde = $('#fecha_desde').val();
var hasta = $('#fecha_hasta').val();
var table =$('#tabla-venta-elegir').DataTable();
table.destroy();
// $('#tabla-venta').empty(); 
$("#tabla-venta-elegir >tbody").empty();
$("#tabla-venta-elegir >thead").empty();
$.ajax({
type:"GET",
url: '{{ route("admin.anular.data") }}',
type: 'GET',
data: { desde: desde, hasta: hasta },
    success: function(rta)
    {
      if (rta.cod_retorno > 200) {

        var html = '';

        html += '<strong>Error!</strong> '+rta.des_retorno+'<br>';

        $('#errores_consulta').html(html).promise().done(function(){
            $(this).slideToggle('slow');
        });
        $('#ocultar').css('display','none');
        $("#des_ilegal").show();
        setTimeout(function(){
            $('#errores_consulta').slideToggle('slow');
        }, 5000);
    }else{
    
      var venta=null;
        venta = rta.venta;
        var cabecera="";
        cabecera +=    '<tr>';
        cabecera +=    '<th>Tipo de Coprobante</th>';
        cabecera +=    '<th>Numero de Comprobante</th>';
        cabecera +=    '<th>Cliente</th>';
        cabecera +=    '<th>Ruc</th>';
        cabecera +=    '<th>Total</th>';
        cabecera +=    '<th>Acciones</th>';
        cabecera +=    '</tr>';
        $("#tabla-venta-elegir >thead").append(cabecera).promise().done(function(){ 
        });
        var fila="";
        var tipo="";
         venta.forEach(function callback(ele, index, array) {
                  fila +='<tr id='+ele.id+'>';
                  if (!ele.numero_factura) {
                    tipo="comprobante";
                    fila +=    '<td >Comprobante</td>';
                    fila +=    '<td >'+ele.id+'</td>';
                  }else{
                    tipo="factura";
                    fila +=    '<td >Factura</td>';
                    fila +=    '<td >'+ajustar(2,ele.sucursal_id)+'-'+ajustar(2,ele.punto_de_venta_id)+'-'+ajustar(2,ele.numero_factura)+'</td>';
                  }
                  fila +=    '<td >'+ele.name+'</td>';
                  fila +=    '<td>'+ele.ruc+'</td>';
                  fila +=    '<td>'+ele.total+'</td>';
                  if ((ele.anulado != true)) {
                      if (ele.devolucion == null) {
                        fila +='<td style="text-align: center">';
                        fila +=    '<button type="button" class="btn btn-danger" onclick= anular(\''+ele.id+'\') >Anular</button>';
                        // fila +=    '<button type="button" class="btn btn-danger ml-5" >Clonar y Anular</button>';
                      fila +='</td>';
                      }else{
                        fila +='<td style="text-align: center">';
                          fila +=    '<div class=" form-inline"><button type="button" class="mr-1 btn-success"  disabled>No anulable</button></div>';
                          fila +=    '<div class=" form-inline"><button type="button" class=" btn-primary" >Devuelto</button></div><';
                        fila +='</td>';
                      }
                  } else {
                   fila +=    '<td style="text-align: center"><button type="button" class="mr-1 btn-success"  disabled>Anulado</button></td>';
                  }
                  fila +="</tr>";
      });
      
      $("#tabla-venta-elegir >tbody").append(fila).promise().done(function(){ 
        $("#des_ilegal").attr('disabled',false);
        $('#ocultardos').css('display','block');  
        var table = $('#tabla-venta-elegir').DataTable({
          initComplete: function () {
            $('#tabla-venta-elegir_filter label input').focus();
            $('#esperando').hide()
            $("#des_ilegal").show();
          }
        });
      });

    }
  }
}).fail( function( jqXHR, textStatus, errorThrown ) {
            if (jqXHR.status === 0) {
                console.log('Not connect: Verify Network.');
            } else if (jqXHR.status == 404) {
                console.log('Requested page not found [404]');
            } else if (jqXHR.status == 500) {
                console.log('Internal Server Error [500].');
            } else if (textStatus === 'parsererror') {
                console.log('Requested JSON parse failed.');
            } else if (textStatus === 'timeout') {
                console.log('Time out error.');
            } else if (textStatus === 'abort') {
                console.log('Ajax request aborted.');
            } else {
                console.log('Uncaught Error: ' + jqXHR.responseText);
            }
    });
}


$("#eliminacion").on("click", function(e){
      e.preventDefault();
      $("#eliminacion").prop('disabled',true);
      var id_eliminar=$('#id_a_eliminar').val();
      console.log(id_eliminar)
      enviarPeticion(id_eliminar);
});
function anular(id){
  $('#id_a_eliminar').val(id);
  $('#modal_borrar').modal({
            backdrop: 'static',
            keyboard: true, 
            show: true
        });
}
function enviarPeticion(id){
  $.ajax({
        type:"GET",
        url: "{{route('admin.anular.anular')}}",
        type: 'GET',
        data: {id:id},
        success: function(rta){
          console.log(rta);
          if (rta.cod > 200) {
                    var html = '';
                    html += '<strong>Error!</strong> '+rta.msg+'<br><br>';
                    $('#errores_consulta').html(html).promise().done(function(){
                        $(this).slideToggle('slow');
                    });
              }else{
                  var html = '';
                    html += '<strong>Devolucion Concretada</strong>';
                    $('#correcto_consulta').html(html).promise().done(function(){
                        $(this).slideToggle('slow');
                    });
                setTimeout(function(){    window.open('{!! route("admin.anular.ventas.index") !!}' , '_self'); }, 3000);
              }
        }
      }).fail( function( jqXHR, textStatus, errorThrown ) {
            if (jqXHR.status === 0) {
                console.log('Not connect: Verify Network.');
            } else if (jqXHR.status == 404) {
                console.log('Requested page not found [404]');
            } else if (jqXHR.status == 500) {
                console.log('Internal Server Error [500].');
            } else if (textStatus === 'parsererror') {
                console.log('Requested JSON parse failed.');
            } else if (textStatus === 'timeout') {
                console.log('Time out error.');
            } else if (textStatus === 'abort') {
                console.log('Ajax request aborted.');
            } else {
                console.log('Uncaught Error: ' + jqXHR.responseText);
            }
    });
}

</script>
@endsection