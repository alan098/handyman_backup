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
            Existencia de Articulos &nbsp; &nbsp;
            <a href="/existencia/importacion" id="importar" class="btn btn-primary ml-1 mt-2">Importación</a>
        </div>
        <form action="#">
            <div class="card-body form-inline">
                <div class="form-group mt-2 col-3">
                    <label for="exampleFormControlSelect1">Entidad:</label> &nbsp;
                    <select class="form-control" id="entidad" name="entidad">
                    </select>
                </div>
                <div class="form-group mt-2 col-3">
                    <label for="exampleFormControlSelect1">Sucursal:</label> &nbsp;
                    <select class="form-control" id="sucursal" name="sucursal">
                    </select>
                </div>
                <div class="form-group mt-2 col-3">
                    <label for="exampleFormControlSelect1">Deposito:</label> &nbsp;
                    <select class="form-control" id="deposito" name="deposito">
                    </select>
                </div>
                {{-- <div class="form-group mt-2 col-3">
                    <label for="exampleFormControlSelect1" class="mr-1">Categoria</label>
                    <select class="form-control" id="categoria" name="categoria">
                    </select>
                </div> --}}
                <button id="buscar" type="button" class="btn btn-success ml-1 mt-2">Buscar</button>

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
                        <th>Cantidad</th>
                        <th>Detalle</th>
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
    echo ' var categorias = '.json_encode($categorias).'; ';
    echo ' var entidad_id = '.( auth()->user()->entidad_id ).'; ';
    echo ' var sucursal_id = '.( auth()->user()->sucursal_id ).'; ';
    echo ' var deposito_id = '.( auth()->user()->deposito_id ).'; ';

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
            console.log( depositos );
            $.each(depositos, function(i, item) {
                if (entidad_id == item.entidad_id) {
                    if (sucursal_id == item.sucursal_id) {
                        console.log( deposito_id +' - '+ item.id );
                        if (deposito_id == item.id) {
                            $("#deposito").append("<option value="+item.id+" selected>"+item.name+"</option>");
                        }else{
                            $("#deposito").append("<option value="+item.id+">"+item.name+"</option>");
                        }                    }
                }

            });
        });

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

});
var table = $('#tabla-venta').DataTable();

$('#buscar').on( 'click', function (e) {
    e.preventDefault();

        var entidadName = $( "#entidad option:selected" ).text();
        var sucursalName = $( "#sucursal option:selected" ).text();;
        var depositoName = $( "#deposito option:selected" ).text();;
        var leyenda = 'Entidad: '+entidadName+' Sucursal: '+sucursalName+' Deposito: '+depositoName;
        var fileName = 'existencia_'+depositoName.toLowerCase().replace(/\s/g, '_')+'{{ '_'.date("Ymd_Gi") }}';

        table.destroy();
        $('#tabla-venta').empty();

        var _url = '/existencia/data/'+$('#entidad').val()+'/'+$('#sucursal').val()+'/'+$('#deposito').val();


        table = $('#tabla-venta').DataTable({
        dom: 'Bfrtip',
        lengthChange: false,
        processing: true,
        {{-- serverSide: true, --}}
        ajax: {
            url: _url,
        },
        responsive: true,
        columns: [
            {data: 'cod_articulo', name: 'cod_articulo', className: "text-left", title:'Cod Interno'},
            {data: 'cod_barras', name: 'cod_barras', className: "text-left", title:'Cod Barras'},
            {data: 'cod_origen', name: 'cod_origen', className: "text-left", title:'Cod Origen'},
            {data: 'name',name:'name', className: "text-left", title:'Producto'},
            {data: 'cantidad', name: 'cantidad', title:'Cantidad', searchable: false, className: "text-right", },
            {data: 'detalle', name: 'detalle', title:'Detalle', orderable: false, searchable: false, className:"notexport text-center",
            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                $(nTd).html("<a class='btn btn-primary' href='"+oData.detalle+"'><i class='fas fa-eye'></i></a>");
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
                filename: fileName,
                title: 'Existencia de Articulos',
                messageBottom: '{{ auth()->user()->name }} {{ date("d/m/Y G:i") }}',
                exportOptions: {
                    columns: 'th:not(.notexport)',
                    modifier: {
                        page: 'all',
                        search: 'none'
                      }
                }
            },{
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i>',
                messageTop: leyenda,
                filename: fileName,
                title: 'Existencia de Articulos',
                messageBottom: '{{ auth()->user()->name }} {{ date("d/m/Y G:i") }}',
                exportOptions: {
                    columns: 'th:not(.notexport)',
                    modifier: {
                        page: 'all',
                        search: 'none'
                      }
                }
            },
        ],
        "language": {
            "decimal": ",",
            "thousands": ".",
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
    });

});




</script>
@endsection
