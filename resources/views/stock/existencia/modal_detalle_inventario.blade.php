<div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header" style="background: #4e73df; color: white;">
            <h5 class="modal-title">Detalles del Inventario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background: red; border: solid red;">
                <span style="color: white;" aria-hidden="true" id="close_modal_2">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-4">
                    <span><p>Inventario: <b>{{ '#'.$inventario->id.' '.$inventario->name }}</b></p></span>
                </div>
                <div class="col-md-6">
                    <span><p>Ubicación: <b>{{ '['.$inventario->entidad.']  ['.$inventario->sucursal.'] ['.$inventario->deposito.']' }}</b></p></span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <span><p>Creado: <b>{{ $inventario->creado_por.' '.$inventario->created_at }}</b></p></span>
                </div>
                <div class="col-md-4">
                    <span><p>Confirmado: <b>{{ $inventario->confirmado_por.' '.$inventario->confirmado_at }}</b></p></span>
                </div>
            </div>
            <table class="table" id="table_inventario">
                <thead>
                    <tr>
                        <th scope="col">Artículo</th>
                        <th scope="col">Cantidad</th>
                    </tr>
                </thead>
                @if(count($detalles) > 0)
                <tbody>
                    @php
                        $total = 0;
                    @endphp
                    @foreach ($detalles as $det)
                        <tr>
                            <td>{{ $det->name }}</td>
                            <td>{{ number_format($det->cantidad, 0, '', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                @endif
            </table>
        </div>
        <div class="modal-footer" style="border-top: none;">
            <button type="button" class="btn btn-primary" id="close_modal" data-dismiss="modal">Aceptar</button>
        </div>
    </div>
</div>
<script>
    $( document ).ready(function() {
        $('#table_inventario').DataTable();
        $('search').focus();
    });
</script>
