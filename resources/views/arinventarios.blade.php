<table>
    <thead>
    <tr>
        <th>codigo(No Modificar)</th>
        <th>articulo</th>
        <th>cantidad</th>
    </tr>
    </thead>
    <tbody>
    @foreach($invoices as $invoice)
        <tr>
            <td>{{ $invoice->id }}</td>
            <td>{{ $invoice->name }}</td>
            <td>1</td>
        </tr>
    @endforeach
    </tbody>
</table>