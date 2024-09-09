@extends('layouts.admin')
@section('main-content')
@if (session('status'))
<div class="alert alert-success">
    {{ session('status') }}
</div>
@endif
<div class="contaier">


    <div id='errores' style='display:none' class='alert alert-danger'></div>
    <div id='success' style='display:none;' style="background: #4e73df  !important;" class='alert alert-primary'></div>
    <input class="btn button " type="hidden" id="mostrar_errores" value="1" disabled error="">



    <div class="card shadow mb-3 col-12 ">
        <div class="card-header">
            <span class="float-left">Registro de Importación</span>
            <span class="float-right"><a href="{{ asset('productos/ejemplo_de_importacion.xlsx') }}"> Archivo Ejemplo </a></span>
        </div>
        <form action="{{ route('import.guardar') }}" class="form-inline" method="POST" id="formulario">
            @csrf
            <input type="hidden" id="proveedor_id" name="proveedor_id">
            <div class="card-body form-inline">
                <div class="form-group mt-2 col-2">
                    <label for="ruc" >Codigo </label>
                    <input class="form-control" type="text" id="codigo" name="codigo" placeholder="Codigo" onchange="getDataImportacion(this.value)" autofocus required>
                </div>
                 <div class="form-group mt-2 col-2">
                    <label for="ruc" >Proveedor </label>
                    <input class="form-control" type="text" id="ruc" name="ruc" placeholder="Ruc" readonly>
                </div>
                <div class="form-group mt-2 col-2">
                    <label for="razon"> &nbsp; </label>
                    <input class="form-control" type="text" id="razon" name="razon" placeholder="Razon" readonly>
                </div>
                <div class="form-group mt-2 col-2">
                    <label for="archivo">Archivo Excel</label>
                    <input class="form-control" type="file" id="archivo" name="archivo" required>
                </div>
                <div class="form-group mt-2 col-2">
                    {{--  <button id="procesar" type="button" class="btn btn-primary ml-1 mt-2">Procesar</button>  --}}
                    <button class="btn btn-success" type="button" id="procesar">
                        <span id="procesar_spinner" class="spinner-border-sm" role="status" aria-hidden="true"></span>
                        Procesar
                    </button>
                </div>
            </div>


            <div class="card-body form-inline">
                <div class="form-group mt-2 col-2">
                    <label for="entidad" >Entidad &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </label>
                    <select class="form-control" id="entidad" name="entidad" required>
                    </select>
                </div>
                <div class="form-group mt-2 col-2">
                    <label for="sucursal" >Sucursal</label>
                    <select class="form-control" id="sucursal" name="sucursal" required>
                    </select>
                </div>
                <div class="form-group mt-2 col-2">
                    <label for="sucursal" >Deposito &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </label>
                    <select class="form-control" id="deposito" name="deposito" required>
                    </select>
                </div>

                <div class="form-group mt-2 col-2">
                    {{--  <button id="guardar" type="submit" class="btn btn-success ml-1 mt-2">Guardar</button>  --}}
                    <button class="btn btn-primary" type="submit" id="guardar">
                        <span id="guardar_spinner" class="spinner-border-sm" role="status" aria-hidden="true"></span>
                        Guardar
                    </button>
                </div>
            </div>
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
                    <th>Cód Interno</th>
                    <th>Cód Origen</th>
                    <th>Nombre</th>
                    <th>Categoria</th>
                    <th>Cantidad</th>
                    <th>Cajas</th>
                    <th>Total</th>
                    <th>Forma</th>
                    <th>Final</th>
                    <th>Costo</th>
                    <th>Minorista</th>
                    <th>Mayorista</th>
                    <th>Cod Barra</th>
                </tr>
            </thead>
                <tbody id="tbodyid">
                </tbody>
            </table>
        </form>
    </div>
</div>


<div class="modal fade bd-example-modal-lg" id="modal-clientes" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Clientes (Por favor elija al cliente)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table" id="table-clientes">
                        <thead>
                            <tr>
                                <th>Ruc.</th>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('script')
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
            $('#errores').hide();
            var formulario = document.getElementById("formulario");
            console.log( formulario );
            var formData = new FormData( formulario );
            console.log(data);
            formData.append("datos", JSON.stringify( data ));
            console.log( formData );

            $.ajax({
                type:'POST',
                url: "{{ route('import.guardar')}}",
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success: function(rta){
                    $('#guardar_spinner').toggleClass('spinner-border');
                    $('#guardar').attr('disabled', false);
                    if(rta.cod == 200){
                        //console.log('!= 200');
                        $('#formulario').trigger("reset");
                        $('#tbodyid').empty();
                        $('#success').html(rta.msg);
                        $('#success').show();
                        data = [];
                    }else{
                        $('#errores').html(rta.msg);
                        $('#errores').show();
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


    $('#procesar').on('click', function(){
        $('#procesar_spinner').toggleClass('spinner-border');
        $(this).attr('disabled', true);
        var formData = new FormData();
        formData.append("archivo", archivo.files[0]);
        $('#errores').hide();

        $.ajax({
            type:'POST',
            url: "{{ route('import.procesar')}}",
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            success: function(rta){
                console.log(rta);
                $('#procesar_spinner').toggleClass('spinner-border');

                $('#procesar').attr('disabled', false);
                if(rta.cod != 200){
                    //console.log('!= 200');
                    $('#errores').html(rta.msg);
                    $('#errores').show();
                }else{
                    //  console.log('== 200');
                    data = [];
                    data = rta.dat;
                    $('#tbodyid').empty();
                    if(data.length > 0){
                        data.forEach( function(current, index, array){
                            $('#tabla tbody').append(
                                '<tr>' +
                                    '<td>'+current.cod_articulo+'</td>' +
                                    '<td>'+current.cod_origen+'</td>' +
                                    '<td>'+current.name+'</td>' +
                                    '<td>'+current.categoria+'</td>' +
                                    '<td align="right">'+current.cant+'</td>' +
                                    '<td align="right">'+current.caja+'</td>' +
                                    '<td align="right">'+current.total+'</td>' +
                                    '<td align="right">'+current.forma+'</td>' +
                                    '<td align="right">'+current.final+'</td>' +
                                    '<td align="right">'+current.costo+'</td>' +
                                    '<td align="right">'+current.minorista+'</td>' +
                                    '<td align="right">'+current.mayorista+'</td>' +
                                    '<td align="right">'+current.codbarra+'</td>' +
                                '</tr>'
                            );
                        } );
                         $('#tabla').DataTable();
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
    rellenarDefecto();
    function rellenarDefecto() {
        console.log(sucursal_id);
        
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

        $('#categoria option').remove().promise().done(function(){
            $.each(categorias, function(i, item) {
                if (numero_entidad == item.entidad_id) {
                    $("#categoria").append("<option value="+item.id+">"+item.name+"</option>");
                }
            });
        });

    });
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



function getDataImportacion(id){

    var datos = {'id' : id};

    $.ajax({
        type:"GET",
        url: "{{route('import.get_data')}}",
        data: datos,

        success: function(rta){
            console.log(rta);

            if(rta.cod == 200){
                $('#proveedor_id').val(rta.dat.proveedor_id);
                $('#ruc').val(rta.dat.ruc);
                $('#razon').val(rta.dat.name);
            }else{
                // kaka
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
