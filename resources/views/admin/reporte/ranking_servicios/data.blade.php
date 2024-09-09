<div class="card">
    <!-- Ranquin de servicios-->
    <div class="card-body">
        <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-datos-tab" data-toggle="pill" href="#pills-ingresosg" role="tab"
                    aria-controls="pills-datos" aria-selected="true">
                    <h3>Totalidad de Servicios</h3>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-productos-tab" data-toggle="pill" href="#pills-ingresosi" role="tab"
                    aria-controls="pills-productos" aria-selected="false">
                    <h3>Grafica</h3>
                </a>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-ingresosg" role="tabpanel"
                aria-labelledby="pills-datos-tab">
                <div class="form-row">
                    <div class="col-12 border">
                        <table class="table" id="example">
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade " id="pills-ingresosi" role="tabpanel" aria-labelledby="pills-productos-tab">
                <div class="form-row">
                    <div class="col-12 border">
                        <div class="chart">
                            <canvas id="chartRanking"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
