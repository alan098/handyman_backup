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
                <a class="nav-link active" id="pills-datos-tab" data-toggle="pill" href="#pills-datos" role="tab"
                    aria-controls="pills-datos" aria-selected="true">
                    <h3>Servicios</h3>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-productos-tab" data-toggle="pill" href="#pills-productos"
                    role="tab" aria-controls="pills-productos" aria-selected="false">
                    <h3>Productos</h3>
                </a>
            </li>
        </ul>
        {{-- contruimos la tabla --}}
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-datos" role="tabpanel" aria-labelledby="pills-datos-tab">
                @include('admin.ventas_dos.html_base.productos_servicios.servicios')
            </div>
            <div class="tab-pane fade " id="pills-productos" role="tabpanel"
                aria-labelledby="pills-productos-tab">
                @include('admin.ventas_dos.html_base.productos_servicios.productos')
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
                    <table class="table table-bordered" class="">
                        <thead class="thead-dark">
                            <tr>
                                <th colspan="3">#</th>
                                <th>
                                      {{-- @if (($cerrada->concluido == true) )
                                        disabled
                                    @endif --}}
                                    <Button class="btn btn-light mr-2" title="Adregar Detalles" id="add_detalles_venta" type="button"
                                    ><i class="fas fa-plus"></i> </Button>
                                    
                                    {{-- <button type="button" class="btn btn-primary ml-2" id="btn-descuento"
                                        onclick="AgregarDescuento()" id="agregar_descuento">Agregar Descuento
                                    </button> --}}
                                  
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="table-success">
                                <td>Sub-Total</td>
                                <td id="sub-ex">0</td>
                                <td id="sub-5">0</td>
                                <td id="sub-10">0</td>
                            </tr>
                            <tr class="table-success">
                                <td>Total A Pagar</td>
                                <td colspan="3" id="total-pagar">0</td>
                            </tr>
                            <tr class="table-success">
                                <td rowspan="2">Liquidacion del iva</td>
                                <td>5%</td>
                                <td>10%</td>
                                <td>Total Iva</td>
                            </tr>
                            <tr class="table-success">
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
</div>