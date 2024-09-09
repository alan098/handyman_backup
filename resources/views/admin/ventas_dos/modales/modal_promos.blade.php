<div class="modal fade bd-example-modal-lg" id="modal_promos" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog agrandar" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa-solid fa-balloons"></i></i>Hola! estas son Promos del dia ;) <i class="fa-solid fa-balloons"></i></h4>
            </div>
            <div>
                <div class="modal-body">
                    <div class="form-row mb-1">
                        <div class="col-4 border">
                            <x-jet-label value="Promo" />
                        </div>
                        <div class="col-6 border">
                            <div class="form-row mb-1">
                                <div class="col-4 border">
                                    Cantidad
                                </div>
                                <div class="col-4 border">
                                    Articulo
                                </div>
                                <div class="col-4 border">
                                    Precio Promo
                                </div>
                            </div>
                        </div>
                        <div class="col-2 border">
                            <x-jet-label value="Acciones" />
                        </div>
                    </div>
                    <input type="hidden" id="tipo_promo">
                    <input type="hidden" id="indice">
                    <input type="hidden" id="precio">
                    <input type="hidden" id="iva">
                    <div id="seccion_promos">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="aplicar_promo">Aplicar Promo</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                  </div>
            </div>
        </div>
    </div>
</div>