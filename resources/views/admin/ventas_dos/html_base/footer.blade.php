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
        <div class="col-5">
            <style>
                .big-checkbox {width: 30px; height: 30px;}
            </style>
            <div class="form-check form-check-inline">
                <input class="form-check-input big-checkbox" type="radio" name="tipo_cie" id="con_cierre1" value="guardar" checked>
                <label class="form-check-label" for="inlineRadio1"><h3>Guardar</h3></label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input big-checkbox" type="radio" name="tipo_cie" id="con_cierre2" value="cerrar">
                <label class="form-check-label" for="inlineRadio2"><h3>Guardar y Cerrar</h3></label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input big-checkbox" type="radio" name="tipo_cie" id="con_cierre3" value="facturar">
                <label class="form-check-label" for="inlineRadio3"><h3>Cerrar y Facturar</h3></label>
            </div>
        </div>
        
    </div>
    <div class="form-row mt-3">
        <div class="col-5"></div>
        <div class="col-4" style="display: none" id="carga_lenta"> 
        </div>
        <button type="button" class="btn btn-info" id="btn-guardar">confirmar</button>
        
        <div class="col-4" id="loader_WH">
            <div class="loader"></div>
        </div>
    </div>
</div>