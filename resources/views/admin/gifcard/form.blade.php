<div class="">
    <div class="row">
        <div class="col-6">
            <div class="form-group row">
                <label for="fecha" class="col-md-3 col-form-label">Fecha (<span class="text-danger">*</span>)</label>
                <input id="fecha" name="fecha_venta" type="date" class=" col-md-8 col-sx-4 form-control" required
                @if (isset($venta))
                value="{{$venta->fecha}}"
                 readonly
                @else
                value="{{ date('Y-m-d') }}"
                @endif

                   >
                <input type="hidden" id="condicion_venta" name="condicion_venta" value="1">
            </div>
            <div class="form-group row">
                <label for="cliente_id" class="col-md-3 col-sx-1 col-form-label">Cliente Comprador (<span
                        class="text-danger">*</span>)</label>
                <select id="cliente_id" name="cliente_id" class="select2 col-md-8 col-sx-4 form-control" required  @if (isset($venta)) disabled @endif>
                    <option value="">Elija un cliente</option>
                    @if (isset($venta))
                            @foreach ($clientes as $item)
                                @if ($venta->cliente_id == $item->id )
                                    <option value="{{ $item->id }}" selected>{{ $item->name }} - {{ $item->ruc }}</option>
                                @else
                                    <option value="{{ $item->id }}" >{{ $item->name }} - {{ $item->ruc }}</option>
                                @endif
                            @endforeach
                    @else
                        @foreach ($clientes as $item)
                        <option value="{{ $item->id }}">{{ $item->name }} - {{ $item->ruc }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group row">
                <label for="cuenta_id" class="col-md-3 col-sx-1 col-form-label">Importe (<span
                        class="text-danger">*</span>)</label>
                        @php
                       
                        if(isset($venta))
                        $venta->total=round($venta->total)
                            
                        @endphp
                <input id="importe" name="importe" type="text"
                    class="col-md-8 col-sx-4 form-control formatogs text-right" 
                    @if (isset($venta))
                    value="{{$venta->total}}"
                    readonly
                    @endif
                    required>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group row">
                <label for="condicion_id" class="col-md-3 col-sx-1 col-form-label">Nombre a quien Regala</label>
                <input id="name" name="name" type="text" class="col-md-8 col-sx-4 form-control" 
                @if (isset($venta))
                    value="{{$gif->name}}"
                    @endif
                >
            </div>
            <div class="form-row">
                <label for="condicion_id" class="col-md-3 col-sx-1 col-form-label">Numero de Gifcard</label>
                <input id="numero_gifcard" name="numero_gifcard" type="text" class="col-md-8 col-sx-4 form-control"
                @if (isset($venta))
                    value="{{$gif->numero_gifcard}}"
                    @endif
                >
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Puede Elegir Articulos(es opcional)</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-1">#</div>
                <div class="col-4 text-center">Articulo / Servicio</div>
                <div class="col-4 text-center">Importe Normal</div>
                <div class="col-lg-3"><button type="button" id="btnAddDetalle" class="btn btn-primary float-right" @if (isset($venta)) disabled @endif><i
                            class="fa fa-plus"></i></button></div>
            </div>
            <hr>
            <div id="detalles" class="table-striped">
                @if (!isset($venta))
                <div class="row detalle item_articulo" id="detalle1">
                    <div class="col-1"><a onclick="removeDetalle(1)" class="btn btn-danger"><i
                                class="fa fa-trash"></i></a></div>
                    <div class="col-4">
                        <select id="producto_id" class="form-control select2" indice='1' style="width: 100%"
                            name="detalles[1][articulo]" required>
                            <option value="null" selected disabled>Elija un producto o Servicio
                            </option>
                            <optgroup label="Productos">
                                @foreach ($articulos as $pro)
                                    @if ($pro->tipo == 'producto')
                                        <option value="{{ $pro->id }}"> {{ $pro->name }} </option>
                                    @endif
                                @endforeach
                            </optgroup>
                            <optgroup label="Combos">
                                @foreach ($articulos as $com)
                                    @if ($com->tipo == 'combo')
                                        <option value="{{ $com->id }}">{{ $com->name }}</option>
                                    @endif
                                @endforeach
                            </optgroup>
                            <optgroup label="servicios">
                                @foreach ($articulos as $com)
                                    @if ($com->tipo == 'servicio')
                                        <option value="{{ $com->id }}">{{ $com->name }}</option>
                                    @endif
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                    <div class="col-4"><input type="text" id='importe'
                            class="sumar form-control text-right  formatogs" name="detalles[1][importe]" placeholder="0"
                            readonly> </div>
                </div>
                @endif

            </div>
            {{-- para plantilla --}}
            <div class="row mt-1">
                <div class="col-10">&nbsp;</div>
                <div class="col-2">
                    <input type="text" class="total form-control text-right" name="total" id="totaldet"
                        placeholder="0" readonly value="{{ $gasto->total ?? 0 }}">
                </div>
            </div>
        </div>
    </div>
    <div class="card" id="div_medios_pago">
        <div class="card-header">
            <h3 class="card-title">Medios de Pago (<span class="text-danger">*</span>)</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-1">#</div>
                <div class="col-2">Medio</div>
                <div class="col-2">Numero</div>
                <div class="col-2">Tarjeta</div>
                <div class="col-2">Cuenta</div>
                <div class="col-2 text-center">Importe</div>
                <div class="col text-right"><a id="btnAddMP" class="btn btn-primary"><i class="fa fa-plus"></i></a>
                </div>
            </div>
            <hr>
            <div id="tabla_mps" class="table-striped tabla_mps"></div>
            <div class="row mt-1">
                <div class="col-9">&nbsp;</div>
                <div class="col-3">
                    <input type="text" class="total2 form-control text-right" name="totalmp" id="totalmp"
                        placeholder="0" value="0" readonly>
                </div>
            </div>
        </div>
    </div>
</div>
@section('js')
    <script src=" {{ asset('js/comunes.js') }} "></script>
    <script>
        $(document).ready(function() {
            @php
                echo 'var articulos_js = ' . json_encode($articulos) . '; ';
                echo 'var artoptions1_js = ' . json_encode($artoptions1) . '; ';
                echo 'var artoptions2_js = ' . json_encode($artoptions2) . '; ';
                echo 'var artoptions3_js = ' . json_encode($artoptions3) . '; ';
                echo 'var medios_js = ' . json_encode($medios) . '; ';
            @endphp
           
            $('#gastosForm').on('submit', function(e) {
                e.preventDefault();
                var ruta = $(this).attr('action');
                console.log('ruta => ' + ruta);
                var arr = ruta.split('/');

                if (validate()) {
                    if (arr[arr.length - 1] == 'update') {
                        console.log('update');
                        console.log($('#id').val());
                        var formData = new FormData($(this)[0]);

                        postData(ruta, formData).then(function(rta) {
                            console.log('postData OK');
                            console.log(rta);
                            if (rta['cod'] == 200) {
                                toastr.options = {
                                    "closeButton": true,
                                };
                                toastr.success(rta['msg'], 'Buen Trabajo!');
                                window.location.href = "{{ route('admin.giftcard.index') }}";
                               

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
                        console.log('store');
                        var formData = new FormData($(this)[0]);
                        postData(ruta, formData).then(function(rta) {
                            console.log('postData OK');
                            console.log(rta);
                            if (rta['cod'] == 200) {
                                toastr.options = {
                                    "closeButton": true,
                                };
                                toastr.success(rta['msg'], 'Buen Trabajo!');
                                window.location.href = "{{ route('admin.giftcard.index') }}";
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
                        });
                    }
                }
            });

            function validate() {
                //obligadamente debe tener medio de pago para venta
                if (comprobarVentas()) {
                    if (comprobarMedios()) {
                        return true;
                    }
                }
                return false
            }

            function comprobarVentas() {
                var mensajes_de_error = "";
                var errores = 0;
                var mps = $('#detalles .item_articulo').length;
                console.log(mps)
                if (mps > 0) {
                    $('#detalles .item_articulo').each(function(e, data) {
                        console.log(data);
                        var art = $(this).find("select[id='producto_id']").val();
                        if (art == null) {
                            $(this).find("select[id='producto_id']").val();
                            mensajes_de_error += "Por favor Seleccione un Articulo linea  N° " + e +
                                " o elimine la seccion de articulos \n ";
                            errores = parseInt(errores) + 1;
                        }
                    })
                    if (Number($('#totaldet').val().replace(/\./g, '')) != Number($('#importe').val().replace(/\./g,
                            ''))) {
                        errores = parseInt(errores) + 1;
                        mensajes_de_error += "El Monto de los articulos no coincide con el pago \n ";
                    }
                    if (errores == 0) {
                        return true;
                    } else {
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
                } else {
                    return true;
                }
            }

            function comprobarMedios() {
                var mensajes_de_error = "";
                var errores = 0;
                var monto = 0;
                var mps = $('#tabla_mps .medio_pago').length;
                if (mps > 0) {
                    $('#tabla_mps .medio_pago').each(function(e, data) {
                        monto = monto + $(this).find("input[id='met_monto']").val().replace(/\./g, '');
                        var metodo = $(this).find("select[id='met_medio']").val();
                        if (metodo != null) {
                            var ele = medios_js.find(item => item.id == metodo);
                            if (ele.requiere_numero == true) {
                                if (!$(this).find("input[id='met_documento']").val()) {
                                    mensajes_de_error +=
                                        "Proporcione un numero de documento en la linea N° " +
                                        e + " \n ";
                                    errores = parseInt(errores) + 1;
                                }
                            }
                            if (ele.requiere_marca == true) {
                                if ($(this).find("select[id='met_tarjeta']").val() == 0) {
                                    mensajes_de_error += "Proporcione una tarjeta en la linea N° " + e +
                                        " \n ";
                                    errores = parseInt(errores) + 1;
                                };
                            }
                            if (ele.requiere_cuenta == true) {
                                if ($(this).find("select[id='met_cuenta']").val() == 0) {
                                    mensajes_de_error += "Proporcione un numero de cuenta en la linea N° " +
                                        e +
                                        " \n ";
                                    errores = parseInt(errores) + 1;
                                };
                            }
                            if ($(this).find("input[id='met_monto']").val().replace(/\./g, '') <= 0) {
                                mensajes_de_error += "Proporcione un Importe en la linea N° " + e + " \n ";
                                errores = parseInt(errores) + 1;
                            };
                        } else {
                            mensajes_de_error += "Seleccione un Metodo de pago por favor en la linea N° " +
                                e +
                                " \n ";
                            errores = parseInt(errores) + 1;
                        }
                    })
                    if (parseInt(monto) != Number($('#importe').val().replace(/\./g, ''))) {
                        errores = parseInt(errores) + 1;
                        mensajes_de_error += "El Monto no coincide con el pago \n ";
                    }
                    if (errores == 0) {
                        return true;
                    } else {
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
                } else {
                    toastr.error('Debe selecionar un metodo de pago para el gifcard', 'Atención!');
                    return false
                }

            }

            $('#btnAddDetalle').click(function() {
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
                    dbid: '',
                    artoptions1: artoptions1_js,
                    artoptions2: artoptions2_js,
                    artoptions3: artoptions3_js,
                };
                $('#detalles').append([ele].map(ItemDetalle).join('')).promise().done(function() {
                    $('#cantidad' + divs).focus();
                });
            });


            $('#btnAddMP').click(function() {
                var divs = document.getElementsByClassName("tabla_mps").length + 1;
                divs = (divs * 1000) + getRandomArbitrary(1, 100);
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

        });
        $(document).on("keyup", ".formatogs", function() {
            getFormatGS(this)
        })

        function getFormatGS(input) {
            var num = input.value.replace(/\./g, '');
            if (num) {
                if (!isNaN(num)) {
                    if ((input.value.length == 2) && (input.value[0] == 0)) {
                        input.value = input.value.replace(/^0+/, '');
                        num = input.value.replace(/\./g, '');
                    }
                    num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1.');
                    num = num.split('').reverse().join('').replace(/^[\.]/, '');
                    input.value = num;
                } else {
                    input.value = input.value.replace(/[^\d\.]*/g, '');
                    if (input.value.trim() == '') {
                        input.value = 0;
                    }
                }
            } else {
                input.value = 0;
            }
        }


        function removeDetalle(id) {
            $('#detalle' + id).remove();
            CalculosDetalles()
        }

        function removeMP(id) {
            $('#mp' + id).remove();
            CalculosDetalles()
        }
        const ItemDetalle = ({
            id,
            dbid,
            artoptions1,
            artoptions2,
            artoptions3,
            read="",
        }) => `

        <div class="row detalle mt-2 item_articulo" id="detalle${id}">
                    <div class="col-1"><button   type="button" onclick="removeDetalle(${id})" class="btn btn-danger" ${read}><i class="fa fa-trash"></i></button></div>
                    <div class="col-4">
                        <select id="producto_id" class="select2 form-control" indice='1' style="width: 100%"
                                name="detalles[${id}][articulo]" required ${read}>
                                <option value="null" selected disabled>Elija un producto o Servicio
                                </option>
                                <optgroup label="Productos">
                                    ${artoptions1} 
                                </optgroup>
                                <optgroup label="Combos">
                                     ${artoptions2} 
                                </optgroup>
                                <optgroup label="servicios">
                                     ${artoptions3} 
                                </optgroup>
                            </select>
                    </div>
                    <div class="col-4"><input type="text" id='importe' class="sumar form-control text-right  formatogs" name="detalles[${id}][importe]" placeholder="0" readonly> </div>
                </div>
                `;

        const ItemMP = ({
            id,
            documento,
            marca,
            cuenta,
            importe,
            dbid,
            read="",
        }) => `

    <div class="row mt-1 mp medio_pago" id="mp${id}">
        <input type="hidden" name="mps[${id}][dbid]" value="${dbid}">

        <div class="col-1"><button type="button" onclick="removeMP(${id})" class="btn btn-danger" ${read} ><i class="fa fa-trash" ></i></button></div>
        <div class="col-2">
            <select name="mps[${id}][medio_id]" class="form-control select2" id="met_medio" required ${read}>
                <option value="">Elija un MP</option>
                @php echo $mediosoptions @endphp
            </select>
        </div>

        <div class="col-2">
            <input type="text" class="form-control text-right " name="mps[${id}][documento]" id="met_documento" placeholder="0" value="${documento}" ${read}>
        </div>
        <div class="col-2">
            <select name="mps[${id}][tarjeta_id]" class="form-control custom-select" id="met_tarjeta" ${read}>
                <option value="">Elija una TC</option>
                @php echo $marcasoptions @endphp
             </select>
        </div>
        <div class="col-2">
            <select name="mps[${id}][cuenta_id]" class="form-control custom-select" id="met_cuenta" ${read}>
                <option value="">Elija una Cuenta</option>
                @php echo $cuentasoptions @endphp
             </select>
        </div>
        <div class="col"><input type="text" class="form-control text-right sumar2 importe" id="met_monto" name="mps[${id}][importe]" placeholder="0" value="${importe}" ${read}> </div>
    </div>
                `;

        @php
            echo 'var articulos_js = ' . json_encode($articulos) . '; ';
            echo 'var artoptions1_js = ' . json_encode($artoptions1) . '; ';
            echo 'var artoptions2_js = ' . json_encode($artoptions2) . '; ';
            echo 'var artoptions3_js = ' . json_encode($artoptions3) . '; ';
        @endphp
        $(document).on("change", "#detalles select[id^='producto_id']", function() {
            var indice = $(this).closest(".detalle");
            var ele = articulos_js.find(item => item.id == this.value);
            $(indice).find("input[id='importe']").val(ele.precio)
            CalculosDetalles()
        });

        function CalculosDetalles() {
            var total = 0;
            $('#detalles div input ').each(function(e, data) {
              
                var prec = parseInt($(this).val().replace(/\./g, ''));
                if (!isNaN(prec)) {
                    total = total + prec;
                }

            })
            
            $("#totaldet").val(total)
        }
        setTimeout(function(){  $('.sumar2').trigger('change')   
    console.log(  $('.sumar2')) }, 2000);

        @unless(empty($gifDe[0]))
            @php
            $contador=0;
            @endphp
            @foreach ($venta->cobroDetalles as $medio)
                var divs = document.getElementsByClassName("tabla_mps").length + 1;
                var ele = {
                    'id': divs,
                    documento: '',
                    marca: '',
                    cuenta_id: '',
                    importe: '',
                    dbid: '',
                    read: 'disabled',
                };
            $('#tabla_mps').append( [ele].map(ItemMP).join('') ).promise().done(function(){
               $(this).find("[id='met_medio']").val('{{$medio->medio_cobro_id}}')
               $(this).find("[id='met_documento']").val('{{$medio->documento}}')
               $(this).find("[id='met_tarjeta']").val('{{$medio->tarjeta_id}}')
               $(this).find("[id='met_cuenta']").val('{{$medio->cuenta_id}}')
               $(this).find("[id='met_monto']").val('{{$medio->importe}}')
              
            });
            
            @endforeach

            @foreach ($gifDe as $de)           
            var divs = $('#detalles div input ').length + 1;
                var ele = {
                    'id': divs,
                    cantidad: '',
                    concepto: '',
                    centrocosto_id: '',
                    unitario: '',
                    tipoiva: '10',
                    importe: '',
                    dbid: '',
                    artoptions1: artoptions1_js,
                    artoptions2: artoptions2_js,
                    artoptions3: artoptions3_js,
                    read: 'disabled',
                };
                $('#detalles').append([ele].map(ItemDetalle).join('')).promise().done(function() {
                    var div=$('#detalles div select ').last()
                    $(div).val('{{$de->articulo_id}}').trigger('change');  
                });
            @endforeach
        @endunless

    function Factura(){
    Swal.fire({
    title: 'Es este el Cliente.?',
    text: "Cliente: "+$('#cliente_id option:selected').text(),
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si.! Facturar'
    }).then((result) => {
        if (result.isConfirmed) {
            guardarFactura();
            tiempoEspera()
        }else{
            console.log("cancel");
        }
    })
}
function guardarFactura(){
    var _url = "{{route('admin.vender.facturar')}}";
    var formData = new FormData();
    formData.append( 'id_venta', $('#venta_id').val() );
    formData.append( 'cliente', $('#cliente_id').val() );
    formData.append('factura_detallada',false ); 
    formData.append( '_token', '{{ csrf_token() }}');
    postData(_url, formData).then(function(rta){
        console.log(rta);
        if (rta.cod==200) {
            Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Factura Registrada',
            showConfirmButton: false,
            timer: 1500
            })
            var ventana;
            let url= "{{ route('admin.facturar',':id') }}";
            url = url.replace(':id', $('#venta_id').val());
            ventana = window.open(url , '_');
            setTimeout(function(){   ventana.close(); }, 4000);
            window.location.href = "{{ route('admin.giftcard.index') }}";
        } else {
            Swal.fire({title: "Error", icon: 'warning',html: rta.msg});
        }
    }).catch(function(error){
        console.log('postData dio error'); console.log(error);
        Swal.fire('Ocurrio un Error', error, 'error');
    }) 
}
function tiempoEspera(){
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
$('#btn-factura-imprimir').on('click', function(e){
    var ventana;
    let url= "{{ route('admin.facturar',':id') }}";
    url = url.replace(':id',  $('#venta_id').val());
    ventana = window.open(url , '_');
    setTimeout(function(){   ventana.close(); }, 4000);
})


    </script>
@stop
