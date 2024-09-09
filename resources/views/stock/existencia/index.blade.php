@extends('adminlte::page')

@section('title', 'Agendas')
@section('content_header')
    
    <span class="float-left"><h1>Existencia</h1></span>
    <span class="float-right"><a class="btn btn-secondary" href="{{ route('admin.exportacion.existe') }}"> Descargar Existencia
        </a></span>
@stop
@section('content')
        <div class="card shadow mb-3 col-12 bg-cyan ">
            <div class="form-row col-12"><b>Filtros</b></div>
                <div class="form-row mt-3 mb-3 border">
                    <div class="col-6">
                        <div class="form-row mt-2 mb-2">
                            <div class="col-2">
                                <label for=""><b>Entidad:</b></label>
                            </div>
                            <div class="col-9 ">
                                <select class="form-control" name="entidad" id="entidad">
                                    @foreach ($entidades as $ad)
                                        <option value="{{ $ad->id }}">{{ $ad->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row mt-2 mb-2">
                            <div class="col-2">
                                <label for=""><b>Sucursales:</b></label>
                            </div>
                            <div class="col-9 ">
                                <select class="form-control" name="sucursal" id="sucursal">
                                    <option value="">Todas</option>
                                    @foreach ($sucursales as $ad)
                                        <option value="{{ $ad->id }}">{{ $ad->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row mt-2 mb-2">
                            <div class="col-2">
                                <label for=""><b>Depositos:</b></label>
                            </div>
                            <div class="col-9 ">
                                <select class="form-control" name="deposito" id="deposito">
                                    @foreach ($depositos as $ad)
                                        <option value="{{ $ad->id }}">{{ $ad->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-6">
                        {{-- <div class="form-row mt-2 mb-2">
                            <div class="col-2">
                                <label for=""><b>Colaboradores:</b></label>
                            </div>
                            <div class="col-9 ">
                                <select class="form-control" name="colaborador" id="colaborador">
                                    <option value="" selected>Todos</option>
                                    @foreach ($colaboradores as $ad)
                                        <option value="{{ $ad->id }}">{{ $ad->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
                        <input type="hidden" name="colaborador" id="colaborador">
                        <div class="form-row mt-2 mb-2">
                            <div class="col-2">
                                <label for=""><b>Articulos:</b></label>
                            </div>
                            <div class="col-9 ">
                                <select class="form-control select2" name="articulo" id="articulo">
                                    <option value="" selected>Todos</option>
                                    @foreach ($art as $ad)
                                        <option value="{{ $ad->id }}">{{ $ad->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row mt-2 mb-2">
                            <div class="col-2">
                                <label for=""><b>Filtrar:</b></label>
                            </div>
                            <div class="col-4">
                                <button class="btn btn-primary col-12" type="button" id="buscar"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </div>
                            <div class="col-6"></div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="card shadow mb-3 col-12 ">
            <div class="card-body">
                <table class="table" id="tabla-venta">
                    <thead>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>   
        </div>

@stop
@section('js')
<script src=" {{ asset('js/comunes.js') }} "></script>

    <script>
        $(document).ready(function() {

            @php
                echo ' var entidades = ' . json_encode($entidades) . '; ';
                echo ' var sucursales = ' . json_encode($sucursales) . '; ';
                echo ' var depositos = ' . json_encode($depositos) . '; ';
                echo ' var entidad_id = ' . auth()->user()->entidad_id . '; ';
                echo ' var sucursal_id = ' . auth()->user()->sucursal_id . '; ';
                echo ' var deposito_id = ' . auth()->user()->deposito_id . '; ';
                
            @endphp
            $("#entidad").change(function() {
                var numero_entidad = $('#entidad').val();
                $('#sucursal option').remove().promise().done(function() {
                    $.each(sucursales, function(i, item) {
                        if (numero_entidad == item.entidad_id) {
                            $("#sucursal").append("<option value=" + item.id + ">" + item.name + "</option>");
                        }
                    });
                    $("#sucursal").append("<option value=''>Todas</option>");
                });
                $('#deposito option').remove().promise().done(function() {
                    $.each(depositos, function(i, item) {
                        if (numero_entidad == item.entidad_id) {
                            if ($("#sucursal").val() == item.sucursal_id) {
                                $("#deposito").append("<option value=" + item.id + ">" +item.name + "</option>");
                            }
                        }
                    });
                    $("#deposito").append("<option value=''>Todos</option>");
                });

            });
            $("#sucursal").change(function() {
                var numero_entidad = $('#entidad').val();
                var numero_sucursal = $('#sucursal').val();
                $('#deposito option').remove().promise().done(function() {
                    $.each(depositos, function(i, item) {
                        if (numero_entidad == item.entidad_id) {
                            if (numero_sucursal == item.sucursal_id) {
                                $("#deposito").append("<option value=" + item.id + ">" + item.name + "</option>");
                            }
                        }
                    });
                    $("#deposito").append("<option value=''>Todos</option>");
                });
            });

            $("#entidad").trigger('change');

            var urlcomision= "{{ route('admin.existencia.datatable') }}"+ '?en='+$('#entidad').val()+'&su='+$('#sucursal').val()+'&de='+$('#deposito').val()+'&co='+$('#colaborador').val()+'&ar='+$('#articulo').val();
            var datacomi = {
            table: "tabla-venta",
            ajax : urlcomision,
            topMsg: "",
            filename: "Listado",
            title: 'Listado',
            columns: [
                    { data: 'id', name: 'id', className: "text-left", title: 'Cod Interno'},
                    { data: 'ar_name', name: 'articulo',  title: 'Articulo',className: "text-left"},
                    { data: 'su_name', name: 'sucursal',  title: 'Sucursal',className: "text-left"},
                    { data: 'de_name', name: 'deposito',  title: 'Deposito',className: "text-left"},
                    // { data: 'co_name', name: 'colaborador', title: 'Colaborador', searchable: false, className: "text-right",},
                    { data: 'cantidad', name: 'cantidad', title: 'Saldo', searchable: false, className: "text-right"},
                    { data: 'entero', name: 'entero', title: 'Enteros', searchable: false, className: "text-right"},
                    { data: 'queda', name: 'queda', title: 'Usados/Paquetes', searchable: false, className: "text-right"},
                    { data: 'info', name: 'info', title: 'Mas Detalles', searchable: false, className: "text-right"},
            ],
            drawCallback:function( settings ) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        };
         SimpleDataTable(datacomi);

        function SimpleDataTable(data) {
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
              var tablebase=  $('#' + data.table).DataTable({
                order: [[0, "desc"]],
                autoWidth: true,
                paging: true,
                ajax: data.ajax,
                columns: data.columns,
                language: espanis_data,
                searching: true,
                dom: 'Bfrtip',
                columnDefs:data.columnDefs,
                "lengthMenu": [ [10, 25, 100, -1], [10, 25, 100, "Todos"] ],
                buttons: [{
                    extend: 'pageLength',
                }  
                ],
                drawCallback: data.drawCallback,
                
            });
            return tablebase
        }

$('#buscar').on( 'click', function (e) {
    e.preventDefault();
    var _url = "{{ route('admin.existencia.datatable') }}"+ '?en='+$('#entidad').val()+'&su='+$('#sucursal').val()+'&de='+$('#deposito').val()+'&co='+$('#colaborador').val()+'&ar='+$('#articulo').val();
    var table = $('#tabla-venta').DataTable();
    table.ajax.url(_url).load();
});

});
       
        
          
    </script>
@stop
