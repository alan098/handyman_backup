<table>
    <thead>
        <tr>
            <td>Desde</td>
            <td>Hasta</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{$fe['desde']}}</td>
            <td>{{$fe['hasta']}}</td>
        </tr>
    </tbody>
</table>
<table>
    <thead>
        <tr>
           <th>Sucursal</th>
           <th>Importe Bruto</th>
           <th>Importe</th> 
        </tr>
    </thead>
    <tbody>
        @foreach ($datos as $invoice)
            <tr>
                <td>{{$invoice->name}}</td>
                <td>{{$invoice->detalles->importe}}</td>
                <td>{{$invoice->detalles->total}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

