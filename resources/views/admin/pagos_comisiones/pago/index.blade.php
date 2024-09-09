@extends('layouts.admin')

@section('styles')
<style>
    .table-mystriped tr:hover {
        background-color: #CCC;
    }

    .table-mystriped tr:nth-child(even) {
        background-color: #f2f2f2;
    }
</style>
@endsection
@section('main-content')
<div>
    <div class="card">
        <div class="card-header">
            <h4 class="float-left">Listado de Ordenes de Pago</h4>
            <span class="text-danger float-right">Ordenes de Pago Generadas</span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Proveedor</span>
                        </div>
                        <select class="form-control select2" name="proveedor" id="proveedor">
                            <option value=""></option>
                            @foreach ($proveedores as $p)
                                <option value="{{ $p->id }}"> {{ $p->ruc }} {{ $p->name }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Desde: </span>
                        </div>
                        <input type="date" id="desde" name="desde" class="form-control" placeholder="Desde" aria-label="Desde" aria-describedby="basic-addon1">
                    </div>
                </div>
                <div class="col">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Hasta: </span>
                        </div>
                        <input type="date" id="hasta" name="hasta" class="form-control" placeholder="Desde" aria-label="Desde" aria-describedby="basic-addon1">
                    </div>
                </div>
                <div class="col">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Estado:</span>
                        </div>
                        <select name="es_autorizado" id="es_autorizado" class="form-control">
                            <option value="">Todos</option>
                            <option value="false">Por Autorizar</option>

                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="col-sm-1" style="float: left;">
                        <a href="javascript:void(0);" class="btn btn-success btn-icon-split" style="font-size: 0.64rem;" onclick="filtrar()">
                            <span class="icon text-white-50">
                              <i class="fas fa-check"></i>
                            </span>
                            <span class="text">Filtrar</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-hover" id="tablaCrud" style="width:100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Fecha</th>
                        <th>Ruc</th>
                        <th>Proveedor</th>
                        <th>Es Autorizado</th>
                        <th>Comprobantes</th>
                        <th>Importe</th>
                        <th width="80">Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!-- Tabla -->

<!-- Modal -->
<!-- Modal -->




@endsection

@section('script')


<script src=" {{ asset('js/crudDataTable.js') }} "></script>


<script>
    $( document ).ready(function() {

        var _url = "{{ url('compras/ordendepago/datatable') }}" + '?proveedor='+$('#proveedor').val()+'&desde='+$('#desde').val()+'&hasta='+$('#hasta').val()+'&autorizado='+$('#es_autorizado').val();
        console.log(_url);

        var data = {
            table: "tablaCrud",
            ajax : _url,
            topMsg: "",
            footerMsg: "Generado: {{ auth()->user()->name }} {{ date("d/m/Y H:i") }}",
            filename: "Listado de Compras sin Detalle",
            title: 'Listado de Compras sin Detalle',
            columns: [
                {data: 'id', name: 'id', title: 'Id'},
                {data: 'fecha', name: 'fecha', title: 'Fecha'},
                {data: 'ruc', name: 'ruc', title: 'Ruc'},
                {data: 'proveedor_name', name: 'proveedor_name', title: 'Proveedor'},
                {data: 'autorizado', name: 'autorizado', title: 'Esta Autorizado',class: 'noexport dt-center'},
                {data: 'comprobantes', name: 'comprobantes', title: 'Comprobantes', class:'dt-right'},
                {data: 'total', name: 'total', title: 'Importe', class:'dt-right'},
                {data: 'acciones', name: 'acciones', orderable: false, searchable: false, class: 'noexport dt-center'}
            ]
        };
        toDataTable(data);
    });
    function filtrar(){
        console.log('filtrando');
        var _newUrl = "{{ url('compras/ordendepago/datatable') }}" + '?proveedor='+$('#proveedor').val()+'&desde='+$('#desde').val()+'&hasta='+$('#hasta').val()+'&autorizado='+$('#es_autorizado').val();
        var table = $('#tablaCrud').DataTable();
        table.ajax.url(_newUrl).load();
    }
    $( ".datepicker" ).datepicker( { altFormat: "yy-mm-dd" } );
    $('[data-toggle="tooltip"]').tooltip();

</script>
@endsection
