{{-- @dd($gasto ) --}}


@php
    $ccoptions = '';
    foreach ($form['centroscostos'] as $cc) {
        $ccoptions .= '<option value="' . $cc->id . '">' . $cc->name . '</option>';
    }
    
    $mediosoptions = '';
    foreach ($medios as $me) {
        $mediosoptions .= '<option value="' . $me->id . '">' . $me->name . '</option>';
    }
    
    $marcasoptions = '';
    foreach ($marcasTC as $marca) {
        $marcasoptions .= '<option value="' . $marca->id . '">' . $marca->name . '</option>';
    }
    
    $cuentasoptions = '';
    foreach ($cuentasBancos as $cuenta) {
        $name = $cuenta->name;
        $name .= !empty($cuenta->banco) ? ' - ' . $cuenta->banco->name : '';
        $cuentasoptions .= '<option value="' . $cuenta->id . '">' . $name . '</option>';
    }
    
    
    if (!empty($gasto->fecha)) {
        $v = explode('-', substr($gasto->fecha, 0, 10));
        $fecha = $v[2] . '/' . $v[1] . '/' . $v[0];
    }
@endphp

@csrf

<div class="container">
    <div class="row">
        <div class="col-6">
            <div class="form-group row">
                <label for="fecha" class="col-md-3 col-form-label">Fecha</label>
                <input id="fecha" name="fecha" type="date" class="col-md-8 col-sx-4 form-control"
                    required value="{{ date('d/m/Y') }}">
            </div>
        </div>

        <div class="col-6">
            <div class="form-row">
                <div class="col-3"> <label for="para" class="form-label">Colaborador</label></div>
                <div class="col mr-1">
                    <div class="form-group row">
                        <select id="para" name="para" class="select2 form-control" required>
                            <option value="">Elija un Colaborador</option>
                            @foreach ($col as $col)
                                <option value="{{ $col->id }}">{{ $col->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-row mb-3">
        <div class="col-2"><label for="select" class="form-label mt-2">Breve Descripcion</label></div>
        <div class="col"><input id="name" name="name" type="text" class="form-control"
                placeholder="Adelanto por que hendy"></div>
    </div>
    <hr>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Detalles</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-5 text-center">Adelanto Entregado y Autorizado por</div>
                <div class="col-7 text-center">Importe Entregado</div>
            </div>
            <hr>
            <div id="detalles" class="table-striped">
                <div class="row detalle" id="detalle1">
                    <div class="col-5">
                        <input type="text" id="entregado_por" class="form-control text-center" placeholder="{{Auth()->user()->name}}" readonly> 
                    </div>
                    <div class="col-7">
                        <input type="text" class="form-control text-right importe totaldet " id="importe" name="importe" placeholder="0"> 
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="card" id="div_medios_pago">
        <div class="card-header">
            <h3 class="card-title">Medios de Pago</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-1">#</div>
                <div class="col-2">Medio</div>
                <div class="col-2">Numero</div>
                <div class="col-2">Tarjeta</div>
                <div class="col-2">Cuenta</div>
                <div class="col-2 text-center">Importe</div>
                <div class="col text-right" style="background-color: white"><button id="btnAddMP" type="button"  class="btn bg-white" disabled></button>
                </div>
            </div>
            <hr>
            <div id="tabla_mps" class="table-striped tabla_mps"></div>
        </div>
    </div>

</div>


@section('js')

    <script src=" {{ asset('js/comunes.js') }} "></script>

    <script>
        $(document).ready(function() {

            setTimeout(function(){
                $('#btnAddMP').click()
                @unless(empty($adelanto))
                    $('#medio_id').val( '{{ $adelanto->medio_id }}')
                    $('#documento').val( '{{ $adelanto->documento }}')
                    $('#tarjeta_id').val( '{{ $adelanto->tarjeta_id }}')
                    $('#cuenta_id').val( '{{ $adelanto->cuenta_id }}')
                    $('#importeM').val( '{{ $adelanto->importe }}')                            
                @endunless
            },2000);
           

            $('#gastosForm').on('submit', function(e) {
                e.preventDefault();
                var ruta = $(this).attr('action');
                console.log('ruta => ' + ruta);
                var arr = ruta.split('/');

                console.log(arr[arr.length - 1]);
                if (validate()) {
                    if (arr[arr.length - 1] == 'update') {
                        console.log('update');
                        console.log($('#id').val());
                        var formData = new FormData($(this)[0]);

                        postData(ruta, formData).then(function(rta) {
                            console.log('postData OK');
                            if (rta['cod'] == 200) {
                                toastr.options = {
                                    "closeButton": true,
                                };
                                toastr.success(rta['msg'], 'Buen Trabajo!');
                                window.location.href = "{{ route('admin.adelantos.index') }}";
                            } else {
                                toastr.options = {
                                    "closeButton": true,
                                };
                                toastr.error(rta['msg'], 'Atención!');
                            }
                        }).catch(function(error) {
                            console.log('postData dio errorrrr');
                            console.log(error);
                            toastr.options = {
                                "closeButton": true,
                            };
                            toastr.error('Ocurrio un error al actualizar el comprobante',
                                'Atención!');
                        });
                    } else {
                        var formData = new FormData($(this)[0]);
                        postData(ruta, formData).then(function(rta) {
                            console.log('postData OK');
                            if (rta['cod'] == 200) {
                                toastr.options = {
                                    "closeButton": true,
                                };
                                toastr.success(rta['msg'], 'Buen Trabajo!');
                                window.location.href = "{{ route('admin.adelantos.index') }}";

                            } else {
                                toastr.options = {
                                    "closeButton": true,
                                };
                                toastr.error(rta['msg'], 'Atención!');
                            }
                        }).catch(function(error) {
                            console.log('postData dio errorrrr');
                            console.log(error);
                            toastr.options = {
                                "closeButton": true,
                            };
                            toastr.error('Ocurrio un error al registrar el comprobante',
                                'Atención!');
                            // Swal.fire('Ocurrio un Error', error.message, 'error');
                        });
                    }
                }

            });

            function validate() {
                var mps = document.getElementsByClassName("tabla_mps").length;
                console.log('mps =>' + mps);
                if (mps > 0) {
                    console.log("alan")
                    var totalMP = Number($('.totalmp').val());
                    var totalDet = Number($('.totaldet').val());
                    if (totalMP != totalDet) {
                        toastr.options = {
                            "closeButton": true,
                        };
                        toastr.error(
                            'Si desea registrar el pago, el total de medios de pago debe ser igual al total de detalles',
                            'Atención!');
                        return false;
                    }
                }
                return true;
            }


            $('#btnAddDetalle').click(function() {
                console.log('btnAddDetalle');
                var divs = document.getElementsByClassName("detalle").length + 1;
                divs = (divs * 1000) + getRandomArbitrary(1, 100);
                var ele = {
                    'id': divs,
                    cantidad: '',
                    concepto: '',
                    centrocosto_id: '',
                    unitario: '',
                    tipoiva: '10',
                    importe: '',
                    dbid: ''
                };
                $('#detalles').append([ele].map(ItemDetalle).join('')).promise().done(function() {
                    $('#tipoiva' + divs).val(10); //por defecto le pongo iva 10
                    $('#cantidad' + divs).focus();
                    $('.select2').select2().trigger('change');
                });
            });

            $('#btnAddMP').click(function() {
                console.log('btnAddMP');
                var divs = document.getElementsByClassName("tabla_mps").length + 1;
                divs = (divs * 1000) + getRandomArbitrary(1, 100);
                //id, documento, marca, cuenta, importe
                var ele = {
                    'id': divs,
                    documento: '',
                    marca: '',
                    cuenta_id: '',
                    importe: '',
                    dbid: ''
                };
                $('#tabla_mps').append([ele].map(ItemMP).join('')).promise().done(function() {});
            });



            function getRandomArbitrary(min, max) {
                return Math.round(Math.random() * (max - min) + min);
            }

            @unless(empty($adelanto))
                populateForm('gastosForm', {!! json_encode($adelanto) !!});
                var id = document.getElementsByClassName("detalle").length + 1;
                var totalMP = 0;
                totalMP += Number('{{ $adelanto->importe }}');
                $('#para').val('{{ $adelanto->para }}')
                $('#fecha').val('{{ $adelanto->fecha }}')
                $('#entregado_por').val('{{ $adelanto->entregado_name }}')
                $('#name').val('{{ $adelanto->name }}')
                                          
            @endunless
        });

        

      

        function multiplicar(id) {
            console.log('multiplicar');
            var qty = Number($('#detalle' + id + ' .qty').val());
            var imp = Number($('#detalle' + id + ' .unitario').val());
            var total = qty * imp;
            console.log(qty);
            console.log(imp);
            console.log(total);

            $('#detalle' + id + ' .importe').val(total);
            $('.sumar').trigger('change');
        }

        function removeDetalle(id) {
            $('#detalle' + id).remove();
            $('.sumar').trigger('change');
        }

        function removeMP(id) {
            $('#mp' + id).remove();
            $('.sumar2').trigger('change');
        }


        const ItemDetalle = ({
            id,
            cantidad,
            concepto,
            centrocosto_id,
            unitario,
            tipoiva,
            importe,
            dbid
        }) => `
                    <div class="row mt-1 detalle" id="detalle${id}">
                        <input type="hidden" name="detalles[${id}][dbid]" value="${dbid}">
                        <div class="col-1"><a onclick="removeDetalle(${id})" class="btn btn-danger"><i class="fa fa-trash"></i></a></div>
                        <div class="col-1"><input type="text" class="form-control text-right qty" name="detalles[${id}][cantidad]" placeholder="0" value="${cantidad}" id="cantidad${id}" onchange="multiplicar(${id})"> </div>
                        <div class="col-3">  <input type="text" class="form-control" name="detalles[${id}][concepto]" placeholder="Escriba el concepto" value="${concepto}"></div>
                        <div class="col-2">
                            <select name="detalles[${id}][centrocosto_id]" class="form-control select2" id="cc${id}" required>
                                <option value="">Elija un CC</option>
                                 @php echo $ccoptions @endphp
                            </select>
                        </div>
                        <div class="col-2"><input type="text" class="form-control text-right unitario" name="detalles[${id}][unitario]" onchange="multiplicar(${id})" placeholder="0" value="${unitario}"></div>
                        <div class="col-1">
                            <select name="detalles[${id}][tipoiva]" class="form-control custom-select" id="tipoiva${id}">
                                <option value="10">10</option>
                                <option value="5">5</option>
                                <option value="0">0</option>

                            </select>
                        </div>
                        <div class="col-2"><input type="text" class="form-control text-right sumar importe " name="detalles[${id}][importe]" placeholder="0" value="${importe}"> </div>
                    </div>
                `;
        const ItemMP = ({
            id,
            documento,
            marca,
            cuenta,
            importe,
            dbid
        }) => `
    <div class="row mt-1 mp" id="mp${id}">
        <input type="hidden" name="dbid" value="${dbid}">

        <div class="col-1">#</div>
        <div class="col-2">
            <select name="medio_id" class="form-control select2" id="medio_id" required>
                <option value="">Elija un MP</option>
                @php echo $mediosoptions @endphp
            </select>
        </div>

        <div class="col-2">
            <input type="text" class="form-control text-right" id="documento" name="documento" placeholder="0" value="${documento}">
        </div>
        <div class="col-2">
            <select name="tarjeta_id" class="form-control custom-select" id="marca">
                <option value="">Elija una TC</option>
                @php echo $marcasoptions @endphp
             </select>
        </div>
        <div class="col-2">
            <select name="cuenta_id" class="form-control custom-select" id="cuenta">
                <option value="">Elija una Cuenta</option>
                @php echo $cuentasoptions @endphp
             </select>
        </div>
        <div class="col"><input type="text" class="form-control text-right totalmp" id="importeM" name="importeM" placeholder="0" value="${importe}" required> </div>
    </div>`;
    </script>
@stop


@section('css')
    <style>
        td.details-control {
            cursor: pointer;
        }
    </style>
@stop
