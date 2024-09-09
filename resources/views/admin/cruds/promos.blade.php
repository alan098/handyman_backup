@extends('adminlte::page')


@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('content_header')
<h1>Promos</h1>
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
                        <th>Nombre</th>
                        <th>Activo</th>
                        <th>Desde</th>
                        <th>Hasta</th>
                        <th>Dias</th>
                        <th>Entidad</th>
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
                    <h5 class="modal-title" id="formCrudModalTitle">Nueva Promo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="id" name="id">

                    <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-datos-tab" data-toggle="pill" href="#pills-datos"
                                role="tab" aria-controls="pills-datos" aria-selected="true">Datos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-productos-tab" data-toggle="pill" href="#pills-productos"
                                role="tab" aria-controls="pills-productos" aria-selected="false">Productos y/o Servicios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-entidades-tab" data-toggle="pill" href="#pills-entidades"
                                role="tab" aria-controls="pills-entidades" aria-selected="false">Entidades /
                                Sucursales</a>
                        </li>
                    </ul>
                    <div class="container">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-datos" role="tabpanel"
                                aria-labelledby="pills-datos-tab">
                                <div class="row">

                                    <div class="col col-12">
                                        <div class="form-group">
                                            <label for="name" class="col-form-label">Nombre: <small>(<span
                                                        class="text-danger">*</span>)</small></label>
                                            <input type="text" class="form-control form-control-sm" id="name"
                                                name="name" required>
                                        </div>
                                    </div>
                                    {{-- <div class="col">
                                        <div class="form-group">
                                            <label for="entidad_id" class="col-form-label">Entidad</label>
                                            <select name="entidad_id" id="entidad_id"
                                                class=" form-control form-control-sm" style="width: 100%">
                                                <option value="">Todas</option>
                                                @foreach ($entidades as $ent)
                                                    <option value="{{ $ent->id }}"> {{ $ent->name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> --}}
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="desde" class="col-form-label">Fecha Desde: </label>
                                            <input autocomplete="off" type="date" class="form-control form-control-sm" id="desde"
                                                name="desde" >
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="hasta" class="col-form-label">Fecha Hasta: </label>
                                            <input autocomplete="off" type="date" class="form-control form-control-sm" id="hasta"
                                                name="hasta" >
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="precio" class="col-form-label">Precio Actual : <small>(<span
                                                        class="text-danger">*</span>)</small></label>
                                            <input type="text" class="form-control form-control-sm" id="precio_actual"
                                                name="precio_actual" value="0" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="costo" class="col-form-label">Precio Promo:  <small>(<span
                                                class="text-danger">*</span>)</small></label>
                                            <input type="text" class="form-control form-control-sm" id="precio_promo"
                                                name="precio_promo" value="0">
                                        </div>
                                    </div>
                                </div> --}}


                                <div class="row">
                                    {{-- <input type="text" name="properties[{{ $i }}][key]" class="form-control" value="{{ old('properties['.$i.'][key]') }}"> --}}
                                    @foreach ($dias as $key => $val)
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input dias" type="checkbox" value="" name="dias['{{ $key }}']" id="{{ $key }}" checked>
                                                <label class="form-check-label" for="{{ $key }}">
                                                  {{ ucwords($key) }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
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

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="activo"
                                                    name="activo" checked>
                                                <label for="activo" class="custom-control-label">Activo?</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-productos" role="tabpanel"
                                aria-labelledby="pills-productos-tab">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <select name="articulo" id="articulo" class="select2" style="width: 100%">
                                                <option value="">Elija un producto o Servicio</option>
                                                <optgroup label="Productos">
                                                    @foreach ($articulos as $pro)
                                                        @if ( $pro->tipo == 'producto' )
                                                            <option value="{{ $pro->id }}"> {{ $pro->name }} </option>
                                                        @endif
                                                    @endforeach
                                                </optgroup>
                                                <optgroup label="Servicios">
                                                    @foreach ($articulos as $ser)
                                                        @if ( $ser->tipo == 'servicio' )
                                                            <option value="{{ $ser->id }}">{{ $ser->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </optgroup>
                                                <optgroup label="Combos">
                                                    @foreach ($articulos as $com)
                                                        @if ( $com->tipo == 'combo' )
                                                            <option value="{{ $com->id }}">{{ $com->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="container">
                                    <table class="table table-striped" id="tabla-lista">
                                        <thead>
                                            <tr>
                                                <th>Cantidad</th>
                                                <th>Producto o Servicio</th>
                                                <th>Costo</th>
                                                <th>Precio Normal</th>
                                                <th>Precio Promo</th>
                                                <th>E.</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
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


    @php
        echo "var articulos = ".json_encode($articulos)."; ";
    @endphp

    $( document ).ready(function() {

            
$('.datepicker_eclusivo').datepicker({
                language:'es',
                dateFormat: "yy-mm-dd",
});
        var data = {
            table: "tablaCrud",
            ajax : "{{ route('admin.promos.datatable') }}",
            topMsg: "",
            footerMsg: "Generado: {{ auth()->user()->name }} {{ date("d/m/Y H:i") }}",
            filename: "Listado de Promos",
            title: 'Listado de Promos',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'activo', name: 'activo'},
                {data: 'desde', name: 'desde', title:'Desde'},
                {data: 'hasta', name: 'hasta', title:'Hasta'},
                {data: 'diasP', name: 'diasP', title:'Dias'},
                {data: 'sucursales', name: 'sucursales', title:'Sucursales'},
                {data: 'acciones', name: 'acciones', orderable: false, searchable: false, class: 'noexport'}
            ]
        };
        toDataTable(data);
    });


//como funciona 
    const Item = ({ id, name, costo, precio, cantidad,precio_promo }) => ` <tr id="tr_${id}">
                                                <td>
                                                    <input size="3" type="hidden" name="articulos[${id}][id]" id="opcion[][id]" value="${id}">
                                                    <input size="3" type="numeric" name="articulos[${id}][cantidad]" id="opcion[][cantidad]" value="${cantidad}" class="text-center">
                                                </td>
                                                <td>${name}</td>
                                                <td align="right">${costo}</td>
                                                <td align="right">
                                                    <input size="3" type="hidden" name="articulos[${id}][precio_actual]" id="opcion[][precio_actual]" value="${precio}">
                                                        ${precio}
                                                </td>
                                                <td align="right">
                                                    <input size="3" type="numeric" name="articulos[${id}][precio_promo]" id="opcion[][precio_promo]" value="${precio_promo}" class="text-center">
                                                </td>
                                                <td>
                                                    <a class="btn btn-danger btn-sm" role="button" onclick="eliminarProducto(${id})"> <i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>`;


    $('#articulo').on('change', function(){
        var id = $(this).val();

        if( id != '' ){
            console.log( 'articulo => ' +  id);
            var ele = articulos.find( item => item.id == id  );
            ele.cantidad = 1;
            ele.precio_promo = 0;
            console.log( ele );
            if(  $('#tr_'+ele.id).length > 0 ){
                toastr.options = { "closeButton": true, };
                toastr.error('Si desea puede modificar la cantidad, pero no puede duplicar el articulo', 'Ese articulo ya esta en la lista!');
            }else{
                $('#tabla-lista tbody').append( [ele].map(Item).join('') );
            }
            $(this).val('');
        }else{
            console.log('vacio');
        }

    });





    function eliminarProducto(articulo){

        var id = $('#id').val();
        var formData = new FormData($('#formCrud')[0]);
        formData.append('articulo_id', articulo);
        console.log(id, articulo);
        var ruta = " {{ route('admin.promos.producto.destroy') }} ";

        postData(ruta, formData).then(function(rta){
            console.log('postData OK'); console.log(rta);
            $('#tr_' + articulo).remove();
            toastr.options = { "closeButton": true, };
            toastr.success(rta['msg'], 'Buen Trabajo!');
        }).catch(function(error){
            console.log('postData dio error'); console.log(error);
            Swal.fire('Ocurrio un Error', error, 'error');
        });
    }


    $('[data-toggle="tooltip"]').tooltip();

    $('#formCrud').on('submit', function(e){
        e.preventDefault();

        if( $('#id').val()  ){
            console.log('update'); console.log( $('#id').val() );
            var ruta = "{{ route('admin.promos.update') }}";
            var formData = new FormData($('#formCrud')[0]);
            update(formData, ruta);
        }else{
            console.log('store');
            var formData = new FormData($('#formCrud')[0]);
            var ruta = "{{ route('admin.promos.store') }}";
            store(formData, ruta);
        }
        console.log(ruta);
    });


</script>
@stop



