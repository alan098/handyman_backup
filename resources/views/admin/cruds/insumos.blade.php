@extends('adminlte::page')

@section('content_header')
<h1>Insumo</h1>
@stop

@section('content')
<!-- Tabla -->
<div>
    <div class="card">
        <div class="card-body">
            <table class="table table-striped" id="tablaCrud" style="width:100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Activo</th>
                        <th>P. Venta</th>
                        <th>P. Compra</th>
                        <th>Iva</th>
                        <th width='120px'>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!-- Tabla -->
<!-- Modal -->
<div class="modal fade" id="formCrudModal"   role="dialog" aria-labelledby="formCrudModalTitle"
    aria-hidden="true">
    <div class="modal-dialog agrandar" role="document">
        <form id="formCrud">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formCrudModalTitle">Nuevo Insumo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" id="tipo" name="tipo" value="producto">

                    <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-datos-tab" data-toggle="pill" href="#pills-datos"
                                role="tab" aria-controls="pills-datos" aria-selected="true">Datos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-entidades-tab" data-toggle="pill" href="#pills-entidades"
                                role="tab" aria-controls="pills-entidades" aria-selected="false">Entidades /
                                Sucursales</a>
                        </li>
                    </ul>
                    <div class="container">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-datos" role="tabpanel" aria-labelledby="pills-datos-tab">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="name" class="col-form-label">Codigo: </label>
                                            <input type="text" class="form-control form-control-sm" id="codigo"
                                                name="codigo" autofocus>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="name" class="col-form-label">Nombre: <small>(<span
                                                        class="text-danger">*</span>)</small></label>
                                            <input type="text" class="form-control form-control-sm" id="name"
                                                name="name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="name" class="col-form-label">Categoria: <small>(<span
                                                        class="text-danger">*</span>)</small></label>
                                            <select name="categoria_id" id="categoria_id"
                                                class=" form-control form-control-sm" style="width: 100%" required>
                                                <option value="">Elija una categoria</option>
                                                @foreach ($categorias as $item)
                                                <option value="{{ $item->id }}"> {{ $item->name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="name" class="col-form-label">Cantidad por Paquetes:<small>(<span
                                                        class="text-danger">*</span>)</small></label>
                                            <input type="text" class="form-control form-control-sm" id="cantidad_en_paquetes" name="cantidad_en_paquetes" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="precio" class="col-form-label">Precio de Venta: <small>(<span
                                                        class="text-danger">*</span>)</small></label>
                                            <input type="text" class="form-control form-control-sm" id="precio"
                                                name="precio" value="0" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="costo" class="col-form-label">Costo de Compra:</label>
                                            <input type="text" class="form-control form-control-sm" id="costo"
                                                name="costo" value="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="iva10" name="iva"
                                                value="10" checked>
                                            <label for="iva10" class="custom-control-label">Iva 10%</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="iva5" name="iva"
                                                value="5">
                                            <label for="iva5" class="custom-control-label">Iva 5%</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="excenta" name="iva"
                                                value="0">
                                            <label for="excenta" class="custom-control-label">Excenta</label>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-row mt-4 mb-3 ">
                                    <div class="col">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="activo" name="activo" checked>
                                            <label for="activo" class="custom-control-label">Activo?</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="es_vendible" name="es_vendible">
                                            <label for="es_vendible"  class="custom-control-label">SE PUEDE VENDER?</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-entidades" role="tabpanel" aria-labelledby="pills-entidades-tab">
                                <div class="row">
                                    @foreach ($entidades as $ent)
                                        <div class="col">
                                            <p class="font-weight-bold">{{ $ent->name }}</p>
                                            @foreach ($sucursales as $suc)
                                                @if ($suc->entidad_id == $ent->id)
                                                    <div class="row">
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input chsucursales" id="sucursales_{{ $suc->id }}" name="sucursales[{{ $suc->id }}]">
                                                                    <label class="custom-control-label" for="sucursales_{{ $suc->id }}">{{ $suc->name }}</label>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="sumbitButton" class="btn btn-primary" type="submit">
                            <span id="submitSpinner" class="spinner-border-sm" role="status" aria-hidden="true"></span>
                            Guardar
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
        </form>
    </div>
</div>
<!-- Modal -->
@stop


@section('js')


<script src=" {{ asset('js/comunes.js') }} "></script>


<script>
    $( document ).ready(function() {

        var data = {
            table: "tablaCrud",
            ajax : "{{ route('admin.insumos.datatable') }}",
            topMsg: "",
            footerMsg: "Generado: {{ auth()->user()->name }} {{ date("d/m/Y H:i") }}",
            filename: "Listado de Productos",
            title: 'Listado de Productos',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'codigo', name: 'codigo', 'defaultContent': ''},
                {data: 'name', name: 'name', 'defaultContent': ''},
                {data: 'categoria.name', name: 'categoria', 'defaultContent': ''},
                {data: 'activo', name: 'activo', 'defaultContent': ''},
                {data: 'precio', name: 'precio', title: 'P. Venta', className : "text-right", 'defaultContent': ''},
                {data: 'costo', name: 'costo', title:'P. Costo', className : "text-right", 'defaultContent': ''},
                {data: 'iva', name: 'iva', title:'Iva', className : "text-right", 'defaultContent': ''},
                {data: 'acciones', name: 'acciones', orderable: false, searchable: false, class: 'noexport'}
            ]
        };
        toDataTable(data);
        // $('.select2').select2();
    });


    $('[data-toggle="tooltip"]').tooltip();

    $('#formCrud').on('submit', function(e){
        e.preventDefault();

        if( $('#id').val()  ){
            console.log('update'); console.log( $('#id').val() );
            var ruta = "{{ route('admin.insumos.update') }}";
            var formData = new FormData($('#formCrud')[0]);
            update(formData, ruta);
        }else{
            console.log('store');
            var formData = new FormData($('#formCrud')[0]);
            var ruta = "{{ route('admin.insumos.store') }}";
            store(formData, ruta);
        }
        console.log(ruta);
    });


</script>
@stop
