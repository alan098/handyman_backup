@extends('adminlte::page')


@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        .redondo {
            display: block;
            width: 30px;
            height: 30px;
            border-radius: 50%;
        }
    </style>
@stop

@section('content_header')
    <h1>Servicios</h1>
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
                            <th>P. Costo</th>
                            <th>Iva</th>
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
    <div class="modal fade" id="formCrudModal" role="dialog" aria-labelledby="formCrudModalTitle" aria-hidden="true">
        <div class="modal-dialog agrandar" role="document">
            <form id="formCrud">
                @csrf
                <input type="hidden" id="id" name="id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formCrudModalTitle">Servicios</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-datos-tab" data-toggle="pill" href="#pills-datos"
                                    role="tab" aria-controls="pills-datos" aria-selected="true">Servicio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-productos-tab" data-toggle="pill" href="#pills-productos"
                                    role="tab" aria-controls="pills-productos" aria-selected="false">Insumos</a>
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
                                                <label for="entidad_id" class="col-form-label">Entidad</label>
                                                <select name="entidad_id" id="entidad_id"
                                                    class=" form-control form-control-sm" style="width: 100%">
                                                    <option value="">Todas</option>
                                                    @foreach ($entidades as $ent)
                                                        <option value="{{ $ent->id }}"> {{ $ent->name }} </option>
                                                    @endforeach
                                                </select>
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
                                                <label for="costo" class="col-form-label">Costo de Elaboración:</label>
                                                <input type="text" class="form-control form-control-sm" id="costo"
                                                    name="costo" value="0">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="precio" class="col-form-label">Duracion: <small>(<span
                                                            class="text-danger">*</span>)</small></label>
                                                <input type="time" class="form-control form-control-sm" id="end"
                                                    name="end" value="00:00" required>
                                            </div>
                                        </div>
                                        <style>

                                        </style>
                                        <div class="col-6">
                                            <div class="form">
                                                <label for="precio" class="col-form-label">Sume o Reste
                                                    Tiempo:<small>(<span class="text-danger">*</span>)</small></label>
                                                <div class="form form-inline">
                                                    <div class="col">
                                                        <button class="redondo mr-1 btn-primary" type="button"
                                                            id="sum_time"><i class="fa fa-plus"
                                                                aria-hidden="true"></i></button>
                                                    </div>
                                                    <div class="col">
                                                        <button class="redondo  btn-danger" type="button"
                                                            id="res_time"><i class="fas fa-minus"></i></button>
                                                    </div>
                                                    <div class="col-8"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="iva10"
                                                    name="iva" value="10" checked>
                                                <label for="iva10" class="custom-control-label">Iva 10%</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="iva5"
                                                    name="iva" value="5">
                                                <label for="iva5" class="custom-control-label">Iva 5%</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="excenta"
                                                    name="iva" value="0">
                                                <label for="excenta" class="custom-control-label">Excenta</label>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="activo"
                                                name="activo" checked>
                                            <label for="activo" class="custom-control-label">Activo?</label>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="pills-productos" role="tabpanel" aria-labelledby="pills-productos-tab">
                                    <div class="form-row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <select name="articulo" id="articulo" class=" form-control select2" style="width: 100%">
                                                    <option value="">Elija un producto o Servicio</option>
                                                    <optgroup label="Productos">
                                                        @foreach ($articulos as $pro)
                                                            @if ( $pro->tipo == 'insumo' )
                                                                <option value="{{ $pro->id }}"> {{ $pro->name }} </option>
                                                            @endif
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="container">
                                                <table class="table table-striped" id="tabla-lista">
                                                    <thead>
                                                        <tr>
                                                            <th>Insumo</th>
                                                            <th>Usar DE</th>
                                                            <th>Total</th>
                                                            <th>Descontar</th>
                                                            <th>Eliminar</th>
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
        $(document).ready(function() {

            var data = {
                table: "tablaCrud",
                ajax: "{{ route('admin.servicios.datatable') }}",
                topMsg: "",
                footerMsg: "Generado: {{ auth()->user()->name }} {{ date('d/m/Y H:i') }}",
                filename: "Listado de Servicios",
                title: 'Listado de Servicios',
                columns: [
                    { data: 'id', name: 'id'},
                    { data: 'codigo', name: 'codigo'},
                    { data: 'name', name: 'name'},
                    { data: 'categoria_name', name: 'categoria_name'},
                    { data: 'activo', name: 'activo'},
                    { data: 'precio', name: 'precio', title: 'P. Venta', className: "text-right"},
                    {data: 'costo',name: 'costo',title: 'P. Costo',className: "text-right"},
                    { data: 'iva', name: 'iva', title: 'Iva', className: "text-right"},
                    { data: 'entidad_name', name: 'entidad_name', title: 'Entidad'},

                    { data: 'acciones', name: 'acciones', orderable: false, searchable: false, class: 'noexport'
                    }
                ]
            };
            toDataTable(data);
            // $('.select2').select2();
        });

        const Item = ({ id, name, cantidad,total,descontar}) => ` <tr id="tr_${id}" class="tr_art">
                                                <td>${name}</td>
                                                <td>
                                                    <input size="3" type="hidden" name="articulos[${id}][id]" id="opcion[][id]" value="${id}">
                                                    <input size="3" type="text" name="articulos[${id}][cantidad]" id="cantidad"  value="${cantidad}" class="text-center form-control siempreCero calculo">
                                                </td>
                                                <td>
                                                    <input size="3" type="text" name="articulos[${id}][total]" id="totalidad"  value="${total}" class="text-center form-control siempreCero calculo">
                                                </td>
                                                <td>
                                                    <input size="3" type="text" name="articulos[${id}][descontar]" id="descontar" value="${descontar}" class="text-center form-control" readOnly>
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
            ele.total = ele.cantidad_en_paquetes;
            ele.descontar = 0;
            if(  $('#tr_'+ele.id).length > 0 ){
                toastr.options = { "closeButton": true, };
                toastr.error('Si desea puede modificar la cantidad, pero no puede duplicar el articulo', 'Ese articulo ya esta en la lista!');
            }else{
                $('#tabla-lista tbody').append( [ele].map(Item).join('') ).promise().done(function(){
                });
            }
            $(this).val('');
            $('.calculo').trigger('change')
        }else{
            console.log('vacio');
        }

    });
    $(document).on("change", ".calculo", function(){
        var ca=parseInt($(this).closest( ".tr_art" ).find("input[id='cantidad']").val().replace(/\./g,''));
        var to=parseInt($(this).closest( ".tr_art" ).find("input[id='totalidad']").val().replace(/\./g,''));
        if ((ca > 0) && (to > 0) ) {
            console.log("calculo..")
            var total = ca / to;
            $(this).closest( ".tr_art" ).find("input[id='descontar']").val(total)
        }
        
    })
    function eliminarProducto(articulo){
    var id = $('#id').val();
    var formData = new FormData($('#formCrud')[0]);
    formData.append('articulo_id', articulo);
    var ruta = " {{ route('admin.servicios.producto.destroy') }} ";

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


        function editSpecial(rutaBase,rutaCallback) {
            console.log(rutaCallback);
            getData(rutaBase).then(function(rta) {
                populateForm('formCrud', JSON.parse(rta));
                getData(rutaCallback).then(function(data){
                    if(data.length > 0){
                        $.each(data, function (key, ele) {
                            $('#tabla-lista tbody').append( [ele].map(Item).join('') );
                        });
                }
                $('#formCrudModal').modal('show');
                }).catch(function(error){
                    console.log('rtaCallback dio error'); console.log(error);
                    Swal.fire('Ocurrio un Error', error.message, 'error');
                });
            }).catch(function(error) {
                console.log('getData dio error');
                console.log(error);
                Swal.fire('Ocurrio un Error', error.message, 'error');
            });
        }
        $("#sum_time").click(function(e) {
            e.preventDefault(); //no borrar este hace la magia
            e.stopImmediatePropagation(); //este tampoco
            $(this).attr('disabled', 'true')
            if ($('#end').val() != '24:00') {
                sumHours($('#end').val(), '00:15', '#nullo', '#end', '#nullo')
            } else {
                console.log("no sumar")
            }
            $(this).attr('disabled', false)
        });
        $("#res_time").click(function(e) {
            e.preventDefault(); //no borrar este hace la magia
            e.stopImmediatePropagation(); //este tampoco
            $(this).attr('disabled', 'true')
            var repla1 = $('#end').val().split(':');
            if ($('#end').val() != '00:00') {
                resHours($('#end').val(), '00:15', '#nullo', '#end', '#nullo')
            } else {
                console.log("no restar")
            }
            $(this).attr('disabled', false)
        });

        $('[data-toggle="tooltip"]').tooltip();

        $('#formCrud').on('submit', function(e) {
            e.preventDefault();
            if ($('#id').val()) {
                console.log($('#id').val());
                var ruta = "{{ route('admin.servicios.update') }}";
                var formData = new FormData($('#formCrud')[0]);
                update(formData, ruta);
            } else {
                console.log('store');
                var formData = new FormData($('#formCrud')[0]);
                var ruta = "{{ route('admin.servicios.store') }}";
                store(formData, ruta);
            }
        });
    </script>
@stop
