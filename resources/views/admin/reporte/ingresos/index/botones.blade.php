<div class="card shadow mb-3 col-md-12 text-black" style="background: #7EC0EE;">
    <div class="card-header">
        <div class="btn-group col-12 botonGroup" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-secondary"   id="0_1">INGRESOS POR VENTAS</button>
            <button type="button" class="btn btn-primary" id="0_2">INGRESOS POR SERVICIOS</button>
            <button type="button" class="btn btn-primary"   id="0_3">COMISIONES</button>
            <button type="button" class="btn btn-primary"   id="0_4">LOCALES</button>
            <button type="button" class="btn btn-primary"   id="0_5">RESUMEN DE INGRESOS</button>
        </div>
    </div>
    <div class="card-body">
        <div id="datatable_seccion" style="display: none">
            <div  id="i_0_1" style="display: block">
                @include('admin.reporte.ingresos.datos.ingresos_a')
            </div>
            <div class=" container-fluid" id="i_0_2" style="display: none">
                @include('admin.reporte.ingresos.datos.ingresos_i')
            </div>
            <div  id="i_0_3" style="display: none">
                @include('admin.reporte.ingresos.datos.comisiones')
            </div>
            <div  id="i_0_4" style="display: none">
                @include('admin.reporte.ingresos.datos.locales')
            </div>
            <div  id="i_0_5" style="display: none">
                @include('admin.reporte.ingresos.datos.resumen')
            </div>
        </div>
        <style>
            .loader_two {
            border: 20px solid #f3f3f3;
            border-radius: 80%;
            border-top: 16px solid blue;
            border-right: 16px solid green;
            border-bottom: 16px solid red;
            border-left: 16px solid pink;
            width: 450px;
            height: 450px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
            position: relative;
            }
            @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
            }
            @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
            }
            </style>
        <div class="col-12" id="loader_seccion" style="display: none">
            <div class="form-row col-12">
                <div class="col-4"></div>
                <div class="col-4"><div class="loader_two"></div></div>
                <div class="col-4"></div>
            </div>
                
        </div>

    </div>
</div>
