{{-- contruimos la tabla --}}
<div class="row">
    <div class="col-12">
        <div id="formDatosDetalles">
            <table class="table table-bordered col-12">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>CANTIDAD</th>
                        <th>DESCRIPCION</th>
                        <th>PRECIO</th>
                        <th colspan="3">
                            <table class="table table-bordered">
                                <thead>
                                    <th colspan="3">PRECIO</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Excenta</th>
                                        <th>5%</th>
                                        <th>10%</th>
                                    </tr>
                                </tbody>
                            </table>
                        </th>
                    </tr>
                </thead>
                <tbody id="tabla-lista-detalles">
                    <tr class="fila_producto">
                        <td style="width:5%">
                            <button class="btn btn-danger" type="button" id="remove_detalles"> <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                            <input type="hidden" id="detalle_iva" name="detalles[0][iva]">
                            <input type="hidden" id="es_promo" name="detalles[0][es_promo]">
                            <input type="hidden" id="es_combo" name="detalles[0][es_combo]">
                            <input type="hidden" id="combinacion" name="detalles[0][combinacion]">
                        </td>
                        <td  style="width:5%">
                            <input type="text" class="form-control siempreCero text-right" value="0" id="detalles-cantidad"
                                 name="detalles[0][cantidad]">
                        </td>
                        <td style="width:30%">
                            <select id="producto_id" class="select2 form-control" indice='1' style="width: 100%"
                                name="detalles[0][articulo]">
                                <option value="null" selected disabled>Elija un producto o Servicio
                                </option>
                                <optgroup label="Productos">
                                    @foreach ($articulos as $pro)
                                    @if ( $pro->tipo == 'producto' )
                                    <option value="{{ $pro->id }}"> {{ $pro->name }} </option>
                                    @endif
                                    @endforeach
                                </optgroup>
                                <optgroup label="Combos">
                                    @foreach ($articulos as $com)
                                    @if ( $com->tipo == 'combo' )
                                    <option value="{{ $com->id }}">{{ $com->name }}</option>
                                    @endif
                                    @endforeach
                                </optgroup>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control formatogs text-right" value="0" id="detalles-precio"
                                 name="detalles[0][precio]">
                        </td>
                        <td>
                            <input type="text" class="form-control" value="0" readonly id="detalles-excenta">
                        </td>
                        <td>
                            <input type="text" class="form-control" value="0" readonly id="detalles-cinco">
                        </td>
                        <td>
                            <input type="text" class="form-control" value="0" readonly id="detalles-diez">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>