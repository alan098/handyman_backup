@extends('adminlte::page')

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('title', 'Agendas')


@section('content_header')
    <h1>Venta / Cuenta</h1>
@stop

@section('content')
    {{-- secciones de modales --}}
    <form id="form-general">
        <input type="hidden" name="venta_id" value="{{ $id_venta }}">
        <input type="hidden" name="giftcard_id" value="{{ $gif->id }}">
        @include('admin.ventas.modales.modal_medios')
        @include('admin.ventas.modales.modal_promos')
        @include('admin.ventas.modales.modal_persona')
        <input type="hidden" id="aplicar_promocion" value="no">
        <div class="card">
            <div class="card-header">
                @if (!empty($detalles))
                    Detalles de la venta
                @else
                    REGISTRAR VENTA / CUENTA
                @endif
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                @include('admin.ventas.html_base.card_medios')
                </div>
                    <div class="col-lg-6    ">
                        {{-- clienetes --}}
                        @include('admin.ventas.html_base.card_cliente')
                    </div>
                </div>
            </div>
        </div>
        {{-- detalles --}}
        @include('admin.ventas.html_base.card_detalles')
        <input type="hidden" id="cargando" value="si">

    </form>
@stop
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.css">
@stop
@section('js')
    <script src=" {{ asset('js/comunes.js') }} "></script>
    <script>
        @php
            echo 'var articulos_js = ' . json_encode($articulos) . '; ';
            echo 'var personas_js = ' . json_encode($clientes) . '; ';
            echo 'var cuentas_js = ' . json_encode($cuentas) . '; ';
            echo 'var medios_js = ' . json_encode($medios) . '; ';
            echo 'var bancos_js = ' . json_encode($bancos) . '; ';
            echo 'var promos_js = ' . json_encode($promos) . '; ';
            echo 'var colaboradores_js = ' . json_encode($colaboradores) . '; ';
            echo 'var combos_js = ' . json_encode($combos) . '; ';
            echo 'var ventas_js = ' . json_encode($venta) . '; ';
            echo 'var gifDe_js = ' . json_encode($gifDe) . '; ';
            echo 'var gif_js = ' . json_encode($gif) . '; ';
            echo 'var id_venta_js = ' . json_encode($id_venta) . '; ';
            echo 'var timbrados_js = ' . json_encode($timbrados) . '; ';
            echo 'var comisiones_js = ' . json_encode($comisiones) . '; ';
        @endphp
        //seccion guardar
        $(document).ready(function() {
            if ($('#timbrado_id').length != 0) {
                $('#timbrado_id').trigger('change');
            }
            $('#carga_page').css('display','block');
        })
        $('#btn-guardar').on('click', function(e) {
            e.preventDefault();
            if (comprobarMedios()) {
                if (comprobarVentas()) {
                    if (comprobarCliente()) {
                        var importeT = parseInt($('#total-pagar').html());
                        $ec = []
                        $('#formDatosDetalles #tabla-lista-detalles tr').each(function(e, data) {
                            var art = $(this).find("select[id='producto_id']").val();
                            var cant = parseInt($(this).find("input[id='detalles-cantidad']").val());
                            $ec[e] = {
                                articulo: art,
                                cantidad: cant
                            }
                        })
                        cargando('show', '50px', '#btn-guardar');
                        var formData = new FormData();
                        formData.append('detalles', JSON.stringify($ec));
                        formData.append('_token', '{{ csrf_token() }}');
                        var ruta = "{{ route('admin.vender.existencia') }}";
                        postData(ruta, formData).then(function(rta) {
                            if (rta.cod == 200) {
                                cargando('show', '50px', '#btn-guardar');
                                var formData = new FormData($('#form-general')[0]);
                                formData.append('_token', '{{ csrf_token() }}');
                                formData.append('importeT', importeT); //esto es para comparar
                                var ruta = "{{ route('admin.giftcard.cerrar') }}";
                                postData(ruta, formData).then(function(rta) {
                                    if (rta.cod == 200) {
                                        toastr.options = {
                                            "closeButton": true,
                                        };
                                        toastr.success(rta['msg'], 'Buen Trabajo!');
                                        setTimeout(function() {
                                            window.location.href =
                                                "{{ route('admin.giftcard.index') }}";
                                            cargando('hide', '50px', '#btn-guardar');
                                        }, 1000)
                                    }
                                }).catch(function(error) {
                                    console.log('postData dio error');
                                    console.log(error);
                                    Swal.fire('Ocurrio un Error', error, 'error');
                                })
                            }
                        }).catch(function(error) {
                            console.log('postData dio error');
                            console.log(error);
                            cargando('hide', '50px', '#btn-guardar');
                            Swal.fire('Hola esta es una alerta', error.msg, 'warning');
                        })
                    }
                }
            }
        });

        function tiempoEspera() {
            let timerInterval
            Swal.fire({
                title: 'Espere Mientras Se genera su factura',
                html: '<b></b>Tiempo en Milisegundos.',
                timer: 3000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                    const b = Swal.getHtmlContainer().querySelector('b')
                    timerInterval = setInterval(() => {
                        b.textContent = Swal.getTimerLeft()
                    }, 100)
                },
                willClose: () => {
                    clearInterval(timerInterval)
                }
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {

                }
            })
        }


        $('#btn-factura-imprimir').on('click', function(e) {
            var ventana;
            let url = "{{ route('admin.facturar', ':id') }}";
            url = url.replace(':id', id_venta_js);
            ventana = window.open(url, '_');
            setTimeout(function() {
                ventana.close();
            }, 4000);
        })

        function manejoErroresCancel(mesage, funcion) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
            Swal.fire({
                title: mesage,
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Imprimir Factura',
                cancelButtonText: "Ir a Cuentas",
            }).then((result) => {
                if (result.isConfirmed) {
                    funcion.fun.apply()
                } else if (!result.isConfirmed) {
                    funcion.clos.apply()
                }
            })
        }

        function comprobarCliente() {
            if (!$("#form-cliente #cliente_id").val()) {
                Swal.fire({
                    title: "Verifique El Cliente",
                    icon: 'warning',
                    html: "Debe seleccionar un cliente!"
                });
                return false
            } else {
                return true
            }
        }

        function comprobarVentas() {
            var mensajes_de_error = "";
            var errores = 0;
            var unosolo1 = 0;
            var unosolo2 = 0;
            unosolo1 = $('#formDatosDetalles #tabla-lista-detalles tr').length;
            $('#formDatosDetalles #tabla-lista-detalles tr').each(function(e, data) {
                var cant = parseInt($(this).find("input[id='detalles-cantidad']").val());
                var prec = parseInt($(this).find("input[id='detalles-precio']").val().replace(/\./g, ''));
                var art = $(this).find("select[id='producto_id']").val();
                if (cant == 0) {
                    $(this).find("input[id='detalles-cantidad']").focus();
                    mensajes_de_error += "+Producto+ Por favor Seleccione una Cantidad linea N° " + e + " \n ";
                    errores = parseInt(errores) + 1;
                }
                if (prec == 0) {
                    $(this).find("input[id='detalles-precio']").focus();
                    mensajes_de_error += "+Producto+ Por favor Seleccione un Precio linea  N° " + e + " \n ";
                    errores = parseInt(errores) + 1;
                }
                if (art == null) {
                    $(this).find("select[id='producto_id']").val();
                    mensajes_de_error += "+Producto+ Por favor Seleccione un Articulo linea  N° " + e + " \n ";
                    errores = parseInt(errores) + 1;
                }

            })
            //errores de  servicio
            var errors = 0;
            mensajes_de_errorS = "";

            unosolo2 = $('#formServicios #tabla-lista tbody tr').length
            $('#formServicios #tabla-lista tbody tr').each(function(e, data) {
                var cant = parseInt($(this).find("input[id='cantidad_servicio']").val());
                var prec = parseInt($(this).find("input[id='precio_servicio']").val().replace(/\./g, ''));
                var art = $(this).find("input[id='cantidad_servicio']").attr('servicio');
                var col = $(this).find("select[id='colaborador_id']").val();
                var ini = $(this).find("input[id='servicio_ini_']").val();
                var fin = $(this).find("input[id='servicio_fin_']").val();
                if (cant == 0) {
                    $(this).find("input[id='cantidad_servicio']").focus();
                    mensajes_de_errorS += "+Servicio+ Por favor Seleccione una Cantidad linea N° " + e + " \n ";
                    errors = parseInt(errors) + 1;
                }
                if (prec == 0) {
                    $(this).find("input[id='precio_servicio']").focus();
                    mensajes_de_errorS += "+Servicio+ Por favor Seleccione un Precio linea  N° " + e + " \n ";
                    errors = parseInt(errors) + 1;
                }
                if (!col) {
                    $(this).find("select[id='colaborador_id']").focus();
                    mensajes_de_errorS += "+Servicio+ Por favor Seleccione un Articulo linea  N° " + e + " \n ";
                    errors = parseInt(errors) + 1;
                }
                if (!ini) {
                    $(this).find("input[id='servicio_ini_']").focus();
                    mensajes_de_errorS += "+Servicio+ Por favor Seleccione una fecha de inicio linea  N° " + e +
                        " \n ";
                    errors = parseInt(errors) + 1;
                }
                if (!fin) {
                    $(this).find("input[id='servicio_fin_']").focus();
                    mensajes_de_errorS += "+Servicio+ Por favor Seleccione una fecha de fin linea  N° " + e +
                    " \n ";
                    errors = parseInt(errors) + 1;
                }
            });

            var uno = false;
            var dos = false;
            var tres = false;
            if ((unosolo1 > 0) || (unosolo2 > 0)) {
                tres = true;
            } else {
                Swal.fire({
                    title: "Verifique las Ventas ",
                    icon: 'warning',
                    html: "DEBE SELECCIONAR UN PRODUCTO O SERVICIO!"
                });
                setTimeout(function() {
                    $('.confirm').focus();
                }, 200);
                tres = false;
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
            if (errors == 0) {
                dos = true;
            } else {
                Swal.fire({
                    title: "Verifique las Ventas",
                    icon: 'warning',
                    html: mensajes_de_errorS
                });
                setTimeout(function() {
                    $('.confirm').focus();
                }, 200);
            }
            if ((uno) && (dos) && (tres)) {
                return true
            } else {
                return false
            }
        }

        function comprobarMedios() {
            var importe_venta = parseInt($('#total-pagar').html());
            var saldo = gif_js.saldo
            if (importe_venta <= saldo) {
                return true;
            } else {
                Swal.fire({
                    title: "Lo siento el saldo es insuficiente",
                    icon: 'warning',
                    html: "solo queda: " + saldo + " de Saldo"
                });
                return false;
            }
        }

        function disponibilidad() {
            var _url = "{{ route('admin.vender.disponibilidad') }}";
            var ele = articulos_js.find(item => item.id == $('#formServicios #servicio_id').val());
            var formData = new FormData();
            formData.append('fecha', $('#fecha').val());
            formData.append('desde', $('#formServicios #ini_show').val());
            formData.append('hasta', $('#formServicios #fin_show').val());
            formData.append('colaborador', $('#formServicios #colaborador_id').val());
            formData.append('servicio', ele.id);
            formData.append('_token', '{{ csrf_token() }}');
            postData(_url, formData).then(function(rta) {
                if (rta.dis == 0) {
                    var ele = articulos_js.find(item => item.id == $('#formServicios #servicio_id').val());
                    //verificamos promo
                    if (promos_js.cod == 200) {
                        var ar_pr = promos_js.data.ar_c_pr;
                        const found = ar_pr.find(element => element == $('#formServicios #servicio_id').val());
                        if (found) {
                            generales = $('#formDatosDetalles #tabla-lista-detalles .fila_producto').last()
                            promoArticulos($('#formServicios #servicio_id').val(), 'servicio');
                        } else {
                            insertarService()
                        }
                    } else {
                        insertarService()
                    }
                } else {
                    toadErrores("Error este colaborador ya tiene una cita asignada en ese horario")
                }
            }).catch(function(error) {
                console.log('postData dio error');
                console.log(error);
                Swal.fire('Ocurrio un Error', error, 'error');
            })
        }

        function insertarService(read = "readOnly") {
            var ele = articulos_js.find(item => item.id == $('#formServicios #servicio_id').val());
            ele.fecha = $('#fecha').val();
            ele.desde = $('#formServicios #ini_show').val();
            ele.hasta = $('#formServicios #fin_show').val();
            ele.colaborador = $('#formServicios #colaborador_id option:selected').text();
            ele.colaborador_id = $('#formServicios #colaborador_id').val();
            ele.servicio = ele.name;
            ele.servicio_id = ele.id;
            ele.iva = ele.iva;
            ele.precio_actual = puntear(ele.precio); //aqui va con puntos
            ele.precio_real = puntear(ele.precio);
            ele.read = read;
            var optionsm = "";
            colaboradores_js.map(function(c) {
                if (c.id == ele.colaborador_id) {
                    optionsm += "<option value='" + c.id + "'> " + c.name + " </option>";
                }

            });
            ele.optionsm = optionsm;
            //porcentaje
            var por = comisiones_js.find(item => ((item.colaborador_id == ele.colaborador_id) && (item.servicio_id == ele
                .id)));
            if (por) {
                ele.porcentaje_colaborador = por.porcentaje;
            }
            $('#formServicios #tabla-lista tbody').append([ele].map(ItemServicios).join('')).promise().done(function() {});
            reset()
            CalculosDetalles()
            toastr.success("", 'Buen Trabajo!');
        }

        function verificar_hora(el) {
            var ini = $(el).closest(".servicio_datos").find("[id='servicio_ini_']").val();
            var fin = $(el).closest(".servicio_datos").find("[id='servicio_fin_']").val();
            var cola = $(el).closest(".servicio_datos").find("[id='colaborador_id']").val();
            if (!ini) {
                toadErrores("Coloque el horario de inicio para verificar");
            } else if (!fin) {
                toadErrores("Coloque el horario de fin para verificar");
            } else if (!cola) {
                toadErrores("Selecciona un colaborador");
            } else {
                var _url = "{{ route('admin.vender.disponibilidad') }}";
                var formData = new FormData();
                formData.append('fecha', $('#fecha').val());
                formData.append('desde', ini);
                formData.append('hasta', fin);
                formData.append('colaborador', cola);
                formData.append('servicio', "0");
                formData.append('_token', '{{ csrf_token() }}');
                postData(_url, formData).then(function(rta) {
                    if (rta.dis == 0) {
                        //bloqueamos todo
                        $(el).closest(".servicio_datos").find("[id='servicio_ini_']").attr('readonly', true);
                        $(el).closest(".servicio_datos").find("[id='servicio_fin_']").attr('readonly', true);
                        $(el).closest(".servicio_datos").find("[id='colaborador_id']").attr('readonly', true);
                        toastr.success('Exito', 'Buen Trabajo!');
                    } else {
                        toadErrores("Error este colaborador ya tiene una cita asignada en ese horario")
                    }
                }).catch(function(error) {
                    console.log('postData dio error');
                    console.log(error);
                    Swal.fire('Ocurrio un Error', error, 'error');
                })
            }
        }

        $('#sumbitButton').on('click', function(e) {
            e.preventDefault();
            var formData = new FormData($('#for_persona')[0]);
            console.log(formData);
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('ruc', $('#ruc_persona').val());
            formData.append('name', $('#name_persona').val());
            formData.append('nombre_fantasia', $('#nombre_fantasia_persona').val());
            formData.append('direccion', $('#direccion_persona').val());
            formData.append('telefono', $('#telefono_persona').val());
            formData.append('email', $('#email_persona').val());
            formData.append('es_cliente', $('#es_cliente_persona').val());
            formData.append('es_proveedor', $('#es_proveedor_persona').val());
            var ruta = "{{ route('admin.personas.store') }}";
            postData(ruta, formData).then(function(rta) {
                toastr.success(rta.msg, 'Buen Trabajo!');
                $('#modal_persona').modal('hide');
                var per = "{{ route('admin.vender.clientes') }}"
                getData(per).then(function(rta) {
                    $('#form-cliente #cliente_id option').remove().promise().done(function() {
                        $.each(rta['clientes'], function(i, item) {
                            if (item.ruc == $('#ruc_persona').val()) {
                                $("#form-cliente #cliente_id").append(
                                    "<option value=" + item.id + " selected> " +
                                    item.ruc + "-" + item.name + "</option>");
                            } else {
                                $("#form-cliente #cliente_id").append(
                                    "<option value=" + item.id + "> " + item
                                    .ruc + "-" + item.name + "</option>");
                            }

                        });
                    });

                    vaciarModal()
                }).catch(function(error) {
                    console.log('getData dio error');
                    console.log(error);
                    Swal.fire('Ocurrio un Error', error.message, 'error');
                });
            }).catch(function(error) {
                cargando('hide', '50px', '#btn-guardar');
                Swal.fire('Hola esta es una alerta', error.msg, 'warning');
            })
        });






        //apartir de aqui se carga lo que seria ventas gifcard
        $(document).ready(function() {
            var venta = ventas_js.venta; //este no varia
            var detalle = gifDe_js;
            var medios = ventas_js.medios; //este no varia
            //clientes
            $("#form-cliente #cliente_id").val(venta.cliente_id);
            $('#form-cliente #cliente_id').trigger('change');
            $("#form-cliente #cliente_id").attr('readonly', true);
            //fecha
            $('#fecha').val(venta.fecha)
            //condicion
            $('#condicion_venta').val(venta.condicion_id)
            //detalles gifcard
            $("#form-cliente #persona_regalada").val(gif_js.name);
            $("#form-cliente #numero_giftcard").val(gif_js.numero_gifcard);
            $("#form-cliente #importe_gif").val(gif_js.importe).trigger('change');
            $("#form-cliente #saldo_gif").val(gif_js.saldo).trigger('change');

            $("#medios_pagos").attr('disabled', true)
            // los medios de pago 

            if (!venta.es_gentileza) {
                medios.forEach(function callback(ele, index, array) {
                    if (index != 0) {
                        $("#añadir").click();
                    }
                    $('#modal_medios_pagos #formMedios .fila_medio').each(function(e, data) {
                        if (e == index) {
                            $(this).find("[id='met_medio']").val(ele.medio_cobro_id);
                            $(this).find("[id='met_medio']").trigger('change');
                            poblar(this, ele)
                        }
                    });
                });
            }

            calcularImporte();

            function poblar(index, ele) {
                $(index).find("[id='met_documento']").val(ele.documento);
                $(index).find("[id='met_monto']").val(puntear(ele.importe)); //aqui deberia ir con puntos
                $(index).find("[id='met_fecha_ini']").val(ele.fecha_ini_vigencia);
                $(index).find("[id='met_fecha_fin']").val(ele.fecha_fin_vigencia);
                $(index).find("[id='met_banco']").val(ele.banco_id);
                $(index).find("[id='met_banco']").trigger('change');
                $(index).find("[id='met_tarjeta']").val(ele.tarjeta_id);
                $(index).find("[id='met_tarjeta']").trigger('change');
                $(index).find("[id='met_cuenta']").val(ele.cuenta_id);
                $(index).find("[id='met_cuenta']").trigger('change');
            }
            // productos // servicios
            if (detalle) {
                redit(detalle).then(function(rta) {
                    $('#cargando').val('no');
                }).catch(function(error) {
                    console.log(error);
                    Swal.fire({
                        title: "Ocurrio un error comuniquese con soporte y mantenimiento",
                        icon: 'warning',
                        html: ""
                    });
                })
            }

            function redit(promesa) {
                var longitud_promesa = promesa.length; //1 2 3
                return new Promise(function(resolve, reject) {
                    promesa.forEach(function callback(ele, index, array) {
                        $('#formDatosDetalles #tabla-lista-detalles .fila_producto').each(function(
                            e, data) {
                            if (e == index) {
                                var art = articulos_js.find(item => item.id == ele
                                    .articulo_id);
                                if (art.tipo == 'producto') {
                                    $(this).find("[id='producto_id']").val(art.id)
                                    $(this).find("[id='producto_id']").trigger('change');
                                    $(this).find("[id='detalles-precio']").val(puntear(ele
                                        .importe))
                                    $(this).find("[id='detalles-cantidad']").val(1)
                                    $(this).find("[id='detalle_iva']").val(1)
                                    $("#add_detalles_venta").click();
                                    CalculosDetalles()
                                }
                                if (e == (longitud_promesa - 1)) {
                                    resolve(true);
                                }
                            }
                        })
                    })
                })
            }
            // esto es para los evento que ahun no existen deben ser los de gifcard detalles 
            detalle.forEach(function callback(ele, index, array) {
                var artse = articulos_js.find(item => item.id == ele.articulo_id);
                if (artse.tipo == 'servicio') {
                    insertarServiceVacio(artse.id)
                }
            })

            function insertarServiceVacio(id) {
                var ele = articulos_js.find(item => item.id == id);
                ele.fecha = $('#fecha').val();
                ele.desde = '';
                ele.hasta = '';
                ele.colaborador_id = '';
                ele.servicio = ele.name;
                ele.servicio_id = ele.id;
                ele.precio_actual = puntear(ele.precio); //aqui va con puntos
                ele.precio_real = puntear(ele.precio);
                var optionsm = "";
                colaboradores_js.map(function(c) {
                    optionsm += "<option value='" + c.id + "'> " + c.name + " </option>";
                });
                ele.optionsm = optionsm;
                $('#formServicios #tabla-lista tbody').append([ele].map(ItemServicios).join(''));
                var ultimo = $('#formServicios #tabla-lista tbody tr').last()
                CalculosDetalles()
            }
            setTimeout(function() {
                $('#modal_promos').modal('hide');
            }, 2000);
        });
    </script>
    <script src=" {{ asset('js/logicaVentas.js') }} "></script>


@stop
