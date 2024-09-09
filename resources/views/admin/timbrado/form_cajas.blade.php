@extends('adminlte::page')

@section('title', 'Agendas')


@section('content_header')

@stop

@section('content')

<div id='errores' style='display:none' class='alert alert-danger'></div>
<div id='success' style='display:none' class='alert alert-success'></div>
<div class="breadcrumb-holder">
  <ul class="breadcrumb" style="background-color: transparent; padding-top: 0; padding-bottom: 0;">
    <li class="breadcrumb-item"><a href="/admin">Home</a></li>
    <li class="breadcrumb-item active">Timbrado</li>
  </ul>
</div>

<form id="form_timbrado">
  <div class="col-sm-3" style="float: left;">
    <div class="card shadow mb-4">
      <div class="card-header py-3" style="padding: 5px 10px 5px 10px !important;">
        Timbrado
      </div>
      <input type="hidden" id="timbrado_id" name="timbrado_id" value="{{$foo['timbrado']->id}}">
      <div class="card-body">
        <div class="form-group">
          <label style="margin-bottom: 0;">Número de timbrado</label>
          <input id="nro_timbrado" name="nro_timbrado" type="text" class="mr-3 form-control form-control-sm"
            value="{{$foo['timbrado']->numero_timbrado}}">
        </div>

        <div class="form-group">
          <label style="margin-bottom: 0;">Fecha desde</label>
          <input id="fecha_desde_timbrado" name="fecha_desde_timbrado" type="date"
            class="mr-3 form-control form-control-sm" value="{{$foo['timbrado']->fecha_ini_vigencia}}">
        </div>

        <div class="form-group">
          <label style="margin-bottom: 0;">Fecha hasta</label>
          <input id="fecha_hasta_timbrado" name="fecha_hasta_timbrado" type="date"
            class="mr-3 form-control form-control-sm" value="{{$foo['timbrado']->fecha_fin_vigencia}}">
        </div>
        <div class="form-group">
          <label style="margin-bottom: 0;">Para que es la factura?</label>
          <select id="tipo_factura" name="tipo_factura" class="form-control form-control-sm">
            @if (isset($foo['punto_venta']))
            @foreach ($foo['punto_venta'] as $sucursal)
            @if ($sucursal->tipo_factura == 'fc')
            <option value="fc" selected>Facturas</option>
            <option value="nc">Notas de credito</option>
            @else
            <option value="fc">Facturas</option>
            <option value="nc" selected>Notas de credito</option>
            @endif
            @endforeach
            @else
            <option value="fc">Facturas</option>
            <option value="nc">Notas de credito</option>
            @endif
          </select>
        </div>
        <div class="form-group">
          <label style="margin-bottom: 0;">Sucursal </label>
          <select id="sucursal_timbrado" name="sucursal_timbrado" class="form-control form-control-sm">
            <option value="">seleccione la sucursal</option>
              @if (isset($foo['punto_venta']))
                  @foreach ($foo['punto_venta'] as $sucursal)
                    <option class="especial" value="{{$sucursal->id}}" selected>{{$sucursal->sucursal}}</option>
                  @endforeach
              @else
                  @foreach ($foo['sucursales'] as $sucursal)
                    <option value="{{$sucursal->id}}">{{$sucursal->name}}</option>
                  @endforeach
              @endif
          </select>
        </div>

        @if (isset($foo['editar']))
        <div class="form-group">
          <label style="margin-bottom: 0;">Factura desde</label>
          <input id="factura_desde_timbrado" name="factura_desde_timbrado" type="number" class="mr-3 form-control form-control-sm"
            value="{{$foo['punto_venta'][0]->factura_desde}}">
        </div>
        <div class="form-group">
          <label style="margin-bottom: 0;">Factura hasta</label>
          <input id="factura_hasta_timbrado" name="factura_hasta_timbrado" type="number" class="mr-3 form-control form-control-sm"
            value="{{$foo['punto_venta'][0]->factura_hasta}}">
        </div>
        <div class="form-group">
          <label style="margin-bottom: 0;">Numero Actual</label>
          <input id="factura_actual_timbrado" name="factura_actual_timbrado" type="number" class="mr-3 form-control form-control-sm"
            value="{{$foo['punto_venta'][0]->factura_actual}}">
        </div>
        @else
        <div class="form-group">
          <label style="margin-bottom: 0;">Factura desde</label>
          <input id="factura_desde_timbrado" name="factura_desde_timbrado" type="number" class="mr-3 form-control form-control-sm">
        </div>

        <div class="form-group">
          <label style="margin-bottom: 0;">Factura hasta</label>
          <input id="factura_hasta_timbrado" name="factura_hasta_timbrado" type="number" class="mr-3 form-control form-control-sm">
        </div>
        <div class="form-group">
          <label style="margin-bottom: 0;">Numero Actual</label>
          <input id="factura_actual_timbrado" name="factura_actual_timbrado" type="number" class="mr-3 form-control form-control-sm">
        </div>
        @endif
        <div class="form-group">
          <label style="margin-bottom: 0;">Caja No.</label>
          <select id="caja_timbrado" name="caja_timbrado" class="form-control form-control-sm">
            @if (isset($foo['punto_venta']))
            @foreach ($foo['punto_venta'] as $caja)
            <option value="{{$caja->id_caja}}" selected>{{$caja->caja}}</option>
            @endforeach
            @endif
          </select>
        </div>
      </div>
      <div class="card-footer">
        @if (isset($foo['punto_venta']))
        <button class="mr-3 btn btn-primary" id="guardar_volver">Guardar y Volver</button>
        <button class="mr-3 btn btn-primary" id="guardar" disabled>Agregar</button>
        @else
        <button class="mr-3 btn btn-primary" id="guardar" >Agregar</button>
        @endif

      </div>
    </div>
  </div>
</form>

<form id="form_prueva">

</form>
<div class="col-sm-9" style="float: left;">
  <div class="card shadow mb-4">
    <div class="card-header py-3" style="padding: 5px 10px 5px 10px !important;">

    </div>

    <div class="card-body">
      <div class="table-responsive">
        <table class="table" id="tabla">
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.css">
@stop

@section('js')
<script src=" {{ asset('js/comunes.js') }} "></script>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/locales-all.js"></script>

<script>
$( document ).ready(function() {
  var data = {
      table: "tabla",
      ajax :  {
        "url": "{{ route('admin.timbrados.datatable') }}",
        "data":{'timbrado':$('#timbrado_id').val()} 
       },
      topMsg: "",
      filename: "Listado de Timbrados",
      columns: [
          {data: 'timbrado', name: 'timbrado', title:'Timbrado'},
          {data: 'sucursal', name: 'sucursal', title:'Sucursal'},
          {data: 'punto_venta', name: 'punto_venta', title:'Punto de Venta'},
          {data: 'inicio', name: 'inicio', title:'Inicio'},
          {data: 'fin', name: 'fin', title:'Fin'},
          {data: 'desde', name: 'desde', title:'Desde'},
          {data: 'hasta', name: 'hasta', title:'Hasta'},
          {data: 'factura_actual', name: 'factura_actual', title:'Numero Actual'},
          {data: 'acciones', name: 'acciones', orderable: false, searchable: false, class: 'noexport'}
      ]
  };
  toDataTable(data);

$("#sucursal_timbrado").change(function(){
  if (this.value){
    var ruta ="{{route('admin.timbrados.sucursales')}}"+'?sucursal_id='+this.value;
    getData(ruta).then(function(rta){
      $('#caja_timbrado option').remove().promise().done(function(){
        $.each(rta, function(i, item) {
          $("#caja_timbrado").append("<option value="+item.id+">"+item.name+"</option>");
        });
      });
    }).catch(function(error){
        console.log('getData dio error'); console.log(error);
        Swal.fire('Ocurrio un Error', error.message, 'error');
    });
  }else{
    $('#caja_timbrado option').remove();
  }
});


$("#guardar").click(function(e){
e.preventDefault();
var formData = new FormData($('#form_timbrado')[0]);
formData.append( '_token', '{{ csrf_token() }}');
var ruta = "{{ route('admin.timbrados.save') }}";
postData(ruta, formData).then(function(rta){
    if (rta.cod ==200) {
          toastr.options = { "closeButton": true, };
          toastr.success(rta['msg'], 'Buen Trabajo!');
          var _url = "{{ route('admin.timbrados.get_data') }}" + '?timbrado='+rta.tim_id;
          setTimeout(function(){
            window.location.href = _url},1000) 
          console.log(_url)
    }
  }).catch(function(error){
      console.log('postData dio error'); console.log(error);
      Swal.fire('Ocurrio un Error', error, 'error');
  })
});
$("#guardar_volver").click(function(e){
  e.preventDefault()
  $("#guardar").trigger("click");
});
});//fin  del jq
</script>
@stop