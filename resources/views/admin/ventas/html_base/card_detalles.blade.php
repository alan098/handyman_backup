<style>
    th {
        text-align: center;
    }

    td {
        text-align: center;
    }
</style>

<div class="card">
    <div class="card-header">
        Detalles
    </div>
    <div class="card-body">
        {{-- dividimos productos y combos --}}
        <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-productos-tab" data-toggle="pill" href="#pills-productos"
                    role="tab" aria-controls="pills-productos" aria-selected="true">
                    <h3>Productos</h3>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-datos-tab" data-toggle="pill" href="#pills-datos" role="tab"
                    aria-controls="pills-datos" aria-selected="false">
                    <h3>Servicios</h3>
                </a>
            </li>
        </ul>
        {{-- contruimos la tabla --}}
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-productos" role="tabpanel"
                aria-labelledby="pills-productos-tab">
                @include('admin.ventas.html_base.productos_servicios.productos')
            </div>
            <div class="tab-pane fade" id="pills-datos" role="tabpanel" aria-labelledby="pills-datos-tab">
                @include('admin.ventas.html_base.productos_servicios.servicios')
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div id="formResumen">
                    <div id="seccion_descuento" style="display: none">
                        <table class="table table-bordered" id="tabla-descuento">
                            <thead>
                                <tr>
                                    <td>Cantidad</td>
                                    <td>Descuento Efectivo</td>
                                    <td>Descuento Porcentual(1 al 100)</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="text" class="form-control siempreCero text-right" value="1"
                                            id="descuento_cantidad" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control siempreCero text-right" id="descuento_efectivo"
                                            value="0" >
                                    </td>
                                    <td>
                                        <input type="text" class="form-control siempreCero text-right" id="descuento_porcentaje"
                                            value="0" >
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger" id="quitarDes"><i class="fas fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th colspan="3">#</th>
                                <th>
                                    <Button class="btn btn-light mr-2" id="add_detalles_venta" type="button"
                                    @if (isset($id_venta) && ($cerrada->concluido == true) )
                                        disabled
                                    @endif
                                    ><i class="fas fa-plus"></i> </Button>
                                    @if (isset($id_venta))
                                    {{-- <button type="button" class="btn btn-primary ml-2" id="btn-descuento"
                                        @if (isset($id_venta) && ($cerrada->concluido == true) )
                                            disabled
                                        @endif
                                        onclick="AgregarDescuento()" id="agregar_descuento">Agregar Descuento</button> --}}
                                    @endif
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Sub-Total</td>
                                <td id="sub-ex">0</td>
                                <td id="sub-5">0</td>
                                <td id="sub-10">0</td>
                            </tr>
                            <tr>
                                <td>Total A Pagar</td>
                                <td colspan="3" id="total-pagar">0</td>
                            </tr>
                            <tr>
                                <td rowspan="2">Liquidacion del iva</td>
                                <td>5%</td>
                                <td>10%</td>
                                <td>Total Iva</td>
                            </tr>
                            <tr>
                                <td id="iva-5">0</td>
                                <td id="iva-10">0</td>
                                <td id="iva-total">0</td>
                            </tr>
                            <tr id="des-cuento" style="display: none">
                                <td>Descuento</td>
                                <td>
                                    <input type="text" value="0" class="form-control siempreCero text-right" id="descuentoDado" name="descuentoDado" readonly> 
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="form-row">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Obs:</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" name="obs" rows="3"></textarea>
                </div>
            </div>
        </div>
        <div class="form-row ">
            <div class="col-4"></div>
            <div class="col-5" style="display: none" id="carga_page">
                    @if (!isset($gif))
                    @if (isset($id_venta) && ($cerrada->concluido == true) )
                    @if ($factura)
                    <button type="button" class="btn btn-primary ml-2" id="btn-factura-imprimir">Imprimir Factura</button> 
                    @else
                    <button type="button" class="btn btn-primary ml-2"  onclick="Factura()">Generar Factura</button>
                        <input type="checkbox"  id="factura_detallada">
                    <small>Factura Detallada</small>
                    @endif
                    @else
                    <button type="button" class="btn btn-primary" id="btn-guardar">Guardar</button>
                    @if (isset($id_venta))
                    <button type="button" class="btn btn-primary ml-2" id="btn-cerrar" title="Cerrar la venta">Cerrar Venta</button>
                    @endif
                    @if (isset($id_venta))
                    <button type="button" class="btn btn-primary ml-2" id="btn-facturar" title="Cerrar Venta y Generar Factura">Cerrar Venta Facturar </button>
                    @endif

                    @endif
                @else
                    <button type="button" class="btn btn-primary" id="btn-guardar">Guardar</button>
                @endif
                
                
            </div>
            <div class="col-4" id="loader_WH">
                <div class="loader_WH"></div>
            </div>
        </div>
    </div>
</div>