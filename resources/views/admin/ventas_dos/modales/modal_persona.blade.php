<!-- Modal -->
<div class="modal fade" id="modal_persona" role="dialog" aria-labelledby="formCrudModalTitle" aria-hidden="true">
    <div class="modal-dialog agrandar" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formCrudModalTitle">Nueva Persona</h5>
                    <a class="btn btn-secondary ml-5" title="Buscar Datos" target="_blank" href="https://www.ruc.com.py/"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="name" class="col-form-label">Ruc: <small>(<span class="text-danger">*</span>)</small></label>
                                <input type="text" class="form-control form-control-sm" id="ruc_persona" name="ruc_persona" autofocus required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="name" class="col-form-label">Razón Social: <small>(<span class="text-danger">*</span>)</small></label>
                                <input type="text" class="form-control form-control-sm" id="name_persona" name="name_persona" autofocus required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="nombre_fantasia" class="col-form-label">Nombre de Fantasía:</label>
                                <input type="text" class="form-control form-control-sm" id="nombre_fantasia_persona" name="nombre_fantasia_persona" autofocus >
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="direccion" class="col-form-label">Dirección:</label>
                                <input type="text" class="form-control form-control-sm" id="direccion_persona" name="direccion_persona" autofocus >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="direccion" class="col-form-label">Cumpleaños:</label>
                                <input type="date" class="form-control form-control-sm" id="cumple_persona" name="cumple_persona"  >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="telefono" class="col-form-label">Teléfono:</label>
                                <input type="text" class="form-control form-control-sm" id="telefono_persona" name="telefono_persona" autofocus >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="email" class="col-form-label">Correo Eléctronico:</label>
                                <input type="email" class="form-control form-control-sm" id="email_persona" name="email_persona" autofocus >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="es_cliente_persona" name="es_cliente_persona" checked>
                                    <label class="form-check-label" for="es_cliente">Es Cliente?</label>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="es_proveedor_persona" name="es_proveedor_persona">
                                    <label class="form-check-label" for="es_proveedor">Es Proveedor?</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="sumbitButton" class="btn btn-primary" type="button">
                        <span id="submitSpinner" class="spinner-border-sm" role="status" aria-hidden="true"></span>
                        Guardar
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>

                </div>
            </div>
    </div>
</div>
<!-- Modal -->