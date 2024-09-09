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
           <th>Mes</th>
           <th>Importe Bruto</th>
           <th>Importe</th> 
           <th>Comision</th> 
        </tr>
    </thead>
    <tbody>
        @foreach ($datos as $invoice)
            <tr>
                <td>{{$invoice->mes}}</td>
                <td>{{$invoice->importe}}</td>
                <td>{{$invoice->total}}</td>
                <td>{{$invoice->comi}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

