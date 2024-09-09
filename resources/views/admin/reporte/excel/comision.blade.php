<table>
    <thead>
        <tr>
            <th> Mes</th>
            <th> Importe Bruto</th>
            <th> Importe</th>   
        </tr>
    </thead>
    <tbody>
        @foreach ($datos as $invoice)
            <tr>
                <td>{{ $invoice['mes'] }}</td>
                <td>{{ $invoice['bruto'] }}</td>
                <td>{{ $invoice['real'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th> Colaborador</th>
            <th> Importe Bruto</th>
            <th> Importe Real</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datosDos as $invoice)
            <tr>
                <td>{{ $invoice->name }}</td>
                <td>{{ $invoice->bruto }}</td>
                <td>{{ $invoice->real }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
