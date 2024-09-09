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
                                    <th>Profesional</th>
                                    <th>Monto Facturado</th>
                                    <th>Monto Comision Profesional</th>
                                    {{-- <th>Monto Comision Como Afiliado</th> --}}
                                    <th>Cantidad de Clientes Atendidas</th>
                                    <th>Cantidad de Clientes Repetidas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td id="p_name"></td>
                                    <td id="p_factu"></td>
                                    <td id="p_comi_p"></td>
                                    {{-- <td id="p_comi_a"></td> --}}
                                    <td id="p_cant_aten"></td>
                                    <td id="p_cant_rep"></td>
                                </tr>
                                <tr class="bg-cyan">
                                    <th colspan="2">Datos Extra</th>
                                    <th colspan="4" style="text-align: center">Top Servicios</th>
                                </tr> 
                                <tr>
                                    <td colspan="2">
                                        <div class="form-row">
                                            <div class="col-12">
                                                <table class="table col-12">
                                                    <tr>
                                                        <th class="bg-cyan">Numero Telefono:</th>
                                                        <td id="nun_tel"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="bg-cyan">Correo:</th>
                                                        <td id="correo"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="bg-cyan">Fecha de cumpleaños:</th>
                                                        <td id="cump"></td>
                                                    </tr>
                                                    {{-- <tr>
                                                        <th class="bg-cyan">Fecha de primer servicio:</th>
                                                        <td id="primer"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="bg-cyan">Servicio Favorito:</th>
                                                        <td id="serv_fav"></td>
                                                    </tr> --}}
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                    <td colspan="4">
                                        <table class="table table-info" id="tablaListadoHistorial">
                                            <thead>
                                                <tr>
                                                    <th>Cantidad</th>
                                                    <th>Servicio</th>
                                                    <th>Top</th>
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
