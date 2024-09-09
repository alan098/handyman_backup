@extends('adminlte::page')
@section('title', 'Comisiones Pagos')
@section('content_header')
@stop
@section('content')
    <div class="container">

        <div class="modal" tabindex="-1" role="dialog" id="modal_detalle">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Servicios</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>fecha</th>
                                    <th>Servicio</th>
                                    <th>Total</th>
                                    <th>Porcentaje</th>
                                    <th>Comision</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($comprobantes as $c)
                                    @php
                                        $i = 0;
                                        $autofocus = $i == 0 ? 'autofocus' : '';
                                        $i++;
                                        $importeTotal = empty($importeTotal) ? $c->comision : $importeTotal + $c->comision;
                                    @endphp
                                    <tr id="tr_{{ $c->id }}">
                                        <td>{{ $c->fecha }}</td>
                                        <td class="text-center">{{ $c->ar_name }}</td>
                                        <td class="text-center">{{ number_format($c->precio_total, 0, ',', '.') }}</td>
                                        <td class="text-center">{{ $c->porcentaje }}</td>
                                        <td class="text-center">{{ number_format($c->comision, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <form id="formulario" action="{{ route('admin.pagos.comisiones.store') }}" method="POST">
            <div class="modal fade" id="modal_adelanto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                 <div class="modal-content">
                   <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel">Adelantos</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                     </button>
                   </div>
                   <div class="modal-body">
                       <div class="form-row">
                           <div class="col"><label>Acciones</label></div>
                           <div class="col"><label>Fecha</label></div>
                           <div class="col"><label>Monto</label></div>
                           <div class="col"><label>Colaborador</label></div>
                           <div class="col"><label>Aprobado Por</label></div>
                       </div>
                       <hr>
                       @foreach ($adelantos as $item)
                       <div class="form-row mt-4">
                           <div class="col"> 
                               <div class="form-check">
                                   <input class="form-check-input mt-0" onclick="Agregar(this,{{$item->id}},{{$item->importe}})" style="width:25px; height:25px;" id="adelantos[{{$item->id}}]"  type="checkbox" value="{{$item->id}}" >
                               </div>
                           </div>
                           <div class="col">{{$item->fecha_recibido}}</div>
                           <div class="col" id="imp_ad">{{$item->importe}}</div>
                           <div class="col">{{$proveedor->name}}</div>
                           <div class="col">{{$item->entregado_name}}</div>
                       </div>
                       <hr>
                        
                       @endforeach
                   </div>
                   <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                   </div>
                 </div>
               </div>
             </div>

            <input type="hidden" name="pid" id="pid" value="{{ $proveedor->id }}">
            <input type="hidden" name="cerrar" value="0">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h5 class="float-left">Registro Orden de Pago para Colaborador {{ $proveedor->name }}</h5>
                </div>
                <div class="card-body">
                    <div class="card">
                        <div class="card-header">
                                <div class="form-row">
                                    <div class="col">
                                        <button class="btn btn-primary" type="button" data-toggle="modal"
                                            data-target="#modal_detalle">
                                            Ver Servicios a pagar
                                        </button>
                                    </div>
                                    <div class="col">
                                        <button class="btn btn-primary" type="button" onclick="calcularIps()"
                                         @if (!$proveedor->ips)
                                            disabled
                                        @endif>
                                            Calcular Ips
                                        </button>
                                    </div>

                                </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-hover table-sm" id="tabla-comprobantes">
                                <thead>
                                    <tr>
                                        <th>Fecha de Pago</th>
                                        <th>descripción de pago</th>
                                        <th>Colaborador</th>
                                        <th>Total a pagar</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>
                                            <input type="date" class="form-control" value="{{ Date('Y-m-d') }}"
                                                id="fecha" name="fecha">
                                        </th>
                                        <th>
                                            <input type="text" placeholder="Ejem. pago por mes de ..."
                                                class="form-control" name="name" id="name" required>
                                        </th>
                                        <th>
                                            <input type="hidden" value="{{ $proveedor->id }}" name="id"
                                                id="id">
                                            <input type="text" class="form-control" value="{{ $proveedor->name }}"
                                                disabled>
                                        </th>
                                        <th>
                                            <input type="hidden" value="{{ $importeTotal }}" name="importe"
                                                id="total_base">
                                            <input type="text" class="form-control"
                                                value="{{ number_format($importeTotal, 0, ',', '.') }}" disabled>
                                        </th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <table class="table table-striped table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th>Otros Pagos</th>
                                        <th><button class="btn btn-primary" type="button" onclick="addOtros()"><i class="fa fa-plus"></i></button></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-hover table-sm" id="tabla-otros">
                                <tbody id="addOtros">
                                    <tr>
                                        <th>
                                            <select name="otros[0][pago]" id="pago"  class="select2 form-control" width="100%" required readonly>
                                                <option value="1" selected>Sueldo Base</option>
                                            </select>
                                        </th>
                                        <th>
                                            <input type="text" class="form-control" id='importe' name="otros[0][importe]"  value="{{$proveedor->salario}}" readonly>
                                        </th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="form-row">
                                <div class="col-5"><h5>Adelantos</h5></div>
                                <div class="col-1">
                                    <div >
                                        <button role="button"  data-target="#modal_adelanto" data-toggle="modal" type="button" class="btn btn-primary" tabindex="-1"> <i class="fa fa-search"></i> </button>
                                    </div>
                                </div>
                                <div class="col-5"><h5>Descuentos</h5></div>
                                <div class="col-1">
                                    <div>
                                        <button role="button" type="button" class="btn btn-primary" tabindex="-1"
                                            onclick="addDetalle()"> <i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="tabla_medios">
                                <thead>
                                    <tr>
                                        <th>Tipo Descuento</th>
                                        <th>Importe</th>
                                        <th width="50px">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <div class="form-row">
                        <div class="col">   
                            <span>Total Sumado</span>
                            <input type="number"  class="form-control" id="total_final" value="{{ $importeTotal }}" readonly>
                        </div>
                        <div class="col">
                            <span>Ips Empleador</span>
                            <input type="number" class="form-control" id="ips_empleado"  value="0" readonly>
                        </div>
                        <div class="col-4">
                            <span>Ips Empleado</span>
                            <input type="number" class="form-control" id="ips_empleador" value="0" readonly>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-4" id="loader_WH">
                        <div class="loader"></div>
                    </div>
                    <div class="float-left">
                        <button type="submit" class="btn btn-primary submit" id="btn-guardar"> <i
                                class="fa fa-save"></i> Guardar y Cerrar</button>
                    </div>
                    <div class="float-right">
                        <a href="{{ route('admin.pagos.comisiones.index') }}" role="button" class="btn btn-secondary">
                            <i class="fa fa-delete"></i> Cancelar </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop
@section('js')

    <script src=" {{ asset('js/comunes.js') }} "></script>
    <script>
        @php
            echo 'var descuentos_js = ' . json_encode($descuentos) . '; ';
            echo 'var pagos_js = ' . json_encode($pagos) . '; ';
            echo 'var comprobantes_js = ' . json_encode(request('comprobantes')) . '; ';
        @endphp

        function getRandomInt(min, max) {
            return Math.floor(Math.random() * (max - min)) + min;
        }

        const ItemDescuentos = ({
            optionsm,
            numero_azar
        }) => `
        <tr id="tr_descuento">
        <td>
        <div class="form-group">
            <select name="descuento[${numero_azar}][descuento]" id="descuento" 
            class="select2 form-control medio" width="100%" required>
                ${optionsm}
            </select>
        </div>
        </td>
        <td>
        <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text" id="basic-addon2"><i>$</i> </span></div>
            <input type="text" name="descuento[${numero_azar}][importe]" id="importe" 
                class="text-right form-control siempreCero" value="0" required>
        </div>
        </td>
        <td>
        <a role="button" class="btn btn-danger text-white" onclick="destroyTR(this)"> <i class="fa fa-trash"></i> </a>
        </td>
        </tr>
    `;
   function  Agregar(base,id,importe){
        if ($(base).prop('checked')) {
            console.log(importe)
            var ele = {};
            ele.importe=importe;
            ele.id=id
            var numero_azar = $('#tabla_medios tbody').length + 1;
            numero_azar = (numero_azar * 1000) + getRandomArbitrary(1, 100);
            ele.numero_azar = numero_azar
            $('#tabla_medios tbody').append([ele].map(ItemAdelantos).join(''));
            alertaTipo('Agregado', 'success')
            calcular()
        } else {
            $(".eliminar_"+id).remove();
            calcular()
            alertaTipo('Removido', 'success')
        }
    };

    const ItemAdelantos = ({
            id,importe,
            numero_azar
        }) => `
        <tr id="tr_descuento" class="eliminar_${id}">
        <td>
            <input type="hidden"  name="descuento[${numero_azar}][adelanto_id]" value="${id}">  
        <div class="form-group">
            <select name="descuento[${numero_azar}][descuento]" id="descuento" 
            class="select2 form-control medio" width="100%" readOnly>
            <option value="100">Adelanto</option>
            </select>
        </div>
        </td>
        <td>
        <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text" id="basic-addon2"><i>$</i> </span></div>
            <input type="text" name="descuento[${numero_azar}][importe]"   id="importe"
                class="text-right form-control siempreCero" value="${importe}" readOnly>
        </div>
        </td>
        <td>
            <a role="button" class="btn btn-danger text-white" disabled title="Elimine en la seccion de adelantos"> <i class="fa fa-trash"></i> </a>
        </td>
        </tr>
    `;
        function addDetalle() {
            var ele = {};
            var optionsm = "";
            descuentos_js.map(function(c) {
                optionsm += "<option value='" + c.id + "'> " + c.name + " </option>";
            });
            ele.optionsm = optionsm;

            var numero_azar = $('#tabla_medios tbody').length + 1;
            numero_azar = (numero_azar * 1000) + getRandomArbitrary(1, 100);
            ele.numero_azar = numero_azar
            $('#tabla_medios tbody').append([ele].map(ItemDescuentos).join(''));
            alertaTipo('Agregado', 'success')
        }

        function getRandomArbitrary(min, max) {
            return Math.round(Math.random() * (max - min) + min);
        }

        function destroyTR(id) {
            $(id).closest("#tr_descuento").remove();
            calcular()
            alertaTipo('Removido', 'success')
        }

        function addOtros(){
            var ele = {};
            var numero_azar = $('#addOtros').length + 1;
            numero_azar = (numero_azar * 1000) + getRandomArbitrary(1, 100);
            ele.numero_azar = numero_azar
            var optionsm = "";
            pagos_js.map(function(c) {
                optionsm += "<option value='" + c.id + "'> " + c.name + " </option>";
            });
            ele.optionsm = optionsm;
            $('#addOtros').append([ele].map(ItemOtros).join(''));
            alertaTipo('Agregado', 'success')
            calcular()
        }
        const ItemOtros = ({
            id,importe,
            numero_azar,optionsm
        }) => `
            <tr id="tr_otro">
                <th>
                    <div class="form-group">
                        <select name="otros[${numero_azar}][pago]" id="pago" 
                        class="select2 form-control medio" width="100%" required>
                            ${optionsm}
                        </select>
                    </div>
                </th>
                <th>
                    <input type="text" class="form-control siempreCero" style="text-align: right;" id="importe" value="0"  name="otros[${numero_azar}][importe]" >
                </th>
                <td>
                    <a role="button" class="btn btn-danger  text-white" onclick="destroyOtro(this)"> <i class="fa fa-trash"></i> </a>
                </td>
            </tr>
        `;
        function destroyOtro(id) {
            $(id).closest("#tr_otro").remove();
            calcular()
            alertaTipo('Removido', 'success')
        }
        calcular()
        function calcularIps(){
            //tomamos el total 
           var base_imponible= parseInt($('#total_final').val());
           var empleado= (base_imponible * 9.5) / 100;
           var empleador=(base_imponible * 13.5) / 100;
            $('#ips_empleado').val(empleado);
            $('#ips_empleador').val(empleador);
        }

        function alertaTipo(messa, tipo) {
            toastr.options = {
                "closeButton": true,
                "positionClass": "toast-top-right",
                "showDuration": "1500",
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "preventDuplicates": false,
                "onclick": null,
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            if (tipo == "error") {
                toastr.error('', messa);
            } else if (tipo == "warning") {
                toastr.warning('', messa);
            } else if (tipo == "info") {
                toastr.info('', messa);
            } else if (tipo == 'success') {
                toastr.success('', messa);
            }
        }
        $(document).on("change", "#tabla_medios input[id^='importe']", function() {
            calcular()
        })
        $(document).on("change", "#tabla-otros input[id^='importe']", function() {
            calcular()
        })


        function calcular() {
            var total = parseInt( $('#total_base').val())
            $('#tabla_medios tbody tr').each(function(e, data) {
                var impor = parseInt($(this).find("input[id='importe']").val());
                if (!isNaN(impor)) {
                    total = total - impor
                } else {
                    $(this).focus();
                    alertaTipo('Coloque un importe valido', 'error')
                }
            })
            $('#tabla-otros tbody tr').each(function(e, data) {
                console.log($(this).find("input[id='importe']").val())
                var impor = parseInt($(this).find("input[id='importe']").val());
                if (!isNaN(impor)) {
                    total = total + impor
                } else {
                    $(this).focus();
                    alertaTipo('Coloque un importe valido', 'error')
                }
            })
            
            $('#total_final').val(total)
        }

        $('.submit').on('click', function(e) {
            cargando('show', '50px', '#btn-guardar');
            e.preventDefault();
            var totalPago = $('#total_final').val();
            if (((totalPago.replace(/[^0-9]/g, '')) > 0)) {
                if (reglas()) {
                    enviar()
                }else{
                    cargando('hide', '50px', '#btn-guardar');
                }

            } else {
                alertaTipo('El importe a pagar debe ser mayor a cero', 'error');
                return false;
            }

        });

        function enviar() {
            var formData = new FormData($('#formulario')[0]);
            formData.append('ids', comprobantes_js)
            formData.append('total_final', $('#total_final').val())
            var ruta = "{{ route('admin.pagos.comisiones.store') }}";
            postData(ruta, formData).then(function(rta) {
                alertaTipo('Comprobante Generado', 'success')
                window.location.href = "{{ route('admin.pagos.comisiones.index') }}";
                cargando('hide', '50px', '#btn-guardar');
            }).catch(function(error) {
                console.log('postData dio error');
                console.log(error);
                cargando('hide', '50px', '#btn-guardar');
                Swal.fire('Ocurrio un Error', error.message, 'error');
            });
        }

        function reglas() {
            var error=0;
            $('#tabla_medios tbody tr').each(function(e, data) {
                var impor = parseInt($(this).find("input[id='importe']").val());
                if ((isNaN(impor)) ) {
                    $(this).focus();
                    alertaTipo('Coloque un importe valido Descuentos', 'error')
                    error=1;
                }
            })
            $('#tabla-otros tbody tr').each(function(e, data) {
                var impor = parseInt($(this).find("input[id='importe']").val());
                if ( (isNaN(impor)) ) {
                    $(this).focus();
                    alertaTipo('Coloque un importe valido Otros pagos', 'error')
                    error=1;
                } 
            })
            if(error == 1){
                return false;
            }
            if (!$('#name').val()) {
                console.log($('#name').val())
                toadErrores('Necesita dar una descripcion de pago')
                return false;
            } else if (!$('#fecha').val()) {
                toadErrores('Necesita una fecha')
                return false;
            } else {
                return true
            }
        }
    </script>

@stop
