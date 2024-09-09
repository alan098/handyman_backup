@extends('adminlte::page')
@section('title', 'Agendas')

@section('content_header')
@stop

@section('content')
<div>
  @include('admin.calendar_colaboradores.modalrecord')
  <div class="card mb-0" >
     <div class="card-header">
            <x-cabecera>
                <x-slot name='title'>
                    Colaboradores
                </x-slot>
                <x-slot name='subtitle'>
                    Elija alguno de estos filtros para visualizar la informacion que desea
                </x-slot>
            </x-cabecera>
        </div>
    <div class="card-body">
      <div class="form-row mb-1">
        <div class="col-2">
            <x-jet-label value="Sucursal" />
        </div>
        <div class="col-4">
            <select name="sucursales" class="form-control" style="width: 100%" id="sucursal_cha">
                @foreach ($sucursales as $suc)
                @if ($suc->id == Auth()->user()->sucursal_id)
                 <option value="{{$suc->id}}" selected> {{$suc->name}}</option>
                @else
                @role('agenda')
                    <option value="{{$suc->id}}" > {{$suc->name}}</option>
                @endrole
                @endif
                @endforeach
            </select>
            <input type="hidden">
            <x-jet-input-error for="titulo" />
        </div>
    </div>
  </div>
</div>
 
</div>
<div>
  @livewire('admin.show-eventos')
</div>
 {{-- modales automaticos --}}
 <input type="hidden" id="sucursal_id" value="{{Auth()->user()->sucursal_id}}">
 <input type="hidden" id="colaborador_id">
 @include('admin.calendar_colaboradores.modalreserva')
 @include('admin.calendar_colaboradores.modaleditar')
<br>
@stop
{{-- @section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop --}}
@section('js')
<script src=" {{ asset('js/comunes.js') }} "></script>
<script>
  
$( document ).ready(function() {


  $('.select2').select2({
      dropdownParent: $('#formCrudModal')
  }).trigger('change');
    @php
        echo "var servicios_ac = ".json_encode($servicios)."; ";
        echo "var colaborador_js = ".json_encode($colaboradores)."; ";
    @endphp
  $('.js-data-clientes-ajax').select2({
    minimumInputLength: 2,
    minimumResultsForSearch: 10,
    dropdownParent: $('#formCrudModal'),
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
})//ready
@php
        echo "var servicios_ac = ".json_encode($servicios)."; ";
        echo "var colaborador_js = ".json_encode($colaboradores)."; ";
@endphp

var id_recordatorio="";
const Item_recorda = ({ name,cliente,RUC,servicio_base,mensaje }) => `
  <div class="form-row">
          <div class="col">
            <x-jet-label value="${cliente}"/>
          </div>
          <div class="col">
            <x-jet-label value="${RUC}"/>
          </div>
          <div class="col">
            <x-jet-label value="${servicio_base}"/>
          </div>
          <div class="col">
            <x-jet-label value="${mensaje}"/>
          </div>
        </div>
      </hr>
  `;

@if (Auth::user()) 
$(function() {
    setInterval(function checkSession() {
        console.log("preguntamos cada 30 minutos si hay recordatorios o cumpleaños")
        $.get("{{route('admin.recordatorios.data')}}", function(data) {
          if (data.deta.length > 0) {//solo si existe data enseñamos
            id_recordatorio=data.ids
            // vaciamos
            $('#recordatorios').empty().promise().done(function(){
              data.deta.forEach(function callback(ele,key) {
                   $('#recordatorios').append( [ele].map(Item_recorda).join(''));
                  $('#modal_record').modal('show');
              })
            })
          }
          if (data.cumple.length > 0) {//solo si existe cumpleaños tambien
            $('#item_cumple').empty().promise().done(function(){
              data.cumple.forEach(function callback(ele,key) {
                   $('#item_cumple').append( [ele].map(Item_recorda).join(''));
                  $('#modal_record').modal('show');
              })
            })
          }

        });
    }, 1800000); // treita minutos
});
@endif
function vistear(){
  if (id_recordatorio.length > 0 || $('#item_cumple').length > 0 ) {
      var _url = "{{route('admin.recordatorios.vistear')}}";
      var formData = new FormData();
      formData.append( 'ids',JSON.stringify(id_recordatorio) );
      formData.append( '_token', '{{ csrf_token() }}');
      postData(_url, formData).then(function(rta){
        if (rta.cod == 200) {
          $('#modal_record').modal('hide');
            toastr.options = { "closeButton": true, };
            toastr.success(rta['msg'], 'Actualizado!');
        }
      }).catch(function(error){
          console.log('postData dio error'); 
          Swal.fire('Ocurrio un Error', error.message, 'error');
      })
  }else{
    Swal.fire('Ocurrio un Error', "comuniquese con soporte y mantenimiento", 'error');
  }
}

  //vaciamos antes de nada
  //este solo se utiliza para renderizar al principio
  Livewire.on('renderCalendar',colaboradorId =>{

       var id='agenda_numero_'+colaboradorId[0];
       insertarFullcalendar(id,colaboradorId[0]);
  })
  Livewire.on('cargarCol',colaboradorId =>{
      rellenarColaboradores()
  })
  Livewire.on('recargarmarcados',colaboradorId =>{
    checkearNuevamente()
  })
$('#estados').on('change', function(){
    $('#estados_color').css('background-color' , $(this).val().split('-')[1]);
});
  const Item = ({ id,name }) => `
    <div class="columna_colaborador_${id} columna_colaborador col-4"  >
        <div class="form-row">
            <div class="col-4"></div>
            <div class="col-4">
                <h4>
                    <strong>${name}</strong>
                </h4>
                <div class="col-4"></div>
            </div>
            <div id="agenda_numero_${id}" colaborador="${id}" cliente=""></div>
        </div>
    </div>
  `;

  $('#sucursal_cha').on('change', function(){
      var _url = "{{route('admin.calendario.colaboradores.cambio')}}";
      var formData = new FormData();
      formData.append( 'sucursal_id', $('#sucursal_cha').val() );
      formData.append( '_token', '{{ csrf_token() }}');
      postData(_url, formData).then(function(rta){
        if (rta.cod == 200) {
          $('#sucursal_id').val($('#sucursal_cha').val());
          Livewire.emit('sucursal_change',$('#sucursal_cha').val())
        }
      }).catch(function(error){
          console.log('postData dio error'); 
          console.log(error);
          Swal.fire('Ocurrio un Error', error.message, 'error');
      })
  })
  function insertarFullcalendar(id,colaborador){
                var fecha=$('#fecha_principal').val();
                var calendarEl = document.getElementById(id);
                var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridDay',
                headerToolbar: {
                  left: 'prev,next,today',
                  center: 'title',
                  right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
              },
                locale: "es",
                editable: false,
                themeSystem: 'bootstrap',
                slotMinTime: "08:00:00",
                slotMaxTime: "21:00:00",
                slotDuration: '00:10:00',
                allDaySlot: false,
                slotLabelFormat:{
                  hour: '2-digit',
                  minute: '2-digit',
                  omitZeroMinute: false,
                  meridiem: 'short'
                },
                nowIndicator: true,
                slotLabelInterval : '00:15:00',
                contentHeight:"auto",
                headerToolbar: false,
                dateClick:function(info){
                  var col=$(this)[0]['el']['attributes'][1].value;
                  comprobarBloqueo(info.dateStr,col)
                  limpiarModal(col)
                  addFechaModal('start',info.dateStr,'formCrudModal')
                  addFechaModal('end',info.dateStr,'formCrudModal')     
                },
                eventClick: function(info){
                  populateModalEdit(info.event.id)
                },
                events:"{{ url('admin/calendario/colaboradores/datos') }}"+`/${colaborador}`+`/${fecha}`,
              });
            calendar.render()
            calendar.gotoDate( fecha )
          // $('#id_calendar .scroll').css({ 
          //   'overflow-x': 'auto', 
          //   'white-space': 'nowrap',
          // });
  }
function comprobarBloqueo(hora,colaborador){
  var ts = new Date(hora);
  fecha=ts.toUTCString(); 
  fecha=fecha.split(',')[0];
  datetext = ts.toTimeString();
  datetext = datetext.split(' ')[0];
  let url= "{{ route('admin.fechear') }}"+"?hora="+datetext+"&colaborador_id="+colaborador+"&dia="+fecha;
  getData(url).then(function(rta){
    if (rta.cod == 200) {
      $('#formCrudModal').modal('show');
    }else{
      toastr.options = { "closeButton": true, };
      toastr.error("Colaborador con Horario Bloqueado",'');
    }
      console.log(rta);
  }).catch(function(error){
  });
}
function limpiarModal(col){
  $('#formCrudModal').trigger('reset');
  $('#formCrud #persona').val('')
  $('#formCrud #persona').trigger('change')
  $('#formCrud #text_area').val('')
  $("#formCrudModal #id-total").html(0);
  $("#formCrudModal #id-tiempo-total").text(0);
  $('#formCrudModal #sucursal').val($('#sucursal_id').val());
  $('#formCrudModal #fecha').val($('#fecha_principal').val());
  $('#formCrudModal #sucursal').trigger('change'); 
  $('#formCrudModal #colaborador').val(col);
  $('#formCrudModal #colaborador').trigger('change')
  $('#formCrudModal #ini_show').val("");
  $('#formCrudModal #fin_show').val("");
  $('#formCrudModal #duracion_show').val("");
  $('#formCrudModal #articulo').val('null');
  $('#formCrudModal #tabla-lista tbody').empty();
  $('#formCrudModal #articulo').trigger('change'); 
}
  function populateModalEdit(id){
    let url= "{{ route('admin.calendario.colaboradores.edit',':id') }}";
    url = url.replace(':id', id);
        getData(url).then(function(rta){
          //fehas
          if (rta[2]) { $('#edit_fecha').prop('readOnly', true); } else { $('#edit_fecha').prop('readOnly', false); }
          // cantidad de reservas
          $('#label_cantidad').html('Esta reserva consta de '+rta[1][0].eventos+' servicio/s');
          //lo demas
          populateForm('edit_formCrud', JSON.parse( rta[0] ) ,1);
          var pars=JSON.parse( rta[0] )

          $('#edit_formCrud #edit_colaborador').val(pars.edit_colaborador_id);
          $('#edit_formCrud #id_col_default').val(pars.edit_colaborador_id);
          $('#edit_formCrud #id_detalle').val(pars.edit_detalle_id);
          $('#edit_formCrud #edit_articulo').val(pars.edit_articulo_id);
          //colocamos el horario manualmente porque o sino no funca
          $('#edit_formCrud #edit_ini_show').val(pars.edit_ini_show);
          $('#edit_formCrud #edit_fin_show').val(pars.edit_fin_show);
          if(pars.sin_prefe){
            $('#edit_formCrud #con_prefe_edit').attr('checked',true)
          }else{
            $('#edit_formCrud #sin_prefe_edit').attr('checked',true)
          }

          
         

          if (pars.edit_venta_id == null) { //solo permitiremos cambiar si no existe ya una venta
            $('#edit_formCrud #edit_fecha').prop('readonly', false);
            $('#edit_formCrud #edit_sucursal').attr('readonly', false);
            $('#edit_formCrud #edit_colaborador').attr('readonly', false);
            $('#edit_formCrud #edit_ini_show').prop('readonly', false);
            $('#edit_formCrud #edit_fin_show').prop('readonly', false); 
            $('#edit_articulo').select2({ dropdownParent: $('#evento_edit')}).trigger('change');            
          }else{
            $('#edit_formCrud #edit_fecha').prop('readonly', true);
            $('#edit_formCrud #edit_sucursal').attr('readonly', true);
            $('#edit_formCrud #edit_colaborador').attr('readonly', true);
            $('#edit_formCrud #edit_ini_show').prop('readonly', true);
            $('#edit_formCrud #edit_fin_show').prop('readonly', true); 
            $('#edit_articulo').select2({ dropdownParent: $('#nullos')}).trigger('change'); 
          }

          $('#edit_formCrud #id_reserva').val(pars.id_reserva);
          $('#edit_formCrud #estados').val(pars.estado_id+"-"+pars.color)
          if ( $.inArray(pars.estado_id,[4,5,6]) > -1 ) {
            $('#id_delete_reserve').attr('disabled',true)
          }else{
            $('#id_delete_reserve').attr('disabled',false)
          }
          $('#evento_edit').modal('show');

        }).catch(function(error){
            console.log('populate dio error'); console.log(error);
            Swal.fire('Ocurrio un Error', error.message, 'error');
    });
  }
  $('#edit_articulo').on('change', function(){
    //preguntamos si el modal esta abierto o sino no hacemos nada
    if ($('#evento_edit').is(':visible')) {
      console.log("visible")

      var id = $(this).val();
      if( id != 'null' ){
          var ele = servicios_ac.find( item => item.id == id  );
          console.log(ele)
          sumHours($('#edit_ini_show').val(),ele.end,'#edit_fin_show','#edit_fin_show','#edit_duracion_show')
          sumHours($('#edit_ini_show').val(),ele.end,'#edit_fin_show','#edit_fin_show','#edit_id_tiempo_total')
          $('#edit_precio').val(ele.precio);
          $('#edit_id-total').val(ele.precio);
      }else{
          console.log('empty');
      }
    }
  })
  $('#edit_ini_show').on('change', function(){
    //preguntamos si el modal esta abierto o sino no hacemos nada
    if ($('#evento_edit').is(':visible')) {
      console.log("visible")
      var id =  $('#edit_articulo').val();
      if( id != 'null' ){
          var ele = servicios_ac.find( item => item.id == id  );
          sumHours($('#edit_ini_show').val(),ele.end,'#edit_fin_show','#edit_fin_show','#edit_duracion_show')
          sumHours($('#edit_ini_show').val(),ele.end,'#edit_fin_show','#edit_fin_show','#edit_id_tiempo_total')
      }else{
          console.log('empty');
      }
    }
  })

function rulesEdit(){
  if (($('#edit_formCrud #colaborador').val() == 'null')){
    toadErrores('Necesita seleccionar un colaborador')
    return false;
  }else if(($('#edit_formCrud #articulo').val() == 'null')){
    toadErrores('Necesita seleccionar un servicio')
    return false;
  }else if($('#edit_formCrud #edit_ini_show').val().length == 0){
    toadErrores('Necesita seleccionar un horario de inicio')
    return false;
  }else if($('#edit_formCrud #edit_fin_show').val().length == 0){
    toadErrores('Necesita seleccionar un horario de fin')
    return false;
  }else{
    return true
  }
}
function colaborador_add(id){
  const num =id.value
  if (num) {
    if (!$('.columna_colaborador_'+num).length > 0) {
      var deta = colaborador_js.find( item => item.id == id.value);
      const name=deta.name;
      var ele = {id: num,name: name}
      $('#calendar_map').append( [ele].map(Item).join(''));
      var id='agenda_numero_'+num;
      insertarFullcalendar(id,num);
    }else{
      // toadErrores('ESTE COLABORADOR YA EXISTE!')
    }
    
  }
  
}
var marcados=[];
function desIncluir(id){ //esto es solo para los que no tiene eventos en el dia
  if (!$(id).prop('checked')) {
    $('.columna_colaborador_'+id.value).remove();
      marcados= jQuery.grep(marcados, function(value) {
        return value != id.value;
      });
  }else{     
      var id={'value':id.value }
      colaborador_add(id);
      marcados=$.merge([id.value], marcados)
  }
}
function checkearNuevamente(){
  rellenarColaboradores();
  marcados.map(function(x) {
    var id={'value':x }
    colaborador_add(id);
    $('.marcar_'+x).prop('checked',true);
  })
  
 


}
function rellenarColaboradores(){
  //removemos luego insertamos
  $('.elim_rem').remove().promise().done(function(){
      var filaini="<div class='col elim_rem'>";
    var filafin="</div>";
    var filaCont="";
    cantidad=0
    colaborador_js.forEach(function callback(ele, index, array) {
      if ($('.marcados_'+ele.id).length == 0  ) {
          if (cantidad==0){ filaCont+=filaini }
          filaCont+='<div class="form-check">';
          filaCont+='<input class="form-check-input marcar_'+ele.id+'" type="checkbox" name="gridRadios" value="'+ele.id+'"  onchange="desIncluir(this);">'
          filaCont+='<label class="form-check-label" for="gridRadios1">'+ele.name;
          filaCont+='</label>'
          filaCont+='</div>'
          cantidad++;
        if (cantidad == 3) { filaCont+=filafin; cantidad=0; } 
      }
    })
    $('#seccion_sin_eventos').append(filaCont); 
    setTimeout(function(){$("#aplicar_promo").val('no')
    $('#seccion_sin_eventos input').each(function(e,data) {
      if (!$(this).prop('checked')) {
        $(this).prop('checked',true)
        $(this).trigger('change')
      }
     })
    },1500);
  
    });
}


// function sucursal_change(id){
//   $('#sucursal_id').val(id.value);
//   Livewire.emit('sucursal_change',id.value)
// }
@php
      echo "var servicios_ac = ".json_encode($servicios)."; ";
@endphp

const Servicioo = ({ id,name,precio,colName,colId,hor_ini,hor_fin,duracion}) => 
  ` <tr id="tr_${id}">
        <td>
          <input size="3" type="hidden" name="articulos[${id}][id]"  value="${id}">
          <input size="3" type="hidden" name="articulos[${id}][colaborador_id]"  value="${colId}">
          <input size="3" type="hidden" name="articulos[${id}][precio_actual]"  value="${precio}">

          <input size="3" type="hidden" name="articulos[${id}][start]"  value="${hor_ini}">
          <input size="3" type="hidden" name="articulos[${id}][end]"    value="${hor_fin}">

          <button class="btn btn-secondary" type="button" disabled><i class="fa fa-shopping-bag" aria-hidden="true"></i></button>
        </td>
        <td>${name}</td>
        <td>
            ${colName}
        </td>
        <td align="right" id="tr_${id}_td" ini="${hor_ini}" fin="${hor_fin}" dura="${duracion}" precio="${precio}">
                <p>${hor_ini} - ${hor_fin}</p>
                <p>Duración: ${duracion}</p>
        </td>
        <td align="right"> 
                ${precio}
        </td>
        <td>
            <a class="btn btn-danger btn-sm" role="button" onclick="eliminarProducto(${id})"> <i class="fa fa-trash"></i></a>
        </td>
    </tr>`;

$('#formCrudModal #articulo').on('change', function(){
      var id = $(this).val();
      if( id != 'null' ){
          var ele = servicios_ac.find( item => item.id == id  );
          if($('#formCrudModal #tabla-lista tbody tr').length > 0 ){
            $('#formCrudModal #tabla-lista tbody tr').each(function(e,data) {
              sumHours($('#'+data.id+'_td').attr('fin'), ele.end ,'#formCrudModal #ini_show','#formCrudModal #fin_show','#formCrudModal #duracion_show')
            });
          }else{
            sumHours($('#formCrudModal #start').val(),ele.end,'#formCrudModal #ini_show','#formCrudModal #fin_show','#formCrudModal #duracion_show')
            $('#formCrudModal #precio').val(ele.precio);
          }
      }else{
          console.log('empty');
      }
});

$('#ini_show').on('change', function(){
  SRHoras($(this).val(),$('#fin_show').val(),'restar','#formCrudModal #duracion_show')
});
$('#fin_show').on('change', function(){
  SRHoras($(this).val(),$('#ini_show').val(),'restar','#formCrudModal #duracion_show')
});
function SRHoras(hor1,hor2,condicion,modal){
    var repla1= hor1.split(':');
    var repla2= hor2.split(':');
    var json1 = { hour : repla1[0], minutes : repla1[1] };
    var json2 = { hour : repla2[0], minutes : repla2[1] };
    sumarHoursJson(json1, json2,condicion,modal)
}
function sumarHoursJson(json1, json2,condicion,modal) {
  var fin="";
  if (condicion == 'sumar') {
    hr            = parseInt(json1.hour) + parseInt(json2.hour);
    mn            = parseInt(json1.minutes) + parseInt(json2.minutes);
    final_hr      = hr + Math.floor(mn/60);
    final_mn      = mn%60;
    final_mn      = (final_mn < 10) ? '0' + final_mn : final_mn;
    fin= final_hr + ':' + final_mn;
  }else{
    hr            = parseInt(json1.hour) - parseInt(json2.hour);
    mn            = parseInt(json1.minutes) - parseInt(json2.minutes);
    final_hr      = hr + Math.floor(mn/60);
    final_mn      = mn%60;
    final_mn      = (final_mn < 10) ? '0' + final_mn : final_mn;
    fin= ajustar(1,final_hr) + ':' + final_mn;
  }
  $('#duracion_show').val(fin);
}
function ajustar(tam, num) {
if (num.toString().length <= tam) return ajustar(tam, "0" + num)
else return num;
}
function agregraDetalle(){
  if (reglas()) {
          var _url = "{{route('admin.calendario.colaboradores.verificar')}}";
          var formData = new FormData();
          formData.append( 'fecha', $('#fecha_principal').val() );
          formData.append( 'desde', $('#formCrudModal #ini_show').val());
          formData.append( 'hasta', $('#formCrudModal #fin_show').val() );
          formData.append( 'colaborador', $('#formCrudModal #colaborador').val() );
          formData.append( '_token', '{{ csrf_token() }}');
          postData(_url, formData).then(function(rta){
          if (rta.data == null ) {
              var ele = servicios_ac.find( item => item.id == $('#articulo').val());
              ele.colId=$('#colaborador').val();
              ele.colName=$("#colaborador option:selected").text();
              ele.hor_ini=$('#formCrudModal #ini_show').val();
              ele.hor_fin=$('#formCrudModal #fin_show').val();
              ele.duracion=$('#formCrudModal #duracion_show').val();
            if( $('#tr_'+ele.id).length > 0 ){
                toadErrores('No puede duplicar el articulo', 'Ese articulo ya esta en la lista!')
            }else{
                $('#formCrudModal #tabla-lista tbody').append( [ele].map(Servicioo).join('') );
                reset();
                sumPrecioHora();
            }
          }else{
            toadErrores("Error este colaborador ya tiene una cita asignada")
            sumPrecioHora();
          }
        }).catch(function(error){
            console.log('postData dio error'); 
            console.log(error);
            Swal.fire('Ocurrio un Error', error.message, 'error');
        })
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
function reglas(){
  console.log($('#formCrudModal #fin_show').val().length)
  if (($('#formCrudModal #colaborador').val() == 'null')){
    toadErrores('Necesita seleccionar un colaborador')
    return false;
  }else if(($('#formCrudModal #articulo').val() == 'null')){
    toadErrores('Necesita seleccionar un servicio')
    return false;
  }else if($('#formCrudModal #ini_show').val().length == 0){
    toadErrores('Necesita seleccionar un horario de inicio')
    return false;
  }else if($('#formCrudModal #fin_show').val().length == 0){
    toadErrores('Necesita seleccionar un horario de fin')
    return false;
  }else{
    return true
  }
}
$('#formCrud').on('submit', function(e){
    e.preventDefault();
    cargando('show','30px','#id-agregar-reserva');
  if($('#formCrudModal #tabla-lista tbody tr').length > 0 ){
        var formData = new FormData($('#formCrud')[0]);
        var ruta = "{{ route('admin.calendario.colaboradores.store') }}";
        postData(ruta, formData).then(function(rta){
          toastr.options = { "closeButton": true, };
          toastr.success(rta['msg'], 'Buen Trabajo!');
          cargando('hide','50px','#id-agregar-reserva');
          $('#id-agregar-reserva').attr('disabled',false)
          $('#formCrudModal').modal('hide')
          Livewire.emitTo('admin.show-eventos','recarge')
        }).catch(function(error){
            console.log('postData dio error'); console.log(error);
            Swal.fire('Ocurrio un Error', error, 'error');
            $('#id-agregar-reserva').attr('disabled',false)
        });        
  }else{
    cargando('hide','30px','#id-agregar-reserva');
    toadErrores('Necesita seleccionar un servicio')
  }
        
});

function eliminarProducto(articulo){
  var id = $('#tr_'+articulo).remove();
  sumPrecioHora();
}
function eliminarReserva(){
      Swal.fire({
      title: 'Desea Eliminar la Reserva',
      text: "Una vez eliminado no podra ser restaurado",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'si! Eliminar'
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData($('#edit_formCrud')[0]);
        var ruta = "{{ route('admin.calendario.colaboradores.destroy') }}";
        store(formData, ruta);
        $('#evento_edit').modal('hide');
        Livewire.emitTo('admin.show-eventos','recarge')
      }
    })
}
function ActualizarReserva(){
  if (rulesEdit()) {
    //   Swal.fire({
    //   title: 'Desea Actualizar El estado de la reserva',
    //   text: "",
    //   showCancelButton: true,
    //   confirmButtonColor: '#3085d6',
    //   cancelButtonColor: '#d33',
    //   confirmButtonText: 'si! Actulizar'
    // }).then((result) => {
    //   if (result.isConfirmed) {

        $('#id-modificar-reserva').attr('disabled',true)
        var formData = new FormData($('#edit_formCrud')[0]);
        formData.append( 'sucursal_id', $('#edit_sucursal').val());
        var ruta = "{{ route('admin.calendario.colaboradores.update') }}";
        var suc_mom=$('#edit_sucursal').val();
        postData(ruta, formData).then(function(rta){
            $('#formCrud').trigger('reset');
            $('#formCrudModal').modal('hide');
            toastr.options = { "closeButton": true, };
            toastr.success(rta['msg'], 'Buen Trabajo!');
            $('#id-modificar-reserva').attr('disabled',false)
            if (rta.redi == 200) {
              window.location.href = "{{route('admin.cuentas.index')}}"+"?sucursal="+suc_mom;
            }else{
              $('#evento_edit').modal('hide');
              Livewire.emitTo('admin.show-eventos','recarge')
            }
        }).catch(function(error){
            console.log('postData dio error'); console.log(error);
            if (error.alert) {
              Swal.fire('Alerta', error.msg, 'warning');
            }else{
              Swal.fire('Ocurrio un Error', error.msg, 'error');
            }
           
        });


    //   }
    // })


  }else{
    return false
  }
}


</script>

@stop