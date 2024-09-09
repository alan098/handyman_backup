@extends('adminlte::page')

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('title', 'Agendas')


@section('content_header')
@include('error.error')
    <h1>Venta / Cuenta</h1>
@stop

@section('content')
    {{-- secciones de modales --}}
    <form id="form-general" method="POST" action="{{ route('admin.ventaaas.general') }}">

        @csrf
        <input type="hidden" name="venta_id" value="0">
        @include('admin.ventas_dos.modales.modal_descuento')
        @include('admin.ventas_dos.modales.modal_medios')
        @include('admin.ventas_dos.modales.modal_promos')
        @include('admin.ventas_dos.modales.modal_persona')
        <input type="hidden" id="aplicar_promocion" value="no">
        {{-- detalles --}}
        @include('admin.ventas_dos.html_base.card_detalles')
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
                        {{-- medios --}}
                        @include('admin.ventas_dos.html_base.card_medios')
                    </div>
                    <div class="col-lg-6">
                        {{-- clienetes --}}
                        @include('admin.ventas_dos.html_base.card_cliente')
                    </div>
                </div>
            </div>
            @include('admin.ventas_dos.html_base.footer')
        </div>
    </form>
    <input type="hidden" id="cargando" value="no">
@stop
@section('css')
@stop

@section('js')
    <script src=" {{ asset('js/comunes.js') }} "></script>
    <script>
        @php
            echo 'var articulos_js = ' . json_encode($articulos) . '; ';
            echo 'var cuentas_js = ' . json_encode($cuentas) . '; ';
            echo 'var medios_js = ' . json_encode($medios) . '; ';
            echo 'var bancos_js = ' . json_encode($bancos) . '; ';
            echo 'var promos_js = ' . json_encode($promos) . '; ';
            echo 'var combos_js = ' . json_encode($combos) . '; ';
            echo 'var timbrados_js = ' . json_encode($timbrados) . '; ';
            echo 'var colaboradores_js = ' . json_encode($colaboradores) . '; ';
            echo 'var comisiones_js = ' . json_encode($comisiones) . '; ';
            echo 'var users_js = ' . json_encode($users) . '; ';
            echo 'var parametros_js = ' . json_encode($parametros) . '; ';

        @endphp
        var url_cliente='{{route("admin.ventaaas.contacto")}}'
        //seccion guardar
        //preguntamos si existe timbrado
        var horarios = [];
        $(document).ready(function() {
            if ($('#timbrado_id').length != 0) {
                $('#timbrado_id').trigger('change');
            }
            logicaDescuentos()
            $('.js-data-clientes-ajax').select2({
                minimumInputLength: 2,
                minimumResultsForSearch: 10,
                ajax: {
                    url: '{{ route('admin.lista_reserva.clientes') }}',
                    dataType: "json",
                    type: "GET",
                    data: function(params) {
                        var queryParameters = {
                            term: params.term
                        }
                        return queryParameters;
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.text,
                                    id: item.id
                                }
                            })
                        };
                    }
                }
            });
            //una ve que cargue todo recien nos movemos
            $('#carga_lenta').css("display", "block")
        })
        var descuento_mometaneo = "";
        $('#btn-guardar').on('click', function(e) {
            e.preventDefault();
            if (comprobarMedios()) {
                if (comprobarVentas()) {
                    if (comprobarCliente()) {
                        if(($('#con_cierre3').prop('checked')) && (!$('#numero_timbrado').val() > 0 )){
                            $('#numero_timbrado').focus();
                            Swal.fire({
                                title: "DEBE PROPORCIONAR UN NUMERO DE FACTURA",
                                icon: 'warning',
                                html: ""
                            });
                        }else{
                        var mediosT = $('#input-total-fuera').val();
                        var importeT = parseInt($('#total-pagar').html());
                        var gentileza = 'false';
                        if (($('#formResumen #seccion_descuento').css('display') == 'block') && ($('#descuento_porcentaje').val() == 100)) {
                            mediosT = 0;
                            gentileza = 'true';
                        }
                        if ((gentileza == "true") && (!$('#exampleFormControlTextarea1').val())) {
                            $('#exampleFormControlTextarea1').focus();
                            Swal.fire({
                                title: "Las ventas por gentileza necesitan una observacion",
                                icon: 'warning',
                                html: ""
                            });
                        } else {
                            if (importeT != mediosT) {
                                Swal.fire({
                                    title: "El Importe No coincide con el pago",
                                    icon: 'warning',
                                    html: "Verifique antes de continuar"
                                });
                                $('#modal_medios_pagos').modal('show');
                            } else {
                                $ec = []
                                $('#formDatosDetalles #tabla-lista-detalles tr').each(function(e, data) {
                                    var art = $(this).find("select[id='producto_id']").val();
                                    var cant = parseInt($(this).find("input[id='detalles-cantidad']")
                                .val());
                                    $ec[e] = {
                                        articulo: art,
                                        cantidad: cant
                                    }
                                })
                                cargando('show', '50px', '#btn-guardar');
                                var formData = new FormData();
                                formData.append('detalles', JSON.stringify($ec));
                                formData.append('_token', '{{ csrf_token() }}');
                                var ruta = "{{ route('admin.ventaaas.existencia') }}";
                                postData(ruta, formData).then(function(rta) {
                                    if (rta.cod == 200) {
                                        $('#form-general').submit();
                                    }
                                }).catch(function(error) {
                                    console.log('postData dio error');
                                    cargando('hide', '50px', '#btn-guardar');
                                    Swal.fire('Error ', error.msg, 'warning');
                                })
                            }
                        }
                     }
                    }
                }
            }
        });

        function comprobarCliente() {
            if (($('#factura_contacto').css('display') == 'block')) {
                if (!$("#cliente_contacto").val()) {
                    Swal.fire({
                    title: "No existen clientes de contacto ",
                    icon: 'warning',
                    html: "desactive la opccion de factura contacto!"
                });
                    return false
                }else{
                    return true
                }
            }else if (!$("#form-cliente #cliente_id").val()) {
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
            var errores = 0;
            var errorE = 0;
            unosolo1 = $('#formDatosDetalles #tabla-lista-detalles tr').length;
            $('#formDatosDetalles #tabla-lista-detalles tr').each(function(e, data) {
                var cant = parseInt($(this).find("input[id='detalles-cantidad']"));
                var prec = parseInt($(this).find("input[id='detalles-precio']").val().replace(/\./g, ''));
                var art = $(this).find("select[id='producto_id']").val();
                var ekk = articulos_js.find(item => item.id == art);
                if (cant == 0) {
                    $(this).find("input[id='detalles-cantidad']").focus();
                    mensajes_de_error += "+Seccion Productos+ Por favor Seleccione una Cantidad linea N° " + e +
                        " \n ";
                    errores = parseInt(errores) + 1;
                }
                if (prec == 0) {
                    $(this).find("input[id='detalles-precio']").focus();
                    mensajes_de_error += "+Seccion Productos+ Por favor Seleccione un Precio linea  N° " + e +
                        " \n ";
                    errores = parseInt(errores) + 1;
                }
                if (art == null) {
                    $(this).find("select[id='producto_id']").val();
                    mensajes_de_error += "+Seccion Productos+ Por favor Seleccione un Articulo linea  N° " + e +
                        " \n ";
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
                    mensajes_de_errorS += "+Seccion Servicio+ Por favor Seleccione una Cantidad linea N° " + e +
                        " \n ";
                    errors = parseInt(errors) + 1;
                }
                if (prec == 0) {
                    $(this).find("input[id='precio_servicio']").focus();
                    mensajes_de_errorS += "+Seccion Servicio+ Por favor Seleccione un Precio linea  N° " + e +
                        " \n ";
                    errors = parseInt(errors) + 1;
                }
                if (!col) {
                    $(this).find("select[id='colaborador_id']").focus();
                    mensajes_de_errorS += "+Seccion Servicio+ Por favor Seleccione un Articulo linea  N° " + e +
                        " \n ";
                    errors = parseInt(errors) + 1;
                }
                if (!ini) {
                    $(this).find("input[id='servicio_ini_']").focus();
                    mensajes_de_errorS += "+Seccion Servicio+ Por favor Seleccione una fecha de inicio linea  N° " +
                        e + " \n ";
                    errors = parseInt(errors) + 1;
                }
                if (!fin) {
                    $(this).find("input[id='servicio_fin_']").focus();
                    mensajes_de_errorS += "+Seccion Servicio+ Por favor Seleccione una fecha de fin linea  N° " +
                        e + " \n ";
                    errors = parseInt(errors) + 1;
                }
            });

            var uno = false;
            var dos = false;
            var tres = false;
            var cuatro = true;
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
            if ((uno) && (dos) && (tres) && (cuatro)) {
                return true
            } else {
                return false
            }
        }

        function comprobarMedios() {
           $('#descuento_porcentaje').trigger('change')
            var mensajes_de_error = "";
            var errores = 0;
            var monto = 0;
            $('#modal_medios_pagos #formMedios .fila_medio').each(function(e, data) {
                monto = monto + parseInt($(this).find("input[id='met_monto']").val().replace(/\./g, ''));
                var metodo = $(this).find("select[id='met_medio']").val();
                if (metodo != null) {
                    var ele = medios_js.find(item => item.id == metodo);
                    if (ele.requiere_numero == true) {
                        if (!$(this).find("input[id='met_documento']").val()) {
                            mensajes_de_error += "Proporcione un numero de documento en la linea N° " + e + " \n ";
                            errores = parseInt(errores) + 1;
                        }
                    }
                    if (ele.requiere_fecha == true) {
                        if (!$(this).find("input[id='met_fecha_ini']").val()) {
                            mensajes_de_error += "Proporcione una fecha de inicio en la linea N° " + e + " \n ";
                            errores = parseInt(errores) + 1;
                        };
                        if (!$(this).find("input[id='met_fecha_fin']").val()) {
                            mensajes_de_error += "Proporcione una fecha de fin en la linea N° " + e + " \n ";
                            errores = parseInt(errores) + 1;
                        };
                    }
                    if (ele.requiere_banco == true) {
                        if ($(this).find("select[id='met_banco']").val() == 0) {
                            mensajes_de_error += "Proporcione un Banco en la linea N° " + e + " \n ";
                            errores = parseInt(errores) + 1;
                        };
                    }
                    if (ele.requiere_marca == true) {
                        if ($(this).find("select[id='met_tarjeta']").val() == 0) {
                            mensajes_de_error += "Proporcione una tarjeta en la linea N° " + e + " \n ";
                            errores = parseInt(errores) + 1;
                        };
                    }
                    if (ele.requiere_cuenta == true) {
                        if ($(this).find("select[id='met_cuenta']").val() == 0) {
                            mensajes_de_error += "Proporcione un numero de cuenta en la linea N° " + e + " \n ";
                            errores = parseInt(errores) + 1;
                        };
                    }
                    if ($(this).find("input[id='met_monto']").val().replace(/\./g, '') <= 0) {
                        mensajes_de_error += "Proporcione un Importe en la linea N° " + e + " \n ";
                        errores = parseInt(errores) + 1;
                    };
                } else {
                    mensajes_de_error += "Seleccione un Metodo de pago por favor en la linea N° " + e + " \n ";
                    errores = parseInt(errores) + 1;
                }
            })
            if (($('#formResumen #seccion_descuento').css('display') == 'block') && ($('#descuento_porcentaje').val() == 100)) {
                errores = 0;
            } else if (parseInt(monto) != parseInt($('#total-pagar').html())) {
                errores = parseInt(errores) + 1;
                mensajes_de_error += "El monto no coincide con el pago  \n ";
            }
            if (errores == 0) {
                return true;
            } else {
                $('#modal_medios_pagos').modal('show');
                Swal.fire({
                    title: "Verifique los Metodos de pago",
                    icon: 'warning',
                    html: mensajes_de_error
                });
                setTimeout(function() {
                    $('.confirm').focus();
                }, 200);
                return false;
            }
        }

        function disponibilidad() {
            var _url = "{{ route('admin.ventaaas.disponibilidad') }}";
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
            ele.display = 'style="display: none"';
            ele.tama = 12;
            var optionsm = "";
            colaboradores_js.map(function(c) {
                if (c.id == ele.colaborador_id) {
                    optionsm += "<option value='" + c.id + "'> " + c.name + " </option>";
                }
            });
            ele.optionsm = optionsm;
            var por = comisiones_js.find(item => ((item.colaborador_id == ele.colaborador_id) && (item.servicio_id == ele
                .id)));
            if (por) {
                ele.porcentaje_colaborador = por.porcentaje;
            }
            var useroptions= "";
            users_js.map(function(c){ 
                useroptions+="<option value='"+c.id+"'> "+c.name+" </option>";
            });
            ele.users=useroptions;
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
                var _url = "{{ route('admin.ventaaas.disponibilidad') }}";
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
                        $(el).closest(".servicio_datos").find("[id='spiner_a']").css("display", "none")
                        $(el).closest(".servicio_datos").find("[id='spiner_b']").css("display", "none")
                        $(el).closest(".servicio_datos").find("[id='spiner_c']").attr('class', 'col-12')

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
            formData.append('cumple', $('#cumple_persona').val());
            formData.append('email', $('#email_persona').val());
            formData.append('es_cliente', $('#es_cliente_persona').val());
            formData.append('es_proveedor', $('#es_proveedor_persona').val());
            var ruta = "{{ route('admin.personas.uporcre') }}";
            postData(ruta, formData).then(function(rta) {
                toastr.success(rta.msg, 'Buen Trabajo!');
                $('#modal_persona').modal('hide');
                  var ruc = $('#ruc_persona').val()
                    var name = $('#name_persona').val() 
                    var data = { id: rta.id, text: ruc + '-' + name};
                    var newOption = new Option(data.text, data.id, true, true);
                    $('.js-data-clientes-ajax').append(newOption).trigger('change');
            }).catch(function(error) {
                console.log(error)
                cargando('hide', '50px', '#btn-guardar');
                Swal.fire('Hola esta es una alerta', error.msg, 'warning');
            })
        });
    </script>
    <script src=" {{ asset('js/logicaVentasNuevas.js') }} "></script>


@stop
