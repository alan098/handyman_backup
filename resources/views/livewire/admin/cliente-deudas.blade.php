<div wire:init="LoatDetalles">
    <div class="card shadow mb-3 col-md-12">
        <div class="card-body"> 
            <div class="form-row">
                <div class="col-4">
                   paquetes o vouchers
                   <table class="table table-striped">
                    <tr>
                        <td>Paquetes</td>
                        <td>Filtar</td>
                    </tr>
                    <tr>
                        <td>Vouchers</td>
                        <td>Filtar</td>
                    </tr>
                </table>
                </div>
                <div class="col-4">
                    Pagos adelantados
                    <table class="table table-striped">
                        <tr>
                            <td>Anticipos</td>
                            <td>.</td>
                        </tr>
                        <tr>
                            <td>Gift CArd</td>
                            <td>0</td>
                        </tr>
                    </table>
                </div>
                <div class="col-4">
                    @if (count($ventasR))
                    
                    Resumen cuentas
                    <table class="table table-striped">
                        <tr>
                            <td>Total Cuenta</td>
                        
                            <td>{{$ventasR[0]->total}}</td>
                        </tr>
                        <tr>
                            <td>Anticipos</td>
                            <td>.</td>
                        </tr>
                        <tr>
                            <td>Gift Cards</td>
                            <td>.</td>
                        </tr>
                        <tr>
                            <td>A pagar</td>
                            <td>{{$ventasR[0]->total}}</td>
                        </tr>
                    </table> 
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
