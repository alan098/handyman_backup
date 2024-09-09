@if(count($existencia)>0)
    <br>
    <h2>Control de artículos en existencia</h2>
{{--    <p>Agrupado por productos</p>--}}
{{--    <p>Desde: {{ date('d/m/Y', strtotime($desde)) }} <br>Hasta: {{ date('d/m/Y', strtotime($hasta)) }}</p>--}}
    <table class="table dataTable tablaExistencia" style="padding-top: 20px;">
        <thead>
        <tr>
            <th scope="col">Código Artículo</th>
            <th scope="col">Nombre</th>
            <th scope="col">Cantidad</th>
            <th scope="col">Depósito</th>
{{--            <th scope="col">Estante</th>--}}
        </tr>
        </thead>
        <tbody id="cuerpoExistencia">
        @foreach($existencia as $e)
            <tr>
                <td>{{ $e->cod_articulo  }}</td>
                <td>{{ $e->name  }}</td>
                <td>{{ intval($e->cantidad) }}</td>
                <td>{{ $e->deposito  }}</td>
{{--                <td>{{ $e->estante  }}</td>--}}
            </tr>
        @endforeach
        </tbody>
    </table>
    <br>
    <p>Informe generado por: {{ auth()->user()->name }} </p>
    <p>Fecha y hora: {{ date("d/m/Y G:i") }}</p>
@endif
