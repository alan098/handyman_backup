<div class="card shadow  col-12">
    <div class="card-header">
        <x-cabecera>
            <x-slot name='title'>
                Cuentas
            </x-slot>
            <x-slot name='subtitle'>
            </x-slot>
        </x-cabecera>
    </div>
    <div class="card-body">
        <div class="form-row">
            <div  id="responsive_table" class="col-12">
                <table class="table" id="tablaListado">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Colaborador</th>
                            <th>Servicio</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th>Comision</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>