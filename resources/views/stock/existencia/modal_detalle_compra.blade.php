<div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header" style="background: #4e73df; color: white;">
            <h5 class="modal-title">Detalles de la compra</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background: red; border: solid red;">
                <span style="color: white;" aria-hidden="true" id="close_modal_2">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">

                <div class="col-md-2">
                    @if(( $compra->es_factura ))
                        <span><p>Factura: <b>{{ $compra->comprobante }}</b></p></span>
                    @else
                        <span><p>Boleta: <b>{{ $compra->comprobante }}</b></p></span>
                    @endif
                </div>
                <div class="col-md-2">
                    <span><p>Fecha: <b>{{ $compra->fecha }}</b></p></span>
                </div>
                <div class="col-md-2">
                    <span><p>RUC: <b>{{ $persona->ruc }}</b></p></span>
                </div>
                <div>
                    <span><p>Razón: <b>{{ $persona->name }}</b></p></span>
                </div>
            </div>
            <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Artículo</th>
                        <th scope="col">Precio Unitario</th>
                        <th scope="col">Excenta</th>
                        <th scope="col">Gravada 5%</th>
                        <th scope="col">Gravada 10%</th>
                        <th scope="col">Precio Total</th>
                    </tr>
                    </thead>
                    @if(count($detalles) > 0)
                        <tbody>
                            @php
                                $total = 0;
                            @endphp
                            @foreach ($detalles as $det)
                                @php
                                    $total = $total + $det->total;
                                @endphp
                                <tr>
                                    <td>{{ number_format($det->cantidad, 0, '', '.') }}</td>
                                    <td>{{ $det->name }}</td>
                                    <td style="text-align: right">{{ number_format($det->unitario, 0, '', '.') }}</td>
                                    <td style="text-align: right">{{ number_format($det->excentas, 0, '', '.') }}</td>
                                    <td style="text-align: right">{{ number_format($det->gravadas_5, 0, '', '.') }}</td>
                                    <td style="text-align: right">{{ number_format($det->gravadas_10, 0, '', '.') }}</td>
                                    <td style="text-align: right">{{ number_format($det->total, 0, '', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th scope="col"  style="text-align: right" colspan="7">Total</th>
                                <th scope="col" style="text-align: right">{{ number_format($total, 0, '', '.') }}</th>
                            </tr>
                        </tfoot>
                    @endif
                </table>
        </div>
        <div class="modal-footer" style="border-top: none;">
            <button type="button" class="btn btn-primary" id="close_modal" data-dismiss="modal">Aceptar</button>
        </div>
    </div>
</div>
