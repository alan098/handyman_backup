@extends('adminlte::page')
@section('title', 'Agendas')

@section('content_header')
@stop
@section('content')
{{--  --}}
<div id='errores_consulta' style='display:none' class='alert alert-danger'></div>
  <div id='correcto_consulta' style='display:none' class='alert alert-success'></div>
  <div id="super_oculto">
<div class="card shadow mb-3 ml-5 col-10">
  
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
                    <input type="date" class="form-control" aria-label="Desde" aria-describedby="basic-addon1" value="<?php echo date("Y-m-d")?>" id="fecha_desde" >
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
                <a type="button" class="btn btn-success btn-icon-split" id="buscar" style="font-size: 0.64rem;" >
                    <span class="icon text-white-50">
                      <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Filtrar</span>
                </a>
            </div>
            <div class="col-sm-3" style="float: left;">
              <span >Total Sumado </span>
              <input type="text" id="total_dia" class="form-control text-right" disabled value="0">
          </div>
            <div class="col-sm-3" style="float: left;" id="ilegal" >
              <a href="javascript:void(0);"  type="button" class="btn btn-danger btn-icon-split" id="buscar_ilegal" style="font-size: 0.64rem;" onclick="filtrarRegistro();">
                  <span class="icon text-white-50">
                    <i class="fas fa-check"></i>
                  </span>
                  <span class="text"></span>
              </a>
          </div>
        </div>
    </div>
</div>
</div>
  <div id="ocultardos">
      <table class="table table-sm table-striped" id="tabla-venta-elegir">
                <thead>
                  <tr>
                      <th>Tipo de Coprobante</th>
                      <th>Numero de Comprobante</th>
                      <th>Numero Venta</th>
                      <th>Cliente</th>
                      <th>Ruc</th>
                      <th>Total</th>
                      <th>Acciones</th>
                  </tr>
                </thead>
                <tbody id="tbodyid">
                </tbody>
          </table>
  </div>
</div>
{{--  --}}
<style>
#tabla-venta-elegir_filter label input {
  border-radius: 5px;
  height: 80px; 
  float: center;
  font-size: 40px !important;
} 
.btn-factura,
.btn-ticket,
.btn-nota {
    cursor: pointer;
}

.btn-factura {
    float: left;
    text-align: center;
    background: #ff0000;
    color: #fff;
    padding: 15px 0;
}

.btn-factura:hover {
    background: #402b60;
}

.btn-ticket {
    float: left;
    text-align: center;
    background: blue;
    color: #fff;
    padding: 15px 0;
}

.btn-ticket:hover {
    background: #ed5600;
}

.btn-remision {
    float: left;
    text-align: center;
    background: white;
    color: black;
    padding: 15px 0;
}

#btn-remision:hover {
    background: #288c7b;
}
  #ocultar {
    display: none;
  }
  #ocultardos {
    display: none;
  }
  #ilegal {
    display: none;
  }
  .redondo{
              display: block;
              width: 30px;
              height: 30px;
              border-radius: 50%;
              }
</style>

@stop
@section('css')
@section('js')
<script src=" {{ asset('js/comunes.js') }} "></script>
<script>

$( document ).ready(function() {
var productosJson=null;
var personasJson=null;
var autocomplete=null;
var selectJson=null;
});//document ready
jQuery.multipress = function (keys, handler) {
    'use strict';
    if (keys.length === 0) {
        return;
    }
    var down = {};
    jQuery(document).keydown(function (event) {
        down[event.keyCode] = true;
    }).keyup(function (event) {
        var remaining = keys.slice(0),
            pressed = Object.keys(down).map(function (num) { return parseInt(num, 10); }),
            indexOfKey;
        jQuery.each(pressed, function (i, key) {
            if (down[key] === true) {
                down[key] = false;
                indexOfKey = remaining.indexOf(key);
                if (indexOfKey > -1) {
                    remaining.splice(indexOfKey, 1);
                }
            }
        });
        if (remaining.length === 0) {
            handler(event);
        }
    });
};
//--------
function ajustar(tam, num) {
if (num.toString().length <= tam) return ajustar(tam, "0" + num)
else return num;
}

function guardarFactura(){
    var _url = "{{route('admin.vender.facturar')}}";
    var formData = new FormData();
    formData.append( 'id_venta', id_venta_js );
    formData.append( 'cliente', $('#cliente_id').val() );
    formData.append( '_token', '{{ csrf_token() }}');
    postData(_url, formData).then(function(rta){
        console.log(rta);
        if (rta.cod==200) {
            Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Factura Registrada',
            showConfirmButton: false,
            timer: 1500
            })
            var ventana;
            let url= "{{ route('admin.facturar',':id') }}";
            url = url.replace(':id', id_venta_js);
            ventana = window.open(url , '_');
            setTimeout(function(){   ventana.close(); }, 4000);
            location.reload();
        } else {
            Swal.fire({title: "Error", icon: 'warning',html: rta.msg});
        }
    }).catch(function(error){
        console.log('postData dio error'); console.log(error);
        Swal.fire('Ocurrio un Error', error, 'error');
    }) 
}

$("#buscar").click(function(e) {
  e.preventDefault();
  e.stopImmediatePropagation();
  console.log("buscando");
  $("#des_ilegal").css('display','none');
  var desde = $('#fecha_desde').val();
  var hasta = $('#fecha_hasta').val();
  //tenemos que destruir la tabla antes 
  jQuery.fn.dataTable.Api.register( 'sum()', function ( ) {
                return this.flatten().reduce( function ( a, b ) {
                    if ( typeof a === 'string' ) {
                        a = a.replace(/[^\d.-]/g, '') * 1;
                    }
                    if ( typeof b === 'string' ) {
                        b = b.replace(/[^\d.-]/g, '') * 1;
                    }
                    return a + b;
                }, 0 );
            } );
    var table =$('#tabla-venta-elegir').DataTable();
    table.destroy();

  function getFormatGS(num)
      {
              if(!isNaN(num)){
                  num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
                  num = num.split('').reverse().join('').replace(/^[\.]/,'');
                  return num;
              }
              return 0;
      }
  $.ajax({
  type:"GET",
  url: '{!! route("admin.impresion.ventas") !!}',
  type: 'GET',
  data: { desde: desde, hasta: hasta },
    success: function(rta){
    console.log(rta);
        if (rta.cod_retorno > 200) {
          Swal.fire('ATENCION.!',rta.des_retorno, 'error'); 
    }else{
      if (rta.venta.length > 0) {
      var venta=null;
        venta = rta.venta;
      $("#tabla-venta-elegir >tbody").empty();
      $("#tabla-venta-elegir >thead").empty();
        var cabecera="";
        cabecera +=    '<tr>';
        cabecera +=    '<th>Tipo de Coprobante</th>';
        cabecera +=    '<th>Numero de Comprobante</th>';
        cabecera +=    '<th>Numero Venta</th>';
        cabecera +=    '<th>Cliente</th>';
        cabecera +=    '<th>Ruc</th>';
        cabecera +=    '<th>Total</th>';
        cabecera +=    '<th>Acciones</th>';
        cabecera +=    '</tr>';

        $("#tabla-venta-elegir >thead").append(cabecera).promise().done(function(){
                var fila="";
                var tipo="";
              venta.forEach(function callback(ele, index, array) {
               
                fila +='<tr id='+ele.id+'>';
                  tipo="";
                          if (ele.facturas != null) {
                            tipo="factura";
                            fila +=    '<td >Facturas</td>';
                            fila += '<td>';
                              fila += '<table>';
                                  ele.facturas.forEach(function callback(ele_dos, index_dos, array_dos) {
                                    fila += '<tr>';
                                      fila += '<td>'+ajustar(2,ele_dos.sucursal_id)+'-'+ajustar(2,ele_dos.punto_de_venta_id)+'-'+ajustar(2,ele_dos.numero_factura)+'</td>';
                                    fila += '</tr>';
                                  });
                              fila += '</table>';
                            fila +='</td>';
                          }else{
                            tipo="comprobante";

                            fila +=    '<td >Comprobante</td>';

                            fila +=    '<td >'+ele.id+'</td>';
                          }
                          fila +=    '<td >'+ele.id+'</td>'; 

                          fila +=    '<td >'+ele.name+'</td>';

                          fila +=    '<td>'+ele.ruc+'</td>';

                          fila +=    '<td>'+ele.total+'</td>';

                          fila += '<td><div class="btn-group" role="group" aria-label="Basic example">';
                            if (tipo == "factura") {
                              fila +=    '<a type="button" destino="{!!url("/admin/factura/'+ele.id+'")!!}"  class="btn btn-factura">Factura</a>';
                            }else if(tipo == "comprobante"){
                              fila +=    '<a type="button" generar="{!!url("admin/impresion/ventas/timbrado/'+ele.id+'")!!}" venta="'+ele.id+'" class="btn btn-factura">Generar Factura</a>';
                            }
                          fila +='</div></td>';
                fila +="</tr>";

              });
                $("#tabla-venta-elegir >tbody").append(fila).promise().done(function(){
                  $("#des_ilegal").attr('disabled',false);
                  $('#ocultardos').css('display','block');  
                      var table = $('#tabla-venta-elegir').DataTable({
                    initComplete: function () {
                      $('#tabla-venta-elegir_filter label input').focus();
                      $("#des_ilegal").css('display','block');
                    },
                    drawCallback: function() {
                    var api = this.api();
                    var bruto_ser = api.column(5).data().sum();
                    $('#total_dia').val(getFormatGS(bruto_ser))

                },
                  });
                });
        });
      }else{
        Swal.fire('Oops.!','No existen registros en estas fechas', 'warning'); 
        $("#des_ilegal").css('display','block');
        $("#tabla-venta-elegir >tbody").empty();
        $("#tabla-venta-elegir >thead").empty();
        $('#total_dia').val(getFormatGS(0))
      }
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
});
$('tbody').on('click', 'a',function(){
    if ($(this).attr('destino')) {
        var url= $(this).attr('destino');
        Swal.fire({
        title: 'Estas Seguro de imprimir nueva mente estas facturas?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si,Imprimir ya!'
    }).then((result) => {
      if (result.isConfirmed) {
        setTimeout(function () { 
                Swal.fire("El Documento se esta imprimiendo!","Espere a su impresora por favor", 'success'); 
                $('.confirm').focus(); 
              }, 200);
              var ventana;
              ventana=window.open(url, '_blank'); 
      }
    })
  }else if ($(this).attr('generar')) {
    var url= $(this).attr('generar');
    var venta= $(this).attr('venta');
    Swal.fire({
      title: "Proporcione un Ruc, y Espere mientras se confirma los numeros de factura",
      input: 'text',
      inputAttributes: { autocapitalize: 'off' },
      showCancelButton: true,
      confirmButtonText: 'Buscar',
      showLoaderOnConfirm: true,
      allowOutsideClick: () => !Swal.isLoading()
      }).then((result) => {
      if (result.isConfirmed) {
        if (result.value != "") {
          url=url+'/'+result.value;
              getData(url).then(function(rta){
                    if(rta.cod == 200){
                      cargar_facturas(rta.facturas,venta,rta.cliente);
                    }else{
                      Swal.fire('Oops.!',rta.msg, 'error'); 
                    }
              }).catch(function(error){
                console.log('getData dio error'); console.log(error);
                Swal.fire('Ocurrio un Error', error.message, 'error');
              });
        }else{
          Swal.fire({ title: `Debe Proporcionar un Ruc  para la factura!`})
        }
      }
    })

  }
})
function cargar_facturas(facturas,url,cliente){
  Swal.fire({
        title: "Estas son las facturas que se generan para el cliente: "+cliente.name+" con Ruc: "+cliente.ruc+" consulte si corresponden al cliente, ;) !",
        text: facturas,
        icon: 'warning',
        showCancelButton: true,
        showDenyButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Generar Factura Simple!',
        cancelButtonText: 'Cancelar',
        denyButtonText: 'Generar Factura Detallada',
    }).then((result) => {
      if (result.isConfirmed) {
              console.log("factura Simple")
              enviarGuardar('false',cliente,url)
      } else if (result.isDenied) {
          console.log('factura detallada');
          enviarGuardar('true',cliente,url)
      } else if (result.isDismissed) {
          console.log("modal cerrado") 
      } else if(result.cancel){
          console.log("cancelado")
      }
    })
}
  function enviarGuardar(tipo,cliente,url){
    var formData = new FormData();
    formData.append( '_token', '{{ csrf_token() }}');
    formData.append( 'cliente_id', cliente.id );
    formData.append( 'factura_detallada', tipo);
    formData.append( 'venta_id', url );
    var ur= '{{route("admin.impresion.facturar")}}';
    postData(ur, formData).then(function(rta){
      toastr.options = { "closeButton": true };
      let le= "{{ route('admin.facturar',':id') }}";
      le = le.replace(':id', url);
      var ventana;
      ventana=window.open(le, '_blank'); 
      setTimeout(function(){   ventana.close(); }, 4000);
      location.reload();
    }).catch(function(error){
        console.log('postData dio error'); console.log(error);
        Swal.fire('Ocurrio un Error', error.message, 'error');
    });
    
  }
</script>
@stop