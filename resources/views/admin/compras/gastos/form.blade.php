{{-- @dd($gasto ) --}}


@php
    $ccoptions = '';
    foreach($form['centroscostos'] as $cc){
        $ccoptions .= '<option value="'. $cc->id .'">'. $cc->name .'</option>';
    }

    $mediosoptions = '';
    foreach($medios as $me){
        $mediosoptions .= '<option value="'. $me->id .'">'. $me->name .'</option>';
    }

    $marcasoptions = '';
    foreach ($marcasTC as $marca) {
        $marcasoptions .= '<option value="'. $marca->id .'">'. $marca->name .'</option>';
    }


    $cuentasoptions = '';
    foreach ($cuentasBancos as $cuenta) {
        $name = $cuenta->name ;
        $name .= (!empty($cuenta->banco)) ? ' - ' .$cuenta->banco->name : '';
        $cuentasoptions .= '<option value="'. $cuenta->id .'">'. $name .'</option>';
    }


/*
    <option value="1">Itau Cta Cte (1234)</option>
    <option value="2">BBVA (9876)</option>
    <option value="3">Familiar (97866543)</option>
*/


    if(!empty($gasto->fecha)){
        $v = explode('-', substr($gasto->fecha, 0, 10));
        $fecha = $v[2].'/'.$v[1].'/'.$v[0];
    }
@endphp

@csrf

<div class="container">
    <div class="row">
        <div class="col-6">
            <div class="form-group row">
                <label for="fecha" class="col-md-3 col-form-label">Fecha</label>
                <input id="fecha" name="fecha" type="text" class="datepicker col-md-8 col-sx-4 form-control" required value="{{ $fecha ?? date('d/m/Y') }}"  >

            </div>

            <div class="form-group row">
                <label for="proveedor_id" class="col-md-3 col-sx-1 col-form-label">Proveedor</label>
                <select id="proveedor_id" name="proveedor_id" class="select2 col-md-8 col-sx-4 form-control"  required>
                    <option value="">Elija un proveedor</option>
                    @foreach($form['proveedores'] as $prov)
                    <option value="{{ $prov->id }}">{{ $prov->persona->ruc .' '. $prov->persona->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group row">
                <label for="cuenta_id" class="col-md-3 col-sx-1 col-form-label">Cuenta</label>
                <select id="cuenta_id" name="cuenta_id" class="select2 col-md-8 col-sx-4 form-control" required>
                    <option value="">Elija una cuenta</option>
                    @foreach($form['cuentas'] as $cuenta)
                    <option value="{{ $cuenta->id }}">{{ $cuenta->numero . ' ' . $cuenta->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-6">
            <div class="form-group row">
                <label for="condicion_id" class="col-md-3 col-sx-1 col-form-label">Condición</label>
                <select id="condicion_id" name="condicion_id" class="select2 col-md-8 col-sx-4 form-control" required>
                    <option value="">Elija una condición</option>
                    @foreach($form['condiciones'] as $cond)
                    <option value="{{ $cond->id }}">{{  ucwords($cond->name) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group row">
                <label for="sucursal_id" class="col-md-3 col-sx-1 col-form-label">Sucursal</label>


                    @if(count($form['sucursales']) > 1)
                        <select id="sucursal_id" name="sucursal_id" class="select2 col-md-8 col-sx-4 form-control" required>
                            <option value="">Elija una Sucursal</option>
                            @foreach($form['sucursales'] as $suc)
                                <option value="{{ $suc->id }}">{{ $suc->name }}</option>
                            @endforeach
                        </select>
                    @else
                        <div class=" col-md-8 col-sx-4 form-control">
                            {{ $form['sucursales'][0]->name  }}
                        </div>
                    @endif
            </div>

           <div class="row">
            <div class="form-group row">
                <label for="select" class="col-md-4 col-sx-1 col-form-label">Comprobante</label>
                <input id="timbrado" name="timbrado" type="text" class="form-control col-md-4 col-sx-2 " placeholder="Timbrado">

                <input id="comprobante" name="comprobante" type="text" class="form-control col-md-4 col-sx-2" placeholder="Factura o Boleta">
            </div>
           </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Detalles</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-1">#</div>
                <div class="col-1 text-center">Qty</div>
                <div class="col-3 ">Concepto</div>
                <div class="col-2 ">Centro de Costo</div>
                <div class="col-2 text-center">Unitario</div>
                <div class="col-1 text-center">Iva</div>
                <div class="col-1 text-center">Importe</div>
                <div class="col-1"><a id="btnAddDetalle" class="btn btn-primary"><i class="fa fa-plus"></i></a></div>

            </div>
            <hr>
            {{-- para plantilla --}}
            <div id="detalles" class="table-striped" >
                <div class="row detalle" id="detalle1">
                    <div class="col-1"><a onclick="removeDetalle(1)" class="btn btn-danger"><i class="fa fa-trash"></i></a></div>
                    <div class="col-1"><input type="text" class="form-control text-right qty" name="detalles[1][cantidad]" id="cantidad1" placeholder="0" onchange="multiplicar(1)"> </div>
                    <div class="col-3">  <input type="text" class="form-control" name="detalles[1][concepto]" placeholder="Escriba el concepto"></div>
                    <div class="col-2">
                        <select name="detalles[1][centrocosto_id]" class="form-control select2" required>
                            <option value="">Elija un CC</option>
                            @php echo $ccoptions @endphp
                        </select>

                    </div>
                    <div class="col-2"><input type="text" class="form-control text-right unitario" name="detalles[1][unitario]" onchange="multiplicar(1)" placeholder="0"></div>
                    <div class="col-1">
                        <select name="detalles[1][tipoiva]" class="form-control custom-select">
                            <option value="10">10</option>
                            <option value="5">5</option>
                            <option value="0">0</option>
                        </select>
                    </div>
                    <div class="col-2"><input type="text" class="sumar form-control text-right importe" name="detalles[1][importe]" placeholder="0"> </div>
                </div>

            </div>
            {{-- para plantilla --}}
            <div class="row mt-1">
                <div class="col-10">&nbsp;</div>
                <div class="col-2">
                    <input type="text" class="total form-control text-right" name="total" id="totaldet" placeholder="0" readonly value="{{  $gasto->total ?? 0 }}">
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
                <div class="col text-right"><a id="btnAddMP" class="btn btn-primary"><i class="fa fa-plus"></i></a></div>
            </div>
            <hr>

            <div id="tabla_mps" class="table-striped tabla_mps"></div>
            <div class="row mt-1">
                <div class="col-9">&nbsp;</div>
                <div class="col-3">
                    <input type="text" class="total2 form-control text-right" name="totalmp" id="totalmp" placeholder="0" value="0" readonly>
                </div>
            </div>
        </div>
    </div>

</div>


@section('js')

    <script src=" {{ asset('js/comunes.js') }} "></script>

    <script>

    $( document ).ready(function() {




        $('#gastosForm').on('submit', function(e){
            e.preventDefault();
            var ruta = $(this).attr('action');
            console.log('ruta => ' + ruta);
            var arr = ruta.split('/');

            console.log(arr[arr.length-1]);
            if(validate()){
                if( arr[arr.length-1] == 'update'){
                    console.log('update'); console.log( $('#id').val() );
                    var formData = new FormData($(this)[0]);

                    postData(ruta, formData).then(function(rta){
                        console.log('postData OK'); console.log(rta);
                        // $('#gastosForm').trigger('reset');
                        if(rta['cod'] == 200){
                            toastr.options = { "closeButton": true, };
                            toastr.success(rta['msg'], 'Buen Trabajo!');
                        }else{
                            toastr.options = { "closeButton": true, };
                            toastr.error(rta['msg'], 'Atención!');
                        }
                    }).catch(function(error){
                        console.log('postData dio errorrrr'); console.log(error);
                        toastr.options = { "closeButton": true, };
                        toastr.error('Ocurrio un error al actualizar el comprobante', 'Atención!');
                        // Swal.fire('Ocurrio un Error', error.message, 'error');
                    });
                }else{
                    console.log('store');
                    var formData = new FormData($(this)[0]);
                    postData(ruta, formData).then(function(rta){
                        console.log('postData OK'); console.log(rta);
                        // $('#gastosForm').trigger('reset');
                        if(rta['cod'] == 200){
                            toastr.options = { "closeButton": true, };
                            toastr.success(rta['msg'], 'Buen Trabajo!');
                            okPopup();
                        }else{
                            toastr.options = { "closeButton": true, };
                            toastr.error(rta['msg'], 'Atención!');
                        }
                    }).catch(function(error){
                        console.log('postData dio errorrrr'); console.log(error);
                        toastr.options = { "closeButton": true, };
                        toastr.error('Ocurrio un error al registrar el comprobante', 'Atención!');
                        // Swal.fire('Ocurrio un Error', error.message, 'error');
                    });
                }
            }

        });

        function validate(){
            var mps = document.getElementsByClassName("tabla_mps").length;
            console.log('mps =>' + mps);
            if(mps > 0){
                var totalMP = Number($('#totalmp').val());
                var totalDet = Number($('#totaldet').val());
                if(totalMP != totalDet){
                    toastr.options = { "closeButton": true, };
                    toastr.error('Si desea registrar el pago, el total de medios de pago debe ser igual al total de detalles', 'Atención!');
                    return false;
                }
            }
            return true;
        }


        $('#btnAddDetalle').click(function(){
            console.log('btnAddDetalle');
            var divs = document.getElementsByClassName("detalle").length + 1;
            divs = (divs * 1000) + getRandomArbitrary(1, 100);
            var ele = {'id': divs, cantidad:'', concepto:'', centrocosto_id:'', unitario:'', tipoiva:'10', importe:'', dbid:''};
            $('#detalles').append( [ele].map(ItemDetalle).join('') ).promise().done(function(){
                $('#tipoiva'+divs).val(10); //por defecto le pongo iva 10
                $('#cantidad'+divs).focus();
                $('.select2').select2().trigger('change');
            });
        });

        $('#btnAddMP').click(function(){
            console.log('btnAddMP');
            var divs = document.getElementsByClassName("tabla_mps").length + 1;
            divs = (divs * 1000) + getRandomArbitrary(1, 100);
            //id, documento, marca, cuenta, importe
            var ele = {'id': divs, documento:'', marca:'', cuenta_id:'',  importe:'', dbid:''};
            $('#tabla_mps').append( [ele].map(ItemMP).join('') ).promise().done(function(){
                // $('#tipoiva'+divs).val(10); //por defecto le pongo iva 10
                // $('#cantidad'+divs).focus();
                // $('.select2').select2().trigger('change');
            });
        });



        function getRandomArbitrary(min, max) {
            return Math.round(Math.random() * (max - min) + min);
        }

        @unless(empty($gasto))
            populateForm('gastosForm', {!! json_encode($gasto) !!});

            @unless (empty($gasto->detalles))
                $('.detalle').remove();
                @foreach ($gasto->detalles as $detalle)

                    var tipoIva = 0;
                    var total = 0;
                    var cc = 0;
                    @php
                        if($detalle->gravadas_5 > 0){
                            echo "  tipoIva = 5; ";
                        }else if($detalle->gravadas_10 > 0){
                            echo "  tipoIva = 10; ";
                        }
                        $total = $detalle->gravadas_5 + $detalle->gravadas_10 + $detalle->excentas;
                        echo " total = Number($total); ";
                        echo " cc = " . $detalle->centrocosto_id . ";";
                    @endphp

                    var id = document.getElementsByClassName("detalle").length + 1;

                    var ele = {
                        'id': id,
                        cantidad:'{{ $detalle->cantidad }}',
                        concepto:'{{ $detalle->concepto }}',
                        centrocosto_id:'{{ $detalle->centrocosto_id }}',
                        unitario:'{{ $detalle->unitario }}',
                        tipoiva:tipoIva,
                        importe:total,
                        dbid:'{{ $detalle->id }}'
                    };
                    $('#detalles').append( [ele].map(ItemDetalle).join('') ).promise().done(function(){
                        $('#tipoiva'+id).val(tipoIva);
                        $('#cc'+id).val(cc);
                        $('.select2').select2().trigger('change');
                    });
                @endforeach

                var totalMP = 0;

                @unless(empty($gasto->ops[0]->medios))
                    @foreach($gasto->ops[0]->medios as $medio)

                        totalMP += Number({{ $medio->importe }});
                        var divs = document.getElementsByClassName("tabla_mps").length + 1;
                        divs = (divs * 1000) + getRandomArbitrary(1, 100);
                        //id, documento, marca, cuenta, importe
                        var ele = {
                            'id': divs,
                            documento: '{{ $medio->documento }}',
                            marca:'{{ $medio->tarjeta_id }}',
                            cuenta_id:'{{ $medio->cuenta_id }}',
                            importe:'{{ $medio->importe }}',
                            dbid:'{{ $medio->id }}'
                        };
                        $('#tabla_mps').append( [ele].map(ItemMP).join('') ).promise().done(function(){
                            $('#medio'+divs).val({{ $medio->medio_id }});
                            $('#marca'+divs).val({{ $medio->tarjeta_id }});
                            $('#cuenta'+divs).val({{ $medio->cuenta_id }});

                            // $('#cantidad'+divs).focus();
                            // $('.select2').select2().trigger('change');
                        });
                        $('#totalmp').val(totalMP);
                    @endforeach
                @endunless
                $('.select2').select2().trigger('change');
            @endunless
        @endunless



    });


    function okPopup(){
        Swal.fire({
            title: 'Que desea hacer ahora?',
            showDenyButton: true,
            showCancelButton: true,
            cancelButtonText: 'Registrar Otro',
            confirmButtonText: 'Ir a la lista',
            denyButtonText: 'Registrar Pago',
            }).then((result) => {

            if (result.isConfirmed) {
                window.location.href = "{{ route('admin.gastos.index') }}";
            } else if (result.isDenied) { //caca
                console.log('result.isDenied');
                alert('ir a pago');
            } else if (result.isDismissed) {
                location.reload(); //recarga la pagina
            } else if(result.cancel){
                location.reload(); //recarga la pagina
            }

        });
    }

    function multiplicar(id){
        console.log('multiplicar');
        var qty = Number($('#detalle' + id + ' .qty').val());
        var imp = Number($('#detalle' + id + ' .unitario').val());
        var total = qty * imp;
        console.log(qty); console.log(imp); console.log(total);

        $('#detalle' + id + ' .importe').val(total);
        $('.sumar').trigger('change');
    }

    function removeDetalle(id){
        $('#detalle'+id).remove();
        $('.sumar').trigger('change');
    }

    function removeMP(id){
        $('#mp'+id).remove();
        $('.sumar2').trigger('change');
    }


    const ItemDetalle = ({id, cantidad, concepto, centrocosto_id, unitario, tipoiva, importe, dbid}) => `
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
                        <div class="col-2"><input type="text" class="form-control text-right sumar importe" name="detalles[${id}][importe]" placeholder="0" value="${importe}"> </div>
                    </div>
                `;

    const ItemMP = ({id, documento, marca, cuenta, importe, dbid}) => `
    <div class="row mt-1 mp" id="mp${id}">
        <input type="hidden" name="mps[${id}][dbid]" value="${dbid}">

        <div class="col-1"><a onclick="removeMP(${id})" class="btn btn-danger"><i class="fa fa-trash"></i></a></div>
        <div class="col-2">
            <select name="mps[${id}][medio_id]" class="form-control select2" id="medio${id}" required>
                <option value="">Elija un MP</option>
                @php echo $mediosoptions @endphp
            </select>
        </div>

        <div class="col-2">
            <input type="text" class="form-control text-right " name="mps[${id}][documento]" placeholder="0" value="${documento}">
        </div>
        <div class="col-2">
            <select name="mps[${id}][tarjeta_id]" class="form-control custom-select" id="marca${id}">
                <option value="">Elija una TC</option>
                @php echo $marcasoptions @endphp
             </select>
        </div>
        <div class="col-2">
            <select name="mps[${id}][cuenta_id]" class="form-control custom-select" id="cuenta${id}">
                <option value="">Elija una Cuenta</option>
                @php echo $cuentasoptions @endphp
             </select>
        </div>
        <div class="col"><input type="text" class="form-control text-right sumar2 importe" name="mps[${id}][importe]" placeholder="0" value="${importe}"> </div>
    </div>
                `;





    </script>
@stop


@section('css')
<style>

    td.details-control {
        cursor: pointer;
    }


</style>
@stop
