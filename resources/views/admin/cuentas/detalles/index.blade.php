@extends('adminlte::page')

@section('title', 'Agendas')


@section('content_header')

@stop

@section('content')

{{-- <input type="hidden" id="evento" value="{{$evento}}"> --}}
<input type="hidden" id="venta" value="{{$venta}}">
<input type="hidden" id="fecha" value="{{$events->fecha}}">
 @include('admin.cuentas.detalles.filtro')
 @include('admin.cuentas.detalles.detalles')
 {{-- incluimos liveware para no recargar mas --}}
 <div>
  
    @livewire('admin.cliente-deudas',['venta' => $venta])
</div>
<br>
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
  //datatable resumen
    let url= "{{ route('admin.cuenta.cliente.eventosDetallesResumen',':id') }}";
    url = url.replace(':id', $('#venta').val());
        var data = {
            table: "tablaCrudResumen",
            ajax : url,
            topMsg: "",
            footerMsg: "Generado: {{ auth()->user()->name }} {{ date("d/m/Y H:i") }}",
            filename: "Listado de cuentas totales",
            title: 'Listado',
            datos: {'cliente': $('#cliente_id').val()},
            columns: [
                {data: 'articulo', name: 'articulo'},
                {data: 'precio_total', name: 'precio_total', 'defaultContent': ''},
                {data: 'cantidad', name: 'cantidad', 'defaultContent': ''},
                {data: 'colaborador', name: 'colaborador', 'defaultContent': ''},
                {data: 'colaborador', name: 'colaborador', 'defaultContent': ''},
                {data: 'colaborador', name: 'colaborador', className : "text-right", 'defaultContent': ''},
                {data: 'acciones', name: 'acciones', className : "text-right", 'defaultContent': ''},
            ]
        };
        toDataTableSimple(data);
})//ready

@php
      echo "var servicios_ac = ".json_encode($servicios)."; ";
      echo "var articulos_ac = ".json_encode($articulos)."; ";
@endphp

// servicios
$('#formCrudModal #articulo').on('change', function(){
      var id = $(this).val();
      if( id != 'null' ){
        var ele = servicios_ac.find( item => item.id == id  );
        var dt = new Date(); var time = dt.getHours() + ":" + dt.getMinutes();
        var time = dt.getHours() + ":" + dt.getMinutes();
        $('#formCrudModal #ini_show').val(time);
        sumHours(time,ele.end,'#formCrudModal #ini_show','#formCrudModal #fin_show','#formCrudModal #duracion_show')
      }else{
          console.log('vacio');
      }
});
$('#formCrudModal #ini_show').on('change', function(){
      var id = $('#formCrudModal #articulo').val();
      if( id != 'null' ){
        var ele = servicios_ac.find( item => item.id == id  );
        sumHours($(this).val(),ele.end,'#formCrudModal #ini_show','#formCrudModal #fin_show','#formCrudModal #duracion_show')
      }else{
        $('#formCrudModal #articulo').focus();
          console.log('vacio');
      }
});

function agregraDetalle(){
  if (reglas()) {
    console.log($('#formCrudModal #ini_show').val())
    console.log($('#formCrudModal #fin_show').val())
          var _url = "{{route('admin.cuenta.reserva.verificar')}}";
          var ele = servicios_ac.find( item => item.id == $('#formCrudModal #articulo').val()  );
          var formData = new FormData();
          formData.append( 'fecha', $('#fecha').val() );
          formData.append( 'desde', $('#formCrudModal #ini_show').val());
          formData.append( 'hasta', $('#formCrudModal #fin_show').val());
          formData.append( 'colaborador', $('#formCrudModal #colaborador').val() );
          formData.append( 'servicio', $('#formCrudModal #articulo').val() );
          // formData.append( 'evento_id', $('#evento').val() );
          formData.append( 'venta_id', $('#venta').val() );
          formData.append( 'precio_actual', ele.precio);
          formData.append( '_token', '{{ csrf_token() }}');
          postData(_url, formData).then(function(rta){
          if (rta.dat == null ) {
              //debemos recargar el datatable y el liveware
              reset()
              toastr.success(rta['msg'], 'Buen Trabajo!');
              $('#tablaCrudResumen').DataTable().ajax.reload();
              Livewire.emitTo('admin.cliente-deudas','recarge')
          }else{
            toadErrores("Error este colaborador ya tiene una cita asignada en ese horario")
          }

        }).catch(function(error){
            console.log('postData dio error'); console.log(error);
            Swal.fire('Ocurrio un Error', error, 'error');
        })
    } 
}
function reglas(){
  if (($('#formCrudModal #colaborador').val() == 'null')){
    toadErrores('Necesita seleccionar un colaborador')
    return false;
  }else if(($('#formCrudModal #articulo').val() == 'null')){
    toadErrores('Necesita seleccionar un servicio')
    return false;
  }else if($('#formCrudModal #ini_show').length === 0 ){
    toadErrores('Necesita seleccionar un Horario i')
    return false;
  }else if(($('#formCrudModal #fin_show').length === 0 )){
    toadErrores('Necesita seleccionar un Horario f')
    return false;
  }
  else{
    return true
  }
}
function reset(){
  $('#formCrudModal #ini_show').val("");
  $('#formCrudModal #fin_show').val("");
  $('#formCrudModal #duracion_show').val("");
  $('#formCrudModal #articulo').val('null');
  $('#formCrudModal #articulo').trigger('change'); 
  $('#formCrudModal #colaborador').val('null');
  $('#formCrudModal #colaborador').trigger('change')
}
//productos
$('#formCrudModal #producto_id').on('change', function(){
      var id = $(this).val();
      if( id != 'null' ){
        var ele = articulos_ac.find( item => item.id == id  );
      }else{
          console.log('vacio');
      }
});
function agregraDetalleProducto(){
  if (reglasPro()) {
    //me quede aqui
          var _url = "{{route('admin.cuenta.producto.verificar')}}";
          var ele = articulos_ac.find( item => item.id == $('#formCrudModal #producto_id').val()  );
          var formData = new FormData();
          formData.append( 'producto', $('#formCrudModal #producto_id').val() );
          formData.append( 'cantidad', $('#formCrudModal #cantidad_pro').val() );
          formData.append( 'deposito', $('#formCrudModal #deposito_id').val() );
          // formData.append( 'evento_id', $('#evento').val() );
          formData.append( 'precio_actual', ele.precio);
          formData.append( 'venta_id', $('#venta').val() );
          formData.append( '_token', '{{ csrf_token() }}');
          postData(_url, formData).then(function(rta){
              toastr.success(rta['msg'], 'Buen Trabajo!');
              $('#tablaCrudResumen').DataTable().ajax.reload();
              Livewire.emitTo('admin.cliente-deudas','recarge')

        }).catch(function(error){
            console.log('postData dio error'); console.log(error);
            Swal.fire('Ocurrio un Error', error.msg, 'error');
        })
    } 
}
function reglasPro(){
  if (($('#formCrudModal #producto_id').val() == 'null')){
    toadErrores('Necesita seleccionar Producto')
    return false;
  }else if(($('#formCrudModal #deposito_id').val() == 'null')){
    toadErrores('Necesita seleccionar un Deposito')
    return false;
  }else if($('#formCrudModal #cantidad_pro').val() < 0 ){
    toadErrores('Necesita seleccionar una Cantidad')
    return false;
  }else{
    return true
  }
}


</script>

@stop