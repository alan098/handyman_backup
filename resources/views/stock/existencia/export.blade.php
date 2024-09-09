<table>
    <thead>
    <tr>
        <th>codigo</th>
        <th>articulo</th>
        <th>Sucursal</th>
        <th>Deposito</th>
        <th>Cantidad</th>
    </tr>
    </thead>
    <tbody>
    @foreach($invoices as $invoice)
        <tr>
            <td>{{ $invoice->ar_id }}</td>
            <td>{{ $invoice->ar_name }}</td>
            <td>{{ $invoice->su_name }}</td>
            <td>{{ $invoice->de_name }}</td>
            <td>{{ $invoice->cantidad }}</td>
        </tr>
    @endforeach
    </tbody>
</table>