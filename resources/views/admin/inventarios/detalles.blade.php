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
            Movimientos de Articulo <strong>[ {{ $articulo->cod_articulo.' - '.$articulo->name }} ] [ Saldo: {{ $saldo }} ]</strong>
        </div>
        <form action="#">
            <div class="card-body form-inline">
                <div class="form-group mt-2 col-3">
                    <label for="exampleFormControlSelect1">Entidad: </label> &nbsp;
                    <select class="form-control" id="entidad" name="entidad">
                    </select>
                </div>
                <div class="form-group mt-2 col-3">
                    <label for="exampleFormControlSelect1">Sucursal: </label> &nbsp;
                    <select class="form-control" id="sucursal" name="sucursal">
                    </select>
                </div>
                <div class="form-group mt-2 col-3">
                    <label for="exampleFormControlSelect1">Deposito: </label> &nbsp;
                    <select class="form-control" id="deposito" name="deposito">
                    </select>
                </div>
                {{-- <div class="form-group mt-2 col-3">
                    <label for="exampleFormControlSelect1" class="mr-1">Categoria</label>
                    <select class="form-control" id="categoria" name="categoria">
                    </select>
                </div> --}}
                {{-- <button id="buscar" type="button" class="btn btn-success ml-1 mt-2">Buscar</button> --}}

            </div>
        </form>


    </div>
    <div class="card shadow mb-3 col-12 ">
        <form action="#" method="POST" id="myform">
            @csrf
            <input type="hidden" id="categoria_id" name="categoria_id">
            <input type="hidden" id="deposito_id" name="deposito_id">
            <table class="table table-striped" id="tabla-venta">
                <thead>
                    <tr>
                        <th>Cod Interno</th>
                        <th>Producto</th>
                        <th>Movimiento</th>
                        <th>Motivo</th>
                        <th>Comprobante</th>
                        <th>Entrada</th>
                        <th>Salida</th>
                        <th>Saldo</th>
                        <th>Ver</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </form>
    </div>
</div>

<div class="modal fade" id="modalDetalles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
</div>



@endsection
@section('script')
<script>
    $( document ).ready(function() {

    @php
        echo ' var entidades = '.json_encode($entidades).'; ';
        echo ' var sucursales = '.json_encode($sucursales).'; ';
        echo ' var depositos = '.json_encode($depositos).'; ';
        echo ' var categorias = '.json_encode($categorias).'; ';
        echo ' var entidad_id = '.request('entidad').'; ';
        echo ' var sucursal_id = '.request('sucursal').'; ';
        echo ' var deposito_id = '.request('sucursal') .'; ';

    @endphp

    rellenarDefecto();
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
                            if (deposito_id == item.id) {
                                $("#deposito").append("<option selected value="+item.id+">"+item.name+"</option>");
                            }else{
                                $("#deposito").append("<option value="+item.id+">"+item.name+"</option>");
                            }
                        }
                    }

                });
            });

            $('#entidad').attr('disabled', true);
            $('#sucursal').attr('disabled', true);
            $('#deposito').attr('disabled', true);



            //     $('#categoria option').remove().promise().done(function(){
            //     $.each(categorias, function(i, item) {
            //         if (entidad_id == item.entidad_id) {
            //             $("#categoria").append("<option value="+item.id+">"+item.name+"</option>");
            //         }
            //     });
            // });

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

    var table = $('#tabla-venta').DataTable();



            table.destroy();
            $('#tabla-venta').empty();

            var _url = '';
            _url += '/existencia/detalles/data/';
            _url += "{{ request('entidad').'/' }}";
            _url += "{{ request('sucursal').'/' }}";
            _url += "{{ request('deposito').'/' }}";
            _url += "{{ request('articulo') }}";

            var entidadName = $( "#entidad option:selected" ).text();
            var sucursalName = $( "#sucursal option:selected" ).text();;
            var depositoName = $( "#deposito option:selected" ).text();;
            var leyenda = "{{ $articulo->cod_articulo.' - '.$articulo->name.' Saldo: '.$saldo }}" + '\nEntidad: '+entidadName+' Sucursal: '+sucursalName+' Deposito: '+depositoName;
            var fileName = "{{ 'movimiento_' . $articulo->cod_articulo.'_'.date('Ymd_Gi') }}"+'_'+depositoName.toLowerCase().replace(/\s/g, '_')+'{{ '_'.date("Ymd_Gi") }}';



            table = $('#tabla-venta').DataTable({
            dom: 'Bflrtip',
            lengthChange: false,
            processing: true,
            serverSide: true,
            ajax: { url: _url },
            responsive: true,
            columns: [
                {data: 'id', name: 'id', className: "text-left", title:'Id'},
                {data: 'fecha',name:'fecha', className: "text-left", title:'Fecha'},
                {data: 'movimiento',name:'movimiento', className: "text-left", title:'Movimiento'},
                {data: 'motivo',name:'motivo', className: "text-left", title:'Motivo'},
                {data: 'entrada', name: 'entrada', title:'Entrada', searchable: false, className: "text-right"},
                {data: 'salida', name: 'salida', title:'Salida', searchable: false, className: "text-right"},
                {data: 'saldo', name: 'saldo', title:'Saldo', searchable: false, className: "text-right"},
                {data: 'detalle', name: 'detalle', title:'Ver', orderable: false, searchable: false, className:"notexport",
                    "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                        console.log( oData.detalle );
                        $(nTd).html("<a class='btn btn-primary' href='#' onclick='verDetalle(\""+oData.detalle+"\")'><i class='fas fa-eye'></i></a>");
                    }
                }
            ],
            lengthMenu: [
                [ 10, 25, 50, 100, -1 ],
                [ 'ver 10 filas', 'ver 25 filas', 'ver 50 filas', 'ver 100 filas', 'ver todas' ]
            ],
             buttons: [
                 {
                    extend:'pageLength',
                    text: 'ver 10 filas <i class="fa fa-sort-down"></i>'
                 },
                 {
                    extend: 'copy',
                    text: '<i class="fas fa-file-alt"></i>',

                    exportOptions: {
                        columns: 'th:not(.notexport)'
                    }
                },{
                    extend: 'print',
                    text: '<i class="fas fa-print"></i>',

                    exportOptions: {
                        columns: 'th:not(.notexport)'
                    }
                },
                {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"></i>',
                    messageTop: leyenda,
                    messageBottom: '{{ auth()->user()->name }} {{ date("d/m/Y G:i") }}',
                    title: "Movimiento de Articulo",
                    filename: fileName,
                    exportOptions: {
                        columns: 'th:not(.notexport)'
                    }
                },{
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf"></i>',
                    messageTop: leyenda,
                    messageBottom: '{{ auth()->user()->name }} {{ date("d/m/Y G:i") }}',
                    title: "Movimiento de Articulo",
                    filename: fileName,
                    exportOptions: {
                        columns: 'th:not(.notexport)'
                    },
                },
            ],
            "language": {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                },
            },
            "decimal":     ",",
            "thousands":        ".",
        });

    });

    function verDetalle(_url){
        console.log(_url);

        $.ajax({
            type:"GET",
            url: _url,
            success: function(data){
                $('#modalDetalles').html(data);
                $('#modalDetalles').modal('show');
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
