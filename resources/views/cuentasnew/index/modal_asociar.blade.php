<div class="modal fade" id="eventos_pendientes"  role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
    <form action="#" method="POST">
        @csrf
        <input type="hidden" name="pid" id="pid">
        <input type="hidden" name="pid_name" id="pid_name">
        <div class="modal-content">
            <div class="modal-header">
                <div class="container">
                    <div class="form-row">
                        <div class="col-3"> 
                            <h5 class="modal-title" id="comprobantesProveedorTitle"></h5> 
                        </div>
                        <div class="col">
                            <div class="text-danger float-right">Seleccione un Evento para asociar, solo se puede asociar uno a la vez</div>
                        </div>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm" id="tablaComprobantes">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Cliente</th>
                                <th>Inicio</th>
                                <th>Fin</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="form-row">
                    <div class="col-12">
                        <table class="table" id="detalles_asociados">
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="previo_consulta" onclick="PrevioConsulta()" disabled>Asociar Cuenta</button>
            </div>
        </div>
    </form>
</div>
</div>