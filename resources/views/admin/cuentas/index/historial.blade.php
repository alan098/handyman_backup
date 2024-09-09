<div class="modal fade bd-example-modal-lg"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" id="modal_historial" aria-hidden="true">
    <div class="modal-dialog modal-lg mod-long" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <x-cabecera>
                <x-slot name='title'>
                    Historial
                </x-slot>
                <x-slot name='subtitle'>
                </x-slot>
            </x-cabecera>
        </div>
        <div class="modal-body">
            <div class="form-row">
                <div  id="responsive_table" class="col-12">
                    <table class="table" id="tablaListadoHistorial">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Servicio</th>
                                <th>Colaborador</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">OK Cerrar</button>
        </div>
      </div>
    </div>
  </div>
