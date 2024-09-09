<table>
    <thead>
    <tr>
           <th> fecha</th>
           <th> Mes</th>
           <th> Local</th>
           <th> Fac</th> 
           <th> Prof</th>
           <th> Cliente</th>
           <th> Servicio</th>
           <th> Importe Bruto</th>
           <th> Producto Bruto</th>
           <th> Servicio Bruto</th>
           <th> Decuento X servicio</th> 
           <th> Total</th>
           <th> Tot ser.</th>
           <th> Tot pro.</th>
           <th> %</th> 
           <th> Comision Bruta</th>
           <th> Comision </th>
    </tr>
    </thead>
    <tbody>
    @foreach($datos as $invoice)
        <tr>
           <td>{{$invoice->fecha}}</td> 
           <td>{{$invoice->mes}}</td> 
           <td>{{$invoice->sucursal}}</td> 
           <td>{{$invoice->num_fac}}</td> 
           <td>{{$invoice->prof}}</td> 
           <td>{{$invoice->cli_ser}}</td> 
           <td>{{$invoice->ar_name}}</td> 
           <td>{{$invoice->imp_bru}}</td>
           <td>{{$invoice->mon_pro_bru}}</td>
           <td>{{$invoice->mon_ser_bru}}</td>
           <td>{{$invoice->des_impor}}</td> 
           <td>{{$invoice->imp_real}}</td> 
           <td>{{$invoice->mon_pro}}</td> 
           <td>{{$invoice->mon_ser}}</td> 
           <td>{{$invoice->porc}}</td>
           <td>{{$invoice->comi_bruta}}</td>
           <td>{{$invoice->comi_rea}}</td>    
        </tr>
    @endforeach
    </tbody>
</table>

                