<div class="card shadow  col-12">
    <div class="card-header">
        <div class="form-row col-12 border">
            <div class="col"><h5>Fecha desde</h5></div>
            <div class="col" id="fe_de_fil">{{date('Y-m-01')}}</div>
            <div class="col"><h5>Fecha Hasta</h5></div>
            <div class="col" id="fe_ha_fil">{{date('Y-m-d')}}</div>
        </div>
        <div class="form-row">
            
            <div class="col">
                Bruto
            </div>
            <div class="col">
                Descuentos generales
            </div>
            <div class="col">
                Descuentos Por servicio
            </div>
            <div class="col">
                Total
            </div>
        </div>
        <div class="form-row">
            
            <div class="col" id="1_bru">
                
            </div>
            <div class="col" id="1_des">
                
            </div>
            <div class="col" id="1_des_in">
                
            </div>
            <div class="col" id="1_re">
                
            </div>
        </div>

    </div>
    <div class="card-body">
        <table class="table-bordered  table-responsive" id="table_ingresos_a">
        </table>
    </div>
</div>
