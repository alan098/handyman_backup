<div class="card">
    <!-- Ranquin de servicios-->
    <div class="card-body">
        <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-datos-tab" data-toggle="pill" href="#pills-ingresosg" role="tab"
                    aria-controls="pills-datos" aria-selected="true">
                    <h3>Historial</h3>
                </a>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-ingresosg" role="tabpanel"
                aria-labelledby="pills-datos-tab">
                <div class="form-row">
                    <div class="col-12 border">
                        <table class="table table-bordered">
                            <thead>
                                <tr class=" bg-cyan">
                                    <th>Cliente</th>
                                    <th>Monto Gastado</th>
                                    <th>Cantidad de Visitas</th>
                                    <th>Dias Sin Venir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td id="c_name"></td>
                                    <td id="c_gast"></td>
                                    <td id="c_cant"></td>
                                    <td id="c_dias"></td>
                                </tr>
                                <tr class="bg-cyan">
                                    <th colspan="1">Datos Extra</th>
                                    <th colspan="3" style="text-align: center">Ultimos Servicios</th>
                                </tr> 
                                <tr>
                                    <td>
                                        <div class="form-row">
                                            <div class="col-12">
                                                <table class="table col-12">
                                                    <tr>
                                                        <th class=" bg-cyan">Numero Telefono:</th>
                                                        <td id="nun_tel"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class=" bg-cyan">Correo:</th>
                                                        <td id="correo"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class=" bg-cyan">Fecha de cumpleaños:</th>
                                                        <td id="cump"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class=" bg-cyan">Fecha de primer servicio:</th>
                                                        <td id="primer"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class=" bg-cyan">Servicio Favorito:</th>
                                                        <td id="serv_fav"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class=" bg-cyan">Profesional favorito:</th>
                                                        <td id="pro_fav"></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                    <td colspan="3">
                                        <table class="table table-info" id="tablaListadoHistorial">
                                            <thead>
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Servicio</th>
                                                    <th>Colaborador</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
