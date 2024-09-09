@extends('adminlte::page')
@section('title', 'Comisiones')
@section('content_header')
@stop
@section('content')
    <div class=" container-fluid">
        @include('admin.reservas_historial.reserva.modaleditar')
        <div class="card shadow mb-1">
            <div class="card-header">
                <h4 class="float-left">Reservas</h4>
            </div>  
            <div class="card-body" >

                <div class="form-row">
                    <div class="col-1">
                        <x-jet-label value="Cliente:" />
                    </div>
                    <div class="col">
                      {{-- <select name="cliente_id" id="cliente_id" class="form-control select2"
                            style="width: 100%" required>
                            <option value="">Ingrese el Nombre o el Ruc</option>
                            <optgroup label="Clientes">
                                @foreach ($clientes as $cli)
                                <option value="{{ $cli->id }}">{{ $cli->ruc }}-{{
                                    $cli->name }}</option>
                                @endforeach
                            </optgroup>
                        </select> --}}
                        <select class="js-data-clientes-ajax" style="width: 100%" id="cliente_id">
                        </select>
                    </div>
                    <div class="col-1">
                        <x-jet-label value="Sucursal:" />
                    </div>
                    <div class="col">
                        <select class="form-control" id="sucursal_id">
                            @foreach ($sucursal as $suc)
                                @if ($suc->id == auth()->user()->id)
                                    <option value="{{$suc->id}}" selected>{{$suc->name}}</option> 
                                @else
                                    <option value="{{$suc->id}}">{{$suc->name}}</option>   
                                @endif
                            @endforeach
                        </select>                        
                    </div>
                    <div class=col-6></div>
                </div>
                <div class="form-row mt-3">
                   <div class="col-1">
                        <x-jet-label value="Desde:" />
                    </div>
                    <div class="col">
                        <input type="date" class="form-control" aria-label="Desde" aria-describedby="basic-addon1"
                                value="<?php echo date('Y-m-d'); ?>" id="desde">
                    </div>
                    <div class="col-1">
                        <x-jet-label value="Hasta:" />
                    </div>
                    <div class="col">
                        <input type="date" class="form-control" aria-label="Hasta" aria-describedby="basic-addon1"
                                value="<?php echo date('Y-m-d'); ?>" id="hasta">
                    </div>
                    <div class="col">
                       <button class="btn btn-primary" onclick="filtrar()">Filtrar </button>
                    </div>
                    <div class=col-4></div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="float-left">Reservas</h4>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover" id="tablaCrud" style="width:100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Creado Por</th>
                        <th>Fecha Creacion</th>
                        <th>Servicio</th>
                        <th>Hora Inicio</th>
                        <th>Hora Fin</th>
                        <th>Colaborador</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    </div>
@stop
@section('js')
    <script src=" {{ asset('js/comunes.js') }} "></script>
    <script>
$(document).ready(function() {
    
    $('#tablaCrud').DataTable();
$('.js-data-clientes-ajax').select2({
    minimumInputLength: 2,
    minimumResultsForSearch: 10,
    allowClear: true,
    placeholder: {
      id: "",
      text:"Todos",
      selected:'selected'
    },
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
var url="{{ route('admin.lista_reserva.datatable') }}"
        var urlmodal = url + '?cliente_id='+$('#cliente_id').val()+'&desde='+$('#desde').val()+'&hasta='+$('#hasta').val()+'&sucursal_id='+$('#sucursal_id').val();
        var dataModal = {
            table: "tablaCrud",
            ajax: urlmodal,
            topMsg: "",
            footerMsg: "Generado: {{ auth()->user()->name }} {{ date('d/m/Y H:i') }}",
            filename: "Cuentas Pendientes",
            title: 'Cuentas Pendientes',
            columns: [
            {data: 'id_reserva',name: 'id',title: 'Id'},
            {data: 'edit_cliente_id',name: 'Cliente',title: 'Cliente'},
            {data: 'edit_fecha',name: 'id',title: 'Fecha'},
            {data: 'creador',name: 'creador',title: 'Creado Por'},
            {data: 'created_at',name: 'creacion',title: 'Fecha de Creacion'},
            {data: 'ar_name',name: 'ar_name',title: 'Servicio'},
            {data: 'start',name: 'Hora inicio',title: 'Hora Inicio'},
            {data: 'end',name: 'Hora fin',title: 'Hora Fin',class: 'dt-center'},
            {data: 'edit_colaborador_name',name: 'colaborador',title: 'Colaborador',class: 'dt-center'},
            {data: 'estado_name',name: 'estado',title: 'Estado',class: 'dt-center'},
            {data: 'acciones',name: 'acciones',title: 'Acciones',orderable: false,searchable: false,class: 'noexport dt-center'}
            ]
        };
        toDataTableSimple(dataModal);
        function toDataTableSimple(data) {
            $('#' + data.table).DataTable({
                order: [
                    [0, "desc"]
                ],
                responsive: true,
                autoWidth: false,
                ajax: data.ajax,
                columns: data.columns,
                language: espanis_data,
                pageLength: 80,
                dom: 'Bfrtip',
                buttons: [],
                initComplete: function() {},
                drawCallback: function(settings) {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });
        }
function filtrar(){
    var _url = url + '?cliente_id='+$('#cliente_id').val()+'&desde='+$('#desde').val()+'&hasta='+$('#hasta').val()+'&sucursal_id='+$('#sucursal_id').val();
    var table = $('#tablaCrud').DataTable();
    table.ajax.url(_url).load();
}
function eliminarReserva(id){
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
        var formData = new FormData();
        formData.append( 'id_reserva',id );
        formData.append( '_token', '{{ csrf_token() }}');
        var ruta = "{{ route('admin.calendario.colaboradores.destroy') }}";
        store(formData, ruta);
        $('#evento_edit').modal('hide');
        Livewire.emitTo('admin.show-eventos','recarge')
      }
    })
}
@php
        echo "var servicios_ac = ".json_encode($servicios)."; ";
        echo "var colaborador_js = ".json_encode($colaboradores)."; ";
    @endphp
function populateModalEdit(id){
    let url= "{{ route('admin.calendario.colaboradores.edit',':id') }}";
    url = url.replace(':id', id);
        getData(url).then(function(rta){
          console.log(rta);
          //fechas
          if (rta[2]) { $('#edit_fecha').prop('readOnly', true); } else { $('#edit_fecha').prop('readOnly', false); }
          // cantidad de reservas
          $('#label_cantidad').html('Esta reserva consta de '+rta[1][0].eventos+' servicio/s');
          //lo demas
          populateForm('edit_formCrud', JSON.parse( rta[0] ) ,1);
          var pars=JSON.parse( rta[0] )
          
          if(pars.sin_prefe){
            $('#edit_formCrud #con_prefe_edit').attr('checked',true)
          }else{
            $('#edit_formCrud #sin_prefe_edit').attr('checked',true)
          }

          $('#edit_formCrud #edit_colaborador').val(pars.edit_colaborador_id);
          $('#edit_formCrud #id_col_default').val(pars.edit_colaborador_id);
          $('#edit_formCrud #id_detalle').val(pars.edit_detalle_id);
          $('#edit_formCrud #edit_articulo').val(pars.edit_articulo_id);
          //colocamos el horario manualmente porque o sino no funca
          $('#edit_formCrud #edit_ini_show').val(pars.edit_ini_show);
          $('#edit_formCrud #edit_fin_show').val(pars.edit_fin_show);
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
function ActualizarReserva(){
  if (rulesEdit()) {
      Swal.fire({
      title: 'Desea Actualizar El estado de la reserva',
      text: "",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'si! Actulizar'
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData($('#edit_formCrud')[0]);
        formData.append( 'sucursal_id', $('#edit_sucursal').val());
        var ruta = "{{ route('admin.calendario.colaboradores.update') }}";
        var suc_mom=$('#edit_sucursal').val();
        postData(ruta, formData).then(function(rta){
            $('#formCrud').trigger('reset');
            $('#formCrudModal').modal('hide');
            toastr.options = { "closeButton": true, };
            toastr.success(rta['msg'], 'Buen Trabajo!');
            if (rta.redi == 200) {
              window.location.href = "{{route('admin.cuentas.index')}}"+"?sucursal="+suc_mom;
            }else{
              $('#evento_edit').modal('hide');
              $('#tablaCrud').DataTable().ajax.reload();
            }
        }).catch(function(error){
            console.log('postData dio error'); console.log(error);
            if (error.alert) {
              Swal.fire('Alerta', error.msg, 'warning');
            }else{
              Swal.fire('Ocurrio un Error', error.msg, 'error');
            }
           
        });
      }
    })
  }else{
    return false
  }
}
    </script>
@stop
