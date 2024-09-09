@extends('adminlte::page')

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('title', 'Agendas')
@section('content_header')
@include('error.error')
    <h1>VENTA CERRADA</h1>
@stop

@section('content')
@include('admin.ventas_dos.modales.styles')
    <form id="form-general" method="POST" action="#">
        <input type="hidden" name="venta_id" value="{{ $id_venta }}">
        @csrf
        @include('admin.ventas_dos.modales.modal_persona')
        <div class="card">
            <div class="card-header">
                    FACTURAR
            </div>
            @if ($factura)
            <div class="form-row ml-2">
                <div class="col-4">
                    <span>Hola..! esta venta ya tiene una factura desea imprimirla de vuelta?</span>
                </div>
                <div class="col-1">
                    <button class="btn-primary" type="button" id="btn-factura-imprimir">Imprimir de vuelta</button>
                </div>
            </div>
            <div class="form-row ml-2 mt-5">
                <div class="col bg-lite col-4">
                    <span>Tambien tiene la opcion de anular solo la factura e intentarlo de vuelta ;)</span>
                </div>
                <div class="col-1">
                    <button class="btn-danger" type="button" onclick="anularFactura()">Anular solo factura</button>
                </div>
                
            </div>
                
            @else
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        @include('admin.ventas_dos.html_base.card_cliente')
                    </div>
                    <div class="col-lg-12">
                        @if (!$factura)
                        <div class="form-row mb-1">
                            <div class="col-4">
                                <x-jet-label value="Timbrado:" />
                            </div>
                            <div class="col-8">
                                @if (count($timbrados))
                                    <select class="form-control" style="width: 100%; font-size: 20px !important;" required id="timbrado_id" name="timbrado_id">
                                        @foreach($timbrados as $tim)
                                            <option value="{{$tim->timbrado_id}}">{{$tim->numero_timbrado}}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <x-jet-input type='text' value="NO EXISTEN TIMBRADOS ACTIVOS"  class="form-control"  readonly />
                                @endif   
                            </div>
                        </div>
                        <div class="form-row mb-1">
                            <div class="col-4">
                                <x-jet-label value="Numero de Factura:"/>
                            </div>
                            <div class="col-8">
                                <x-jet-input type='text' id="numero_timbrado" name="numero_timbrado"  class="form-control"  />
                                <x-jet-input type='hidden' id="numero_timbrado_real" name="numero_timbrado_real"  class="form-control"   />
                            </div>
                        </div> 
                        @endif 
                    </div>
                </div>
                
            </div>
            <div class="card-footer">
                <div class="form-row mt-3">
                    <div class="col-5"></div>
                    <div class="col-4" style="display: none" id="carga_lenta"> 
                        <button type="button" class="btn btn-info" id="btn-guardar" onclick="comprobarCliente()">Confirmar e Imprimir</button>
                    </div>
                    <div class="col-4" id="loader_WH">
                        <div class="loader"></div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="card bg-dark  mb-3">
            <div class="card-header col-12 border">
                <div class="form-row">
                    <div class="col-2"> Detalles de la venta</div>
                    {{-- @if (!$factura) --}}
                    <div class="col-6">
                        FACTURA DETALLADA
                        <label class="switch">
                        <input type="checkbox" id="detallada">
                        <span class="slider round">
                        </span>
                      </label>
                    </div>
                    {{-- @endif --}}
                </div>
            </div>

            <div class="card-body">
                    <div class="col-lg-12">
                        @include('admin.ventas_dos.modales.ver_factura')
                    </div>
            </div>
        </div>
    </form>
    <input type="hidden" id="cargando" value="si">

    </form>
@stop
@section('css')
@stop

@section('js')
    <script src=" {{ asset('js/comunes.js') }} "></script>
    <script>
        @php
            echo 'var articulos_js = ' . json_encode($articulos) . '; ';
            echo 'var cuentas_js = ' . json_encode($cuentas) . '; ';
            echo 'var colaboradores_js = ' . json_encode($colaboradores) . '; ';
            echo 'var ventas_js = ' . json_encode($venta) . '; ';
            echo 'var id_venta_js = ' . json_encode($id_venta) . '; ';
            echo 'var timbrados_js = ' . json_encode($timbrados) . '; ';
            echo 'var cerrada_js = ' . json_encode($cerrada) . '; ';
        @endphp
        var url_cliente='{{route("admin.ventaaas.contacto")}}'
        //seccion guardar
        $(document).ready(function() {
            if ($('#timbrado_id').length != 0) {
                $('#timbrado_id').trigger('change');
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
            }).promise().done(function(){
                var data = {
                    id: cerrada_js.persona.id,
                    text: cerrada_js.persona.ruc + '-' + cerrada_js.persona.name
                };
                var newOption = new Option(data.text, data.id, false, false);
                $('.js-data-clientes-ajax').append(newOption).trigger('change');
            });

            var venta = ventas_js.venta;
            var detalle = ventas_js.detalles;
            var medios = ventas_js.medios;
            $("#form-cliente #cliente_id").attr('readonly', true);
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
            //una ve que cargue todo recien nos movemos
            $('#carga_lenta').css("display", "block")
        })
       
        function comprobarCliente(){
            if (($('#factura_contacto').css('display') == 'block')) {
                if (!$("#cliente_contacto").val()) {
                    Swal.fire({
                        title: "No existen clientes de contacto ",
                        icon: 'warning',
                        html: "desactive la opccion de factura contacto!"
                    });
                    return false
                } else {
                    Factura($("#cliente_contacto"))
                }
            } else if (!$("#form-cliente #cliente_id").val()) {
                Swal.fire({
                    title: "Verifique El Cliente",
                    icon: 'warning',
                    html: "Debe seleccionar un cliente!"
                });
                return false
            } else {
                Factura($("#form-cliente #cliente_id"))
            }
        }
        function Factura(cliente) {
            var data = $(cliente).select2('data');
            if(!data[0]) {
                Swal.fire({
                    title: "Verifique El Cliente",
                    icon: 'warning',
                    html: "Debe seleccionar un cliente!"
                });
                return false
            }
            Swal.fire({
                title: 'Factura a Nombre de Cliente: ' + data[0].text,
                text: "si este no es su cliente verifique los datos del cliente 'recuerde que si la factura contacto esta activa se utiliza esa'",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si.! Facturar'
            }).then((result) => {
                if (result.isConfirmed) {
                    guardarFactura(cliente);
                    tiempoEspera()
                } else {
                    console.log("cancel");
                }
            })
        }

        function guardarFactura(cliente) {
            $('#btn-guardar').attr('disabled',true)
            var _url = "{{ route('admin.ventaaas.facturar') }}";
            var formData = new FormData();
            formData.append('id_venta', id_venta_js);
            formData.append('cliente', $(cliente).val());
            formData.append('factura_detallada', $('#detallada').prop('checked'));
            formData.append('numero_timbrado', $('#numero_timbrado').val());
            formData.append('numero_timbrado_real', $('#numero_timbrado_real').val());
            formData.append('_token', '{{ csrf_token() }}');
            postData(_url, formData).then(function(rta) {
                if (rta.cod == 200) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Factura Registrada',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    var ventana;
                    let url = "{{ route('admin.facturar', ':id') }}";
                    url = url.replace(':id', id_venta_js);
                    ventana = window.open(url, '_');
                    setTimeout(function() {
                        ventana.close();
                    }, 4000);
                    location.reload();
                } else {
                    Swal.fire({
                        title: "Error",
                        icon: 'warning',
                        html: rta.msg
                    });
                    location.reload();
                }
            }).catch(function(error) {
                console.log('postData dio error');
                console.log(error);
                Swal.fire('Ocurrio un Error', error, 'error');
            })
        }
        function anularFactura(){
            Swal.fire({
                title: 'Estas seguro de anular la factura',
                text: "Esta accion solo anula la factura no la venta en si,una vez confirmada esta accion no se podra deshacer..!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si.! Vamos'
            }).then((result) => {
                if (result.isConfirmed) {
                tiempoEspera()
                var _url = "{{ route('admin.ventaaas.anular') }}";
                var formData = new FormData();
                formData.append('id_venta', id_venta_js);
                formData.append('_token', '{{ csrf_token() }}');
                postData(_url, formData).then(function(rta) {
                if (rta.cod == 200) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Factura Anulada',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    location.reload();
                } else {
                    Swal.fire({
                        title: "Error",
                        icon: 'warning',
                        html: rta.msg
                    });
                    location.reload();
                }
            }).catch(function(error) {
                console.log('postData dio error');
                console.log(error);
                Swal.fire('Ocurrio un Error', error, 'error');
            })
                } else {
                    console.log("cancel");
                }
            })
        }

        function tiempoEspera() {
            let timerInterval
            Swal.fire({
                title: 'Espere Mientras Se genera /o anula su factura',
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
        var venta = ventas_js.venta;
        var detalle = ventas_js.detalles;
        $(document).on("change", "#detallada", function(){
            $('#table_fac_detalle').empty()
                if ($(this).prop('checked')) {
                    detalle.venta_detalles.forEach(function callback(ele, index, array) {
                            var art = articulos_js.find(item => item.id == ele.articulo_id);
                            art.cantidad=ele.cantidad
                            art.precio_unitario=puntear(ele.precio_unitario)
                            art.precio_total=puntear(ele.precio_total)
                            art.gravada10=puntear(ele.gravada10)
                        $('#table_fac_detalle').append([art].map(ItemFactura).join(''));
                    })
                }else{
                    var art = {'name':'Servicios Profesionales / Productos'}
                    art.cantidad=1
                    art.precio_unitario=puntear(venta.total)
                    art.precio_total=puntear(venta.total)
                    art.gravada10=puntear(venta.total)
                    $('#table_fac_detalle').append([art].map(ItemFactura).join(''));
                }
})
const ItemFactura = ({cantidad,precio_unitario,precio_total,gravada10,name}) => `
<tr>
    <td style="width: 12.5%; text-align: center; "><h6>${cantidad}</h6></td>
    <td style="width: 34%; "><h6>${name}</h6></td>
    <td style="width: 12.5%; text-align: center;"><h6>${precio_unitario}</h6></td>
    <td style="width: 25%; text-align: center;">
        <table style="width: 100%; height: 100%;" border="1">
            <tr>
                <td style="width: 33.3%; "><h6>0</h6></td>
                <td style="width: 33.3%; "><h6>0</h6></td>
                <td style="width: 33.3%; "><h6>${gravada10}</h6></td>
            </tr>
        </table>
    </td>
</tr>
`;

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
                var data = {
                    id: rta.id,
                    text: ruc + '-' + name
                };
                var newOption = new Option(data.text, data.id, true, true);
                $('.js-data-clientes-ajax').append(newOption).trigger('change');
                vaciarModal()

            }).catch(function(error) {
                console.log(error)
                cargando('hide', '50px', '#btn-guardar');
                Swal.fire('Hola esta es una alerta', error.msg, 'warning');
            })
        });
    </script>
    <script src=" {{ asset('js/logicaVentasNuevas.js') }} "></script>


@stop
