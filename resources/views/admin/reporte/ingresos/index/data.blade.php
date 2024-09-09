<ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="pills-datos-tab" data-toggle="pill" href="#pills-ingresosg" role="tab"
            aria-controls="pills-datos" aria-selected="true">
            <h3>Ingresos por ventas</h3>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="pills-productos-tab" data-toggle="pill" href="#pills-ingresosi"
            role="tab" aria-controls="pills-productos" aria-selected="false">
            <h3>Ingresos por Servicio</h3>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="pills-productos-tab" data-toggle="pill" href="#pills-comisiones"
            role="tab" aria-controls="pills-productos" aria-selected="false">
            <h3>Comisiones</h3>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="pills-productos-tab" data-toggle="pill" href="#pills-locales"
            role="tab" aria-controls="pills-productos" aria-selected="false">
            <h3>Locales</h3>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="pills-productos-tab" data-toggle="pill" href="#pills-resumen"
            role="tab" aria-controls="pills-productos" aria-selected="false">
            <h3>Resumen Ingresos</h3>
        </a>
    </li>
</ul>
<style>
    table.dataTable thead tr {
    background-color: #FFF2CC;
    }
</style>
<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-ingresosg" role="tabpanel" aria-labelledby="pills-datos-tab">
        @include('admin.reporte.ingresos.datos.ingresos_a')
    </div>
    <div class="tab-pane fade " id="pills-ingresosi" role="tabpanel"
        aria-labelledby="pills-productos-tab">
        @include('admin.reporte.ingresos.datos.ingresos_i')
    </div>
    <div class="tab-pane fade " id="pills-comisiones" role="tabpanel"
        aria-labelledby="pills-productos-tab">
        @include('admin.reporte.ingresos.datos.comisiones')
    </div>
    <div class="tab-pane fade " id="pills-locales" role="tabpanel"
        aria-labelledby="pills-productos-tab">
        @include('admin.reporte.ingresos.datos.locales')
    </div>
    <div class="tab-pane fade " id="pills-resumen" role="tabpanel"
        aria-labelledby="pills-productos-tab">
        @include('admin.reporte.ingresos.datos.resumen')
    </div>
</div>
