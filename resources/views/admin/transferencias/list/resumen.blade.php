<div class="card shadow  col-4">
    <div class="card-header">
        <x-cabecera>
            <x-slot name='title'>
                Resumen
            </x-slot>
            <x-slot name='subtitle'>
            </x-slot>
        </x-cabecera>
    </div>
    <div class="card-body">
        <div class="form-row">
            <div  class="col-12">
                <table class="table table-striped" id="tablaResumen">
                    <tbody>
                        <tr>
                            <th>Criterio</th>
                            <th>Importe Total</th>
                            <th>Total Comision</th>
                        </tr>
                    </tbody>
                    <tbody>
                        <tr>
                            <th>Servicios</th>
                            <th id="importe_servi">0</th>
                            <th id="comision_servi">0</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>