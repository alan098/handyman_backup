
<div class="botonera">
    <div style="float: left; padding: 10px 0px 10px 0px;">
    </div>

    <div style="float: right; width: 300px; padding: 10px 0px 10px 0px;">
        <div class="row">
            <div class="input-group col-12" style="">
                <input type="text" id="buscar" value="{{ !empty($buscar) ? $buscar : '' }}" class="form-control" name="buscar" placeholder="Buscar...">
                <div class="input-group-append">
                    <button class="btn btn-primary" onclick="buscarPersona();"><i class="fa fa-search"></i></button>
                </div>
            </div>

        </div>

    </div>
</div>

<table class="table dataTable tablaExistencia table-striped table-bordered" id="clientesTable">
    <thead>
    <tr>
        <th scope="col">Nombre</th>
        <th scope="col">Cantidad de Visitas</th>
        <th scope="col">Monto Gastado</th>
        <th scope="col">Descuentos que se le brindo</th>
    </tr>
    </thead>
    <tbody id="cuerpoExistencia">
    @foreach($clientes as $p)
        <tr>
            <td>{{ $p->name}}</td>
            <td>{{ $p->data->cantidad_visitas}}</td>
            {{-- <td>{{ $p->data->importe}}</td> --}}
            <td>{{ $p->data->total }}</td>
            <td>{{ $p->data->descuento }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<div id="paginado_normal" style="margin-top: 20px;">
    {!! $clientes->links('pagination::bootstrap-4') !!}
</div>

