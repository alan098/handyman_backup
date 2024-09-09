<div class="modal fade bd-example-modal-lg" id="modal_descuentos" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" style="max-width: 100%;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Añadir Descuento</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" id="tabla_descuento_general">
                    <thead>
                        <tr>
                            <td>Precio Real</td>
                            <td>Descuento Efectivo</td>
                            <td>Descuento Porcentual(1 al 100)</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="hidden" id="id_referencia">
                                <input type="text" class="form-control siempreCero text-right" value="1"
                                    id="descuento_real" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control formatogs text-right"
                                    id="descuento_efectivo_modal" value="0">
                            </td>
                            <td>
                                <input type="text" class="form-control siempreCero text-right"
                                    id="descuento_porcentaje_modal" value="0">
                                    <input type="hidden" id="tr_value">
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                       <button class="btn btn-primary mb-2" onclick="aplicarDescuento()">Aplicar Descuento</button>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
