
    <div class="botonera">
        <div style="float: left;">
            <a href="#" class="btn btn-primary btn-icon-split botones" onclick='imprimir()'>
                    <span class="icon text-white-50">
                      <i class="fas fa-print"></i>
                    </span>
            </a>
           
        </div>

<!--        --><?php //$dp_id; ?>

        <div style="float: right; width: 540px;">
            <div class="row">

                <div class="form-group col-4" style="">
                    <label style="margin-bottom: 0;">Filtrar por Entidad</label>
                    <select  name="entidad_id" id="entidad_id" class="mr-3 form-control form-control-sm col-12">
                        <option value="0" selected="">Todos</option>
                        @foreach($depositos as $d)
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-4" style="">
                    <label style="margin-bottom: 0;">Filtrar por Sucursal</label>
                    <select  name="sucursal_id" id="sucursal_id" class="mr-3 form-control form-control-sm col-12">
                        <option value="0" selected="">Todos</option>
                        @foreach($depositos as $d)
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-4" style="">
                    <label style="margin-bottom: 0;">Filtrar por depósito</label>
                    <select  name="deposito_id" id="deposito_id" class="mr-3 form-control form-control-sm col-12">
                        <option value="0" selected="">Todos</option>
                        @foreach($depositos as $d)
                            @if(!empty($deposito_id))
                                @if($deposito_id == $d->id)
                                    <option selected value="{{ $d->id }}">{{ $d->name }}</option>
                                @else
                                    <option value="{{ $d->id }}">{{ $d->name }}</option>
                                @endif
                            @else
                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endif

                        @endforeach
                    </select>
                </div>
                <div class="form-group col-4" style="">
                    <label style="margin-bottom: 0;">&nbsp;</label>
                    <div class="input-group col-12" style="">
                        <input type="text" id="buscar_articulos" value="{{ !empty($busqueda) ? $busqueda : '' }}"
                               class="form-control" name="buscar_articulos" placeholder="Buscar artículos">
                        <div class="input-group-append">
                            <button class="btn btn-primary" onclick="buscarArticulos();">
                                <i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <table class="table dataTable tablaExistencia table-striped table-bordered">
            <thead>
            <tr>
                <th scope="col">Código Artículo</th>
                <th scope="col">Nombre</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Depósito</th>
{{--                <th scope="col">Estante</th>--}}
            </tr>
            </thead>
            <tbody id="cuerpoExistencia">
            @foreach($existencia as $e)
                <tr>
                    <td>{{ $e->cod_articulo  }}</td>
                    <td>{{ $e->name  }}</td>
                    <td>{{ intval($e->cantidad) }}</td>
                    <td>{{ $e->deposito  }}</td>
{{--                    <td>{{ $e->estante  }}</td>--}}
                </tr>
            @endforeach
            </tbody>
        </table>

    <div id="paginado_normal" style="margin-top: 20px;">
        {!! $existencia->links() !!}
    </div>

    <div id="export_div" style="visibility:hidden; height:0;"></div>

<script type="text/javascript" >


    function imprimir(){
        $.ajax({
            type:"POST",
            url: "{{route('stock.existencia.reporte')}}",
            data: { _token: "{{ csrf_token() }}" },
            success: function(data){
                $("#export_div").empty();
                $('#export_div').html(data);
                printDiv('export_div');
                $("#export_div").empty();
            }
        });
    }

    function exportarExcel(){
        $.ajax({
            type:"POST",
            url: "{{route('stock.existencia.reporte')}}",
            data: { _token: "{{ csrf_token() }}" },
            success: function(data){
                $("#export_div").empty();
                $('#export_div').html(data);
                exportTableToExcel('export_div', 'Control de artículos en existencia');
                $("#export_div").empty();
            }
        });
    }


    function exportarPDF(){
        $.ajax({
            type:"POST",
            url: "{{route('stock.existencia.reporte')}}",
            data: { _token: "{{ csrf_token() }}" },
            success: function(data){
                $("#export_div").empty();
                $('#export_div').html(data);
                exportPDF('#export_div' ,'Control de artículos en existencia');
                $("#export_div").empty();
            }
        });
    }

</script>
