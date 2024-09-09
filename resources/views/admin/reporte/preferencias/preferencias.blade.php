<table>
    <thead>
        <tr>
            <th>Numero de venta</th>
            <th>Fecha</th>
            <th>Nombre del Cliente(reserva)</th>
            <th>Era con Preferencia</th>
            <th>Servicios Realizados y Profecionales</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($invoices as $invoice)
            <tr>
                <td>{{ $invoice->numero_venta }}</td>
                <td>{{ $invoice->fecha }}</td>
                <td>{{ $invoice->cliente_reserva }}</td>
                @if ($invoice->sin_prefe)
                    <td>Con Preferencia</td>
                @else
                    <td>Sin Preferencia</td>
                @endif
                <td>
                    @if (isset($invoice->detalles[0]))
                        @foreach ($invoice->detalles as $item)
                           <p>{{$item->cantidad}}/{{$item->name}}/{{$item->profecional}}</p> 
                        @endforeach
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
