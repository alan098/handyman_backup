@extends('adminlte::page')
@section('content')
<div class="contaier">
    <div id='errores' style='display:none' class='alert alert-danger'></div>
    <div id='success' style='display:none;' style="background: #4e73df  !important;" class='alert alert-primary'></div>
    <input class="btn button " type="hidden" id="mostrar_errores" value="1" disabled error="">
    <div class="card shadow mb-3 col-12 ">
        <div class="card-header">
            
            <div class="form-row">
                <div class="col">
                    <span class="float-left">Inventario Nuevo</span>
                </div>
                <div class="col">
                    <span>Tipo</span>
                    <select name="ex_tipo" id="ex_tipo" class="form-control">
                        <option value="todos">todos</option>
                        <option value="insumo">Insumo</option>
                        <option value="producto">Producto</option>
                    </select>
                </div>
                <div class="col"> 
                    <button class="btn btn-success mt-4" type="button" id="archivo_ejemplo">Archivo Ejemplo</button>
                </div>
            </div>
            {{-- <span class="float-right"><a href="{{ route('admin.exportacion') }}"> Archivo Ejemplo</a></span> --}}
        </div>
        <form action="#" class="form-inline" method="POST" id="formulario">
            @csrf
            @if (isset($inventario))
                <input type="hidden" id="id" name="id" value="{{$inventario->id}}">
            @endif
            <div class="card-body form-inline">
                <div class="form-row">
                    <div class="form-group mt-2 col-2">
                        <label for="ruc">Nombre inventario</label>
                        <input class="form-control" type="text" id="name" name="name" placeholder="Nombre" autofocus required @if (isset($inventario)) readonly   @endif >
                    </div>
                    <div class="form-group mt-2 col-2">
                        <label for="fecha">Fecha</label>
                        <input class="form-control col-12" type="date" id="fecha" name="fecha" placeholder="Fecha" required @if (isset($inventario)) readonly   @endif >
                    </div>
                    <div class="form-group col-2">
                        <label for="tipo_movimiento"> Tipo Movimiento </label>
                        <select name="tipo_movimiento" id="tipo_movimiento" class="form-control col-12" @if (isset($inventario)) disabled   @endif>
                            <option value="entrada">ENTRADA</option>
                            <option value="salida">SALIDA</option>
                            <option value="ajuste">AJUSTE</option>
                        </select>
                    </div>
                    @if (!isset($inventario))
                    <div class="form-group mt-2 col-2">
                        <label for="archivo">Archivo Excel</label>
                        <input class="form-control" type="file" id="archivo" name="archivo" required>
                    </div>
                        <div class="form-group  mt-4  ml-2 col-3">
                            <button class="btn btn-success" type="button" id="procesar">
                                <span id="procesar_spinner" class="spinner-border-sm" role="status"
                                    aria-hidden="true"></span>
                                Procesar
                            </button>
                        </div>
                    @else
                        @if ($inventario->es_confirmado)
                            <div class="form-group  mt-4  ml-2 col-3">
                                <p>Este inventario ya fue confirmado el 
                                {{$inventario->confirmado_at}} </p>
                            </div>
                        @else
                            <div class="form-group  mt-4  ml-2 col-3">
                                <button class="btn btn-secondary" type="button" id="confirmar">
                                    <span id="procesar_spinner" class="spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Confirmar Inventario
                                </button>
                            </div>
                        @endif
                    
                    @endif
                    
                </div>
            </div>
            @if (!isset($inventario))
            <div class="card-body form-inline">
                <div class="form-row">
                    <div class="form-group mt-2 col-3">
                        <label for="entidad">Entidad </label>
                        <select class="form-control col-12" id="entidad" name="entidad" required>
                        </select>
                    </div>
                    <div class="form-group mt-2 col-3">
                        <label for="sucursal">Sucursal</label>
                        <select class="form-control col-12" id="sucursal" name="sucursal" required>
                        </select>
                    </div>
                    <div class="form-group mt-2 col-3">
                        <label for="sucursal">Deposito</label>
                        <select class="form-control col-12" id="deposito" name="deposito" required>
                        </select>
                    </div>
                    <div class="form-group mt-4 ml-2 col-2">
                        <button class="btn btn-primary" type="submit" id="guardar">
                            <span id="guardar_spinner" class="spinner-border-sm" role="status"
                                aria-hidden="true"></span>
                            Guardar
                        </button>
                    </div>
                </div>
            </div>                
            @else
               <input type="text" id="entidad" class="form-control" disabled> 
               <input type="text" id="sucursal" class="form-control" disabled> 
               <input type="text" id="deposito" class="form-control" disabled> 
            @endif

        </form>


    </div>
    <div class="card shadow mb-3 col-12 ">
        <form action="#" method="POST" id="myform">
            @csrf
            <input type="hidden" id="categoria_id" name="categoria_id">
            <input type="hidden" id="deposito_id" name="deposito_id">
            <table class="table table-striped" id="tabla" data-page-length='100'>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Codigo</th>
                        <th>Categoria</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody id="tbodyid">
                </tbody>
            </table>
        </form>
    </div>
</div>
@stop
@section('js')
<script src=" {{ asset('js/comunes.js') }} "></script>
<script>
    var data = [];
$( document ).ready(function() {
    $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
    $('#formulario').on('submit', function(e){
        e.preventDefault();
        if( data.length == 0 ){
            $('#errores').html('Debe procesar el archivo primero');
            $('#errores').show();
        }else{
            $('#guardar_spinner').toggleClass('spinner-border');
            var formulario = document.getElementById("formulario");
            var formData = new FormData( formulario );
            formData.append("datos", JSON.stringify( data ));
            $.ajax({
                type:'POST',
                url: "{{ route('admin.inventario.guardar')}}",
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success: function(rta){
                    console.log(rta);
                    $('#guardar_spinner').toggleClass('spinner-border');
                    $('#guardar').attr('disabled', false);
                    if(rta.cod == 200){
                        Swal.fire('Exito al registar inventarios', "", 'success'); 
                        window.location.href = "{{ route('admin.inventarios.index') }}";
                    }else{
                        toadErrores(rta.dat)
                    }
                }
                }).fail( function( jqXHR, textStatus, errorThrown ) {
                    $('#guardar').attr('disabled', false);
                    $('#guardar_spinner').toggleClass('spinner-border');

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
    });


//
$('#confirmar').on('click', function(){
    Swal.fire({
          title: 'Desea Confirmar el inventario ya verifico todos los datos?',
          text: "Una vez confirmado no se podra eliminar",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'si! Confirmar'
        }).then((result) => {
          if (result.isConfirmed) {
            var _url = "{{route('admin.inventario.confirmar')}}";
              var formData = new FormData();
              formData.append( 'es_confirmado', 'true' );
              formData.append( 'id', $('#id').val() );
              formData.append( '_token', '{{ csrf_token() }}');
              postData(_url, formData).then(function(rta){
                Swal.fire('Exito al confirmar inventario', "", 'success'); 
                window.location.href = "{{ route('admin.inventarios.index') }}";
            }).catch(function(error){
                console.log('postData dio error'); 
                Swal.fire('Ocurrio un Error', error.message, 'error');
            })
          }
        })
    
    });




$('#archivo_ejemplo').on('click', function(){
    var tipo = $('#ex_tipo').val();
    let url= "{{ route('admin.exportacion') }}"+'/'+tipo;
    ventana = window.open(url , '_');
});



$('#procesar').on('click', function(){
        $('#procesar_spinner').toggleClass('spinner-border');
        $(this).attr('disabled', true);
        var formData = new FormData();
        formData.append("archivo", archivo.files[0]);
        $('#errores').hide();
        $.ajax({
            type:'POST',
            url: "{{ route('admin.inventario.procesar')}}",
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            success: function(rta){
                console.log(rta);
                console.log("alal")
                $('#procesar_spinner').toggleClass('spinner-border');
                $('#procesar').attr('disabled', false);
                if(rta.cod != 200){
                    $('#errores').html(rta.msg);
                    $('#errores').show();
                }else{
                    data = [];
                    data = rta.dat;
                    $('#tbodyid').empty();
                    if(data.length > 0){
                        data.forEach( function(current, index, array){
                            $('#tabla tbody').append(
                                '<tr>' +
                                    '<td>'+current.id+'</td>' +
                                    '<td>'+current.codigo+'</td>' +
                                    '<td>'+current.categoria+'</td>' +
                                    '<td>'+current.name+'</td>' +
                                    '<td align="right">'+current.tipo+'</td>' +
                                    '<td align="right">'+current.cantidad+'</td>' +
                                '</tr>'
                            );
                        } );
                         $('#tabla').DataTable({
                            "columnDefs": [
                                {"className": "dt-center", "targets": "_all"}
                            ]
                         });
                    }else{
                        $('#errores').html(rta.msg);
                        $('#errores').show();
                    }
                }
            }
            }).fail( function( jqXHR, textStatus, errorThrown ) {
                $('#procesar').attr('disabled', false);
                $('#procesar_spinner').toggleClass('spinner-border');

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

    @php
        echo ' var entidades = '.json_encode($entidades).'; ';
        echo ' var sucursales = '.json_encode($sucursales).'; ';
        echo ' var depositos = '.json_encode($depositos).'; ';
        echo ' var entidad_id = '.json_encode(auth()->user()->entidad_id).'; ';
        echo ' var sucursal_id = '.json_encode(auth()->user()->sucursal_id).'; ';
    @endphp
    @unless(!empty($inventario))
        rellenarDefecto();
    @endunless
function rellenarDefecto() {        
$('#entidad option').remove().promise().done(function(){
    $.each(entidades, function(i, item) {
        if ( entidad_id == item.id) {
            $("#entidad").append("<option value="+item.id+" selected>"+item.name+"</option>");
        }else{
            $("#entidad").append("<option value="+item.id+">"+item.name+"</option>");
        }
    });
});
$('#sucursal option').remove().promise().done(function(){
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
$('#sucursal option').remove().promise().done(function(){
    $.each(sucursales, function(i, item) {
        if (numero_entidad == item.entidad_id) {
            $("#sucursal").append("<option value="+item.id+">"+item.name+"</option>");
        }
    });
});
$('#deposito option').remove().promise().done(function(){
    $.each(depositos, function(i, item) {
        if (numero_entidad == item.entidad_id) {
            if ($("#sucursal").val() == item.sucursal_id) {
                $("#deposito").append("<option value="+item.id+">"+item.name+"</option>");
            }
        }

    });
});


})
$("#sucursal").change(function() {
    var numero_entidad=$('#entidad').val();
    var numero_sucursal=$('#sucursal').val();

    $('#deposito option').remove().promise().done(function(){
        $.each(depositos, function(i, item) {
            if (numero_entidad== item.entidad_id) {
                if (numero_sucursal == item.sucursal_id) {
                    $("#deposito").append("<option value="+item.id+">"+item.name+"</option>");
                }
            }

        });
    });
});

});

  //esto es para cuando se este editando
  @unless(empty($inventario))
            $('#name').val('{{$inventario->name}}');
            $('#fecha').val('{{$inventario->fecha}}');
            $('#tipo_movimiento').val('{{$inventario->tipo_movimiento}}');
            $('#entidad').val('{{$inventario->entidad->name}}');
            $('#sucursal').val('{{$inventario->sucursal->name}}');
            $('#deposito').val('{{$inventario->deposito->name}}');

            
            @unless (empty($inventario->detalles))
                $('.detalle').remove();
                @foreach ($inventario->detalles as $detalle)
                    @unless(empty($detalle->articulo))
                    $('#tabla tbody').append(
                        '<tr>' +
                            '<td>{{ $detalle->articulo->id }}</td>' +
                            '<td>{{ $detalle->articulo->codigo }}</td>' +
                            @if(!empty($detalle->articulo->categoria))
                            '<td>{{ $detalle->articulo->categoria->name }}</td>' +
                           @else
                           '<td>0</td>' +
                           @endif
                            '<td>{{ $detalle->articulo->name }}</td>' +
                            '<td>{{ $detalle->articulo->tipo }}</td>' +
                            '<td>{{ $detalle->cantidad}}</td>' +
                        '</tr>'
                    );
                    @endunless
                @endforeach
                var totalMP = 0;
            @endunless
        @endunless
        //editar 
</script>
@stop