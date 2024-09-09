<!-- Modal agregar -->
<style>
  .mod-long {
    max-width: 80%;
  }
</style>
<div class="modal fade bd-example-modal-lg"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" id="modal_record" aria-hidden="true">
  <div class="modal-dialog modal-lg mod-long" role="document">
    <div class="modal-content bg-fuchsia">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Hola...! este es un Recordatorio </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-row">
          <div class="col">
            <h5>Cumpleñer@s</h5>
          </div>
        </div>
        <div class="form-row">
          <div class="col">
            <x-jet-label value="Cliente"/>
          </div>
          <div class="col">
            <x-jet-label value="RUC"/>
          </div>
          <div class="col">
            <x-jet-label value="Fecha cumple"/>
          </div>
          <div class="col">
            <x-jet-label value="Telefono"/>
          </div>
        </div>
        <div  id="item_cumple">

        </div>
        <hr>
        <hr>
        <div class="form-row">
          <div class="col">
            <h5>Personas para proximo servicio</h5>
          </div>
        </div>
        <div class="form-row">
          <div class="col">
            <x-jet-label value="Cliente"/>
          </div>
          <div class="col">
            <x-jet-label value="RUC"/>
          </div>
          <div class="col">
            <x-jet-label value="Servicio"/>
          </div>
          <div class="col">
            <x-jet-label value="Mensaje"/>
          </div>
        </div>
        <hr>
        <div id="recordatorios">

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">RECORDARMELO DENTRO DE 30 MINUTOS</button>
        <button type="button" class="btn btn-primary" onclick="vistear()">GRACIAS YA NO LO NECESITO VER</button>
      </div>
    </div>
  </div>
</div>