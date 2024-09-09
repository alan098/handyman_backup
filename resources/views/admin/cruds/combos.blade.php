@extends('adminlte::page')


@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('content_header')
<h1>Combos</h1>
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
                        <th>Activo</th>
                        <th>P. Venta</th>
                        <th>P. Costo</th>
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
<div class="modal fade" id="formCrudModal"  role="dialog" aria-labelledby="formCrudModalTitle"
    aria-hidden="true">
    <div class="modal-dialog agrandar" role="document">
        <form id="formCrud">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formCrudModalTitle">Nuevo Combo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" id="tipo" name="tipo" value="combo">

                    <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-datos-tab" data-toggle="pill" href="#pills-datos" role="tab" aria-controls="pills-datos" aria-selected="true">Datos</a>
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
                                    <input type="hidden" class="form-control form-control-sm" id="precio"
                                    name="precio" value="0" required>
                                    {{-- <div class="col">
                                        <div class="form-group">
                                            <label for="precio" class="col-form-label">Precio de Venta: <small>(<span
                                                        class="text-danger">*</span>)</small></label>
                                           
                                        </div>
                                    </div> --}}
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="costo" class="col-form-label">Costo de Elaboración:</label>
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
                                <div class="row">
                                    <div class="col col-12">
                                        <div class="form-group">
                                            <label for="name" class="col-form-label">U%</label>
                                            <input type="text" class="form-control form-control-sm" id="porcentaje_utilidad"
                                            readonly >
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
                            <div class="tab-pane fade" id="pills-productos" role="tabpanel" aria-labelledby="pills-productos-tab">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <select name="articulo" id="articulo" class=" form-control select2" style="width: 100%">
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
                                                <th>Precio</th>
                                                <th>&nbsp;</th>
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

        var data = {
            table: "tablaCrud",
            ajax : "{{ route('admin.combos.datatable') }}",
            topMsg: "",
            footerMsg: "Generado: {{ auth()->user()->name }} {{ date("d/m/Y H:i") }}",
            filename: "Listado de Combos",
            title: 'Listado de Combos',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'codigo', name: 'codigo'},
                {data: 'name', name: 'name'},
                {data: 'activo', name: 'activo'},
                {data: 'precio', name: 'precio', title: 'P. Venta', className : "text-right"},
                {data: 'costo', name: 'costo', title:'P. Costo', className : "text-right"},
                {data: 'iva', name: 'iva', title:'Iva', className : "text-right"},
                {data: 'acciones', name: 'acciones', orderable: false, searchable: false, class: 'noexport'}
            ]
        };
        toDataTable(data);
    });

    const Item = ({ id, name, costo, precio, cantidad, precio_combo}) => ` <tr id="tr_${id}">
                                                <td>
                                                    <input size="3" type="hidden" name="articulos[${id}][id]" id="opcion[][id]" value="${id}">
                                                    <input size="3" type="numeric" name="articulos[${id}][cantidad]" id="opcion[][cantidad]" value="${cantidad}" class="text-center">
                                                </td>
                                                <td>${name}</td>
                                                <td align="right" class="costos">${costo}</td>
                                                <td align="right">
                                                    <input size="3" type="hidden" name="articulos[${id}][precio_actual]" id="opcion[][precio_actual]" value="${precio}">
                                                        ${precio}
                                                </td>
                                                <td align="right">
                                                    <input size="3" type="numeric" name="articulos[${id}][precio_combo]" id="opcion[][precio_combo]" value="${precio_combo}" class="text-center pre_com siempreCero">
                                                </td>
                                                <td>
                                                    <a class="btn btn-danger btn-sm" role="button" onclick="eliminarProducto(${id})"> <i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>`;

$(document).on("change", ".pre_com", function(){
    calcularCosto()
})
    $('#articulo').on('change', function(){
        var id = $(this).val();

        if( id != '' ){
            console.log( 'articulo => ' +  id);
            var ele = articulos.find( item => item.id == id  );
            ele.cantidad = 1;
            ele.precio_combo = 0;
            console.log( ele );
            if(  $('#tr_'+ele.id).length > 0 ){
                toastr.options = { "closeButton": true, };
                toastr.error('Si desea puede modificar la cantidad, pero no puede duplicar el articulo', 'Ese articulo ya esta en la lista!');
            }else{
                $('#tabla-lista tbody').append( [ele].map(Item).join('') ).promise().done(function(){
                    calcularCosto();
                });
            }
            $(this).val('');
        }else{
            console.log('vacio');
        }

    });

//  {
//     "id": 3,
//     "name": "Aceite Comun",
//     "precio": "5000",
//     "costo": "1000",
//     "tipo": "producto",
//     "cantidad": 1
// }
    function editarListar( ruta, rutaCallback ){ //kaka
        //console.log(ruta);
        $('#password').attr('placeholder', 'Solo ingrese si desea cambiar');
        $('#password').attr('required', false);

        getData(ruta).then(function(rta){
            //console.log('getData OK'); console.log(rta);
            populateForm('formCrud', JSON.parse( rta ) );

            getData(rutaCallback).then(function(data){
                console.log('rtaCallback OK'); console.log(data);
                    if(data.length > 0){
                        $.each(data, function (key, ele) {
                            console.log(ele);
                            $('#tabla-lista tbody').append( [ele].map(Item).join('') );
                        });
                }
                $('#formCrudModal').modal('show');
            }).catch(function(error){
                console.log('rtaCallback dio error'); console.log(error);
                Swal.fire('Ocurrio un Error', error.message, 'error');
            });



        }).catch(function(error){
            console.log('getData dio error'); console.log(error);
            Swal.fire('Ocurrio un Error', error.message, 'error');
        });
    }
    function eliminarProducto(articulo){

        var id = $('#id').val();
        var formData = new FormData($('#formCrud')[0]);
        formData.append('articulo_id', articulo);
        console.log(id, articulo);
        var ruta = " {{ route('admin.combos.producto.destroy') }} ";

        postData(ruta, formData).then(function(rta){
            console.log('postData OK'); console.log(rta);
            $('#tr_' + articulo).remove();
            toastr.options = { "closeButton": true, };
            toastr.success(rta['msg'], 'Buen Trabajo!');
            calcularCosto();
        }).catch(function(error){
            console.log('postData dio error'); console.log(error);
            Swal.fire('Ocurrio un Error', error, 'error');
        });
    }

    $('#precio').on('change', function(){
        calcularCosto();
    })

    function calcularCosto(){
        var costoTotal = 0;
        var precioTotal = 0;
        $('.costos').each(function(){
            var costo = parseInt($(this).html());
            costoTotal = costoTotal + costo;
        });
        $('.pre_com').each(function(){
            var precio = parseInt($(this).val());
            precioTotal = precioTotal + precio;
        });
        $('#costo').val(costoTotal);
        //calculamos porcentaje de utilidad
            var porcen= ((costoTotal * 100) /  precioTotal)
            console.log(costoTotal +" "+ precioTotal)
            $('#porcentaje_utilidad').val(porcen.toFixed(2));
        }
    $('[data-toggle="tooltip"]').tooltip();

    $('#formCrud').on('submit', function(e){
        e.preventDefault();

        if( $('#id').val()  ){
            console.log('update'); console.log( $('#id').val() );
            var ruta = "{{ route('admin.combos.update') }}";
            var formData = new FormData($('#formCrud')[0]);
            update(formData, ruta);
        }else{
            console.log('store');
            var formData = new FormData($('#formCrud')[0]);
            var ruta = "{{ route('admin.combos.store') }}";
            store(formData, ruta);
        }
        console.log(ruta);
    });


</script>
@stop
