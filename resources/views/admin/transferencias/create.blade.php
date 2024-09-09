@extends('adminlte::page')

@section('title', 'Agendas')


@section('content_header')

@stop
@section('content')
    @if (session('errors'))
        <div class="alert alert-danger">
            {{ session('errors')->first('message1') }}
        </div>
    @endif
    <form action="{{ route('admin.transfer.create') }}" method="POST" id="form-general">
        @csrf

        <div class="card shadow mb-3 col-md-12">
            <div class="mb-6">
                <div class="card-header py-3 " style="padding: 5px 10px 5px 10px !important; background:#F7B08C"
                    id="detalles">
                    <h5> <b>Transferencias de articulos</b> </h5>
                    <div class="form-row col-4">
                        <div class="col-1">
                            <label class="mt-1 mb-0">Fecha:</label>
                        </div>
                        <div class="col-7">
                            <input value="<?php echo date('Y-m-d'); ?>" id="fecha" name="fecha" type="date"
                                class="mr-3 form-control form-control-sm col-12" required>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding: 10px 10px 10px 0px;">
                    <div class="form-row border" style="background:#F7B08C">
                        <div class="col-5">
                            <div class="form-row col-12">
                                <div class="col">
                                    <div class="form-group" style="margin-bottom: 10px;">
                                        <label style="margin-bottom: 0;">Entidad Procedente</label>
                                        <select name="entidad_procedente" id="entidad_procedente"
                                            class="mr-3 form-control form-control-sm col-12" required>
                                            <option value="" selected disabled>Seleccione una Entidad</option>
                                            @foreach ($entidad as $d)
                                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row col-12">
                                <div class="col">
                                    <div class="form-group" style="margin-bottom: 10px;">
                                        <label style="margin-bottom: 0;">Sucursal Procedente</label>
                                        <select name="sucursal_procedente" id="sucursal_procedente"
                                            class="mr-3 form-control form-control-sm col-12" required>
                                            <option value="" selected disabled>Seleccione una Sucursal</option>
                                            @foreach ($sucursal as $d)
                                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row col-12">
                                <div class="col">
                                    <div class="form-group" style="margin-bottom: 10px;">
                                        <label style="margin-bottom: 0;">Depósito Procedente</label>
                                        <select name="deposito_procedente" id="deposito_procedente"
                                            class="mr-3 form-control form-control-sm col-12" required>
                                            <option value="" disabled>Seleccione un depósito</option>
                                            @foreach ($depositos_base as $d)
                                                @if ($d->es_real)
                                                    <option value="{{ $d->id }}">{{ $d->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <img src="{{ asset('img/detalles/arrow.gif') }}" class="img-fluid ml-5" style="width: 70%">
                        </div>
                        <div class="col-5">
                            <div class="form-row col-12">
                                <div class="col">
                                    <div class="form-group " style="margin-bottom: 10px;">
                                        <label style="margin-bottom: 0;">Entidad Destino</label>
                                        <select name="entidad_destino" id="entidad_destino"
                                            class="mr-3 form-control form-control-sm col-12" required>
                                            <option value="" selected disabled>Seleccione una Entidad</option>
                                            @foreach ($entidad as $d)
                                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row col-12">
                                <div class="col">
                                    <div class="form-group" style="margin-bottom: 10px;">
                                        <label style="margin-bottom: 0;">Sucursal Destino</label>
                                        <select name="sucursal_destino" id="sucursal_destino"
                                            class="mr-3 form-control form-control-sm col-12" required>
                                            <option value="" selected disabled>Seleccione una Sucursal</option>
                                            @foreach ($sucursal as $d)
                                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row col-12">
                                <div class="col">
                                    <div class="form-group " style="margin-bottom: 10px;">
                                        <label style="margin-bottom: 0;">Depósito Destino</label>
                                        <select name="deposito_destino" id="deposito_destino"
                                            class="mr-3 form-control form-control-sm col-12" required>
                                            <option value="" selected disabled>Seleccione un Deposito</option>
                                            @foreach ($depositos_base as $d)
                                                @if ($d->es_real)
                                                    <option value="{{ $d->id }}">{{ $d->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row col-12 mt-2" style="background:#F7B08C;padding: 10px 10px 10px 0px;">
                        <div class="col-5" style="text-align: center;">
                            <label style="margin-bottom: 0;">Productos</label>
                        </div>
                        <div class="col">
                            <div class="loader"></div>
                            <button class="btn-secondary ml-5" type="button" id="btn-guardar"> Guardar Transferencia
                            </button>
                        </div>
                        <div class="col" id="add_detalles_venta">
                            <button class="btn-primary" type="button"
                                style="width: 70%;
                                border-bottom-left-radius: 10px;
                                border-bottom-right-radius: 10px;
                                border-top-left-radius: 10px;
                                border-top-right-radius: 10px;">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <table class="table table-striped" id="tabla-venta" style="width: 100%;">
                            <thead>
                                <tr class="border">
                                    <th style="text-align: center">Cantidad</th>
                                    <th style="text-align: center">Articulo</th>
                                    <th style="text-align: center">Eliminar</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyid">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop
@section('js')
    <script src=" {{ asset('js/comunes.js') }} "></script>
    <script>
        $(document).ready(function() {
            @php
                echo ' var articulos_js = ' . json_encode($productos) . '; ';
                echo ' var entidades = ' . json_encode($entidad) . '; ';
                echo ' var sucursales = ' . json_encode($sucursal) . '; ';
                echo ' var depositos = ' . json_encode($depositos) . '; ';
            @endphp

            $("#entidad_procedente").change(function() {
                var numero_entidad = $('#entidad_procedente').val();

                $('#sucursal_procedente option').remove().promise().done(function() {
                    $.each(sucursales, function(i, item) {
                        if (numero_entidad == item.entidad_id) {
                            $("#sucursal_procedente").append("<option value=" + item.id +
                                ">" + item.name + "</option>");
                        }
                    });
                });
                $('#deposito_procedente option').remove().promise().done(function() {
                    $.each(depositos, function(i, item) {
                        if (item.es_real) {
                            if (numero_entidad == item.entidad_id) {
                                if (($("#sucursal_procedente").val() == item.sucursal_id) && (item.id !=$("#deposito_destino").val() ) ) {
                                    $("#deposito_procedente").append("<option value=" + item.id + ">" + item.name + "</option>");
                                }
                            }
                        }


                    });
                });
            });


            $("#sucursal_procedente").change(function() {
                var numero_entidad = $('#entidad_procedente').val();
                $('#deposito_procedente option').remove().promise().done(function() {
                    $.each(depositos, function(i, item) {
                        if (item.es_real) {if (numero_entidad == item.entidad_id) {
                            if (($("#sucursal_procedente").val() == item.sucursal_id) && (item.id !=$("#deposito_destino").val() ) ) {
                                $("#deposito_procedente").append("<option value=" + item
                                    .id + ">" + item.name + "</option>");
                            }
                        }}
                    });
                });
            });


            //------esto es para cuando se cambie para donde va
            $("#entidad_destino").change(function() {
                var numero_entidad = $('#entidad_destino').val();

                $('#sucursal_destino option').remove().promise().done(function() {
                    $.each(sucursales, function(i, item) {
                        if (numero_entidad == item.entidad_id) {
                            $("#sucursal_destino").append("<option value=" + item.id + ">" +
                                item.name + "</option>");
                        }

                    });
                });
                $('#deposito_destino option').remove().promise().done(function() {
                    $.each(depositos, function(i, item) {

                        if (item.es_real) { if (numero_entidad == item.entidad_id) {
                            if (($("#sucursal_destino").val() == item.sucursal_id) && (item.id !=$("#deposito_procedente").val() )  ) {
                                $("#deposito_destino").append("<option value=" + item.id +
                                    ">" + item.name + "</option>");
                            }
                        }}

                    });
                });
            });
            $("#sucursal_destino").change(function() {
                var numero_entidad = $('#entidad_destino').val();
                $('#deposito_destino option').remove().promise().done(function() {
                    $.each(depositos, function(i, item) {
                        if (item.es_real) {if (numero_entidad == item.entidad_id) {
                            if (($("#sucursal_destino").val() == item.sucursal_id)  && (item.id !=$("#deposito_procedente").val() ) ) {
                                $("#deposito_destino").append("<option value=" + item.id +
                                    ">" + item.name + "</option>");
                            }
                        }}
                    });
                });
            });
            $("#add_detalles_venta").click(function() {
                var optionsP = "";
                var optionsC = "";
                var op = {};
                articulos_js.map(function(x) {
                        optionsP += "<option value='" + x.id + "'> " + x.name + " </option>";
                    
                });
                op.optionsC = optionsC;
                op.optionsP = optionsP;
                $('#tbodyid').prepend([op].map(ItemDetalles).join(''));
                $('#tbodyid .fila_producto').each(function(e,data) {
                   $(this).find(".select3").select2()
                })
            });

            function getRandomArbitrary(min, max) {
                return Math.round(Math.random() * (max - min) + min);
            }

            function azarDetalle() {
                var num_li = $('#tbodyid').length + 1;
                num_li = (num_li * 1000) + getRandomArbitrary(1, 100);
                return num_li
            }
            const ItemDetalles = ({
                num_li = azarDetalle(),
                optionsC,
                optionsP
            }) => `
        <tr class="fila_producto">
            
            <td style="width:10%">
                <input type="text" class="form-control siempreCero text-right" value="0" id="detalles-cantidad" name="detalles[${num_li}][cantidad]">
            </td>
            <td style="width:30%">
                <select id="producto_id_${num_li}" class="select3 form-control" style="width: 100%"  name="detalles[${num_li}][articulo]">
                    <option value="0" selected disabled>Elija un producto</option>
                    <optgroup label="Productos">
                        ${optionsP}
                    </optgroup>
                </select>
            </td>
            <td style="width:5%">
                <button class="btn btn-danger remove_detalles"  type="button">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                </button>
            </td>
        </tr>
            `;

            $('#btn-guardar').on('click', function(e) {
                e.preventDefault();
                if (comprobarTrans()) {
                    if (comprobarDatos()) {
                        $ec = []
                        $('#tbodyid tr').each(function(e, data) {
                            var art = $(this).find("select[id^='producto_id']").val();
                            var cant = parseInt($(this).find("input[id='detalles-cantidad']")
                                .val());
                            $ec[e] = {
                                articulo: art,
                                cantidad: cant
                            }
                        })
                        $('#form-general').submit();
                        console.log("lan")
                    }
                }
            });

            function comprobarDatos() {
                var Errores = "";
                if (!$('#entidad_procedente').val()) {
                    Errores += "DEBE SELECCIONAR UNA ENTIDAD PROCEDENTE \n";
                } else if (!$('#sucursal_procedente').val()) {
                    Errores += "DEBE SELECCIONAR UNA SUCURSAL PROCEDENTE \n";
                } else if (!$('#deposito_procedente').val()) {
                    Errores += "DEBE SELECCIONAR UNA DEPOSITO PROCEDENTE \n";
                } else if (!$('#entidad_destino').val()) {
                    Errores += "DEBE SELECCIONAR UNA ENTIDAD DESTINO \n";
                } else if (!$('#sucursal_destino').val()) {
                    Errores += "DEBE SELECCIONAR UNA SUCURSAL DESTINO \n";
                } else if (!$('#deposito_destino').val()) {
                    Errores += "DEBE SELECCIONAR UNA DEPOSITO DESTINO \n";
                } else {
                    return true;
                }

                Swal.fire({
                    title: "Verifique las Transferencias ",
                    icon: 'warning',
                    html: Errores
                });
                return false;
            }

            function comprobarTrans() {
                var mensajes_de_error = "";
                var errores = 0;
                var unosolo1 = 0;
                unosolo1 = $('#tbodyid tr').length;
                $('#tbodyid tr').each(function(e, data) {
                    var cant = parseInt($(this).find("input[id='detalles-cantidad']").val());
                    var art = $(this).find("select[id^='producto_id']").val();
                    var ekk = articulos_js.find(item => item.id == art);
                    if (cant == 0) {
                        $(this).find("input[id='detalles-cantidad']").focus();
                        mensajes_de_error += "Por favor Seleccione una Cantidad linea N° " + e + " \n ";
                        errores = parseInt(errores) + 1;
                    }
                    if (art == null) {
                        $(this).find("select[id^='producto_id']").val();
                        mensajes_de_error += "Por favor Seleccione un Articulo linea  N° " + e + " \n ";
                        errores = parseInt(errores) + 1;
                    }
                })

                var uno = false;
                var dos = false;
                if (unosolo1 > 0) {
                    dos = true;
                } else {
                    Swal.fire({
                        title: "Verifique las Transferencias ",
                        icon: 'warning',
                        html: "DEBE SELECCIONAR POR LO MENOS UN PRODUCTO!"
                    });
                    setTimeout(function() {
                        $('.confirm').focus();
                    }, 200);
                    dos = false;
                }
                if (errores == 0) {
                    uno = true
                } else {
                    Swal.fire({
                        title: "Verifique las Ventas ",
                        icon: 'warning',
                        html: mensajes_de_error
                    });
                    setTimeout(function() {
                        $('.confirm').focus();
                    }, 200);
                }
                if ((uno) && (dos)) {
                    return true
                } else {
                    return false
                }
            }
        }); // ready
        @php
            echo ' var articulos_js = ' . json_encode($productos) . '; ';
            echo ' var entidades = ' . json_encode($entidad) . '; ';
            echo ' var sucursales = ' . json_encode($sucursal) . '; ';
            echo ' var depositos = ' . json_encode($depositos) . '; ';
        @endphp
        $(document).on("change", "select[id^='producto_id']", function() {
            var indice = $(this).closest(".fila_producto");
            var ele = articulos_js.find(item => item.id == this.value);
            // indice.find("input[id='detalles-precio']").val(puntear(ele.precio)) //aqui va con puntos
        });

        function puntear(num) {
            num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1.');
            num = num.split('').reverse().join('').replace(/^[\.]/, '');
            return num;
        }


        $(document).on("click", ".remove_detalles", function() {
            console.log("la")
            var indice = $(this).closest(".fila_producto");
            const remo = {
                fun: function() {
                    indice.remove();
                }
            }
            var message = "Desea eliminar este Producto";
            manejoErrores(message, remo, indice)
        });

        function manejoErrores(mesage, funcion, id) {
            Swal.fire({
                title: mesage,
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    funcion.fun.apply(id)
                }
            })
        }
    </script>
@stop
