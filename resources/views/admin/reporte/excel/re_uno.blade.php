<table>
    <style>
        th {
            background: black
        }
    </style>
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Mes</th>
            <th>Local</th>
            <th>Fac Num</th>
            <th>Cliente</th>
            <th>Cliente Factura</th>
            <th>Importe</th>
            <th>Decuento</th>
            <th>Total</th>
            <th>Iva</th>
            <th>Medio Pgo</th>
            <th>Importe</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datos as $invoice)
            <tr>
                <td>{{ $invoice->fecha }}</td>
                <td>{{ $invoice->mes }}</td>
                <td>{{ $invoice->sucursal }}</td>
                <td>{{ $invoice->num_fac }}</td>
                <td>{{ $invoice->cli_ser }}</td>
                <td>{{ $invoice->cli_fac }}</td>
                <td>{{ $invoice->imp_bru }}</td>
                <td>{{ $invoice->des_impor }}</td>
                <td>{{ $invoice->imp_real }}</td>
                <td>{{ $invoice->iva }}</td>
                <td>
                    @foreach ($invoice->cobroDetalles as $medio)
                        <p>
                            {{$medio->medios->name}}
                        </p>
                    @endforeach
                </td>
                <td>
                    @foreach ($invoice->cobroDetalles as $medio)
                        <p>
                            {{$medio->importe}}
                        </p>
                    @endforeach
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
