@extends('adminlte::page')
@section('title', 'Comisiones')
@section('content_header')
@stop
@section('content')
    <div>
        <div class="card">
            <div class="card-header">
                <h4 class="float-left">Cuentas Por Afiliados</h4>
                <a href="{{ route('admin.pagos.comisiones.comprobante') }}" class="btn btn-primary ml-5">Comprobantes</a>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover" id="tablaCrud" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Afiliados</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($colaboradores as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <button
                                        onclick="getComprobantes('{{ route('admin.pagos.comisiones.colaboradores.afiliado', ['colaborador_id' => $item->id]) }}', {{ $item->id }} )"
                                        class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top"
                                        title="Editar">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="comprobantesProveedor" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('admin.pagos.comisiones.nuevo') }}" method="POST">
                @csrf
                <input type="hidden" name="pid" id="pid">
                <input type="hidden" id="tipo_persona" name="tipo_persona" value="afiliado">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="form-row col-12">
                            <div class="col">
                                    <div class="form-row">
                                        <div class="col"> 
                                            <b><h5 class="modal-title" id="comprobantesProveedorTitle"></h5></b> 
                                        </div>
                                    </div>
                                    <div class="form-row mt-1">
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" onclick="marcarTodos(this)" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">Marcar Todos / Desmarcar Todos</label>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Generar Orden de pago</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" id="tablaComprobantes">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Fecha</th>
                                        <th>Servicio</th>
                                        <th>Porcentaje</th>
                                        <th>Importe</th>
                                        <th>Comision</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <th colspan="4">Totales</th>
                                    <th class="text-right" id="totalGeneral"></th>
                                    <th class="text-right" id="totalSaldo"></th>
                                    <th class="text-center">&nbsp;</th>
                                </tfoot>
                            </table>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                <table class="table" id="detalles_deudas">
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                       
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal -->
    @include('admin.pagos_comisiones.comunes')
@stop
@section('js')
    <script src=" {{ asset('js/comunes.js') }} "></script>
    <script>
        $(document).ready(function() {
            $('#tablaCrud').DataTable();
            $('#marcartodo').on('change', function() {
                if ($(this).prop('checked')) {
                    $(".check").prop("checked", true);
                } else {
                    $(".check").prop("checked", false);
                }
            });
        });
        var urlmodal = "{{ url('admin/pagos/comisiones/data') }}" + '?colaborador_id=';
        var dataModal = {
            table: "detalles_deudas",
            ajax: urlmodal,
            topMsg: "",
            footerMsg: "Generado: {{ auth()->user()->name }} {{ date('d/m/Y H:i') }}",
            filename: "Cuentas Pendientes",
            title: 'Cuentas Pendientes',
            columns: [
                {data: 'id',name: 'id',title: 'Id'},
                {data: 'fecha',name: 'fecha',title: 'Fecha'},
                {data: 'ar_name',name: 'ar_name',title: 'Servicio'},
                {data: 'porcentaje',name: 'porcentaje',title: 'Porcentaje',class: 'dt-center'},
                {data: 'precio_total',name: 'precio_total',title: 'Importe',class: 'dt-center'},
                {data: 'comision',name: 'comision',title: 'Comision',class: 'dt-center'},
                {data: 'acciones',name: 'acciones',title: 'Acciones',orderable: false,searchable: false,class: 'noexport dt-center'}
            ]
        };
        toDataTableSimple(dataModal);

        function marcarTodos(che){
            if ($(che).prop('checked')) {
                var urldetall = "{{ url('admin/pagos/comisiones/data/afiliados') }}" + '?colaborador_id='+$('#pid').val();
                getData(urldetall).then(function(rta) {
                        if (rta['data'].length > 0) {
                            $.each(rta['data'], function(i, item) {
                                var ele = {};
                                ele.id = item['id']; //este id es referente a la venta detalle id
                                ele.fecha = item['fecha'];
                                ele.total = item['precio_total'];
                                ele.ar_name = item['ar_name'];
                                ele.porcenta_socio = item['porcenta_socio'];
                                ele.comision = item['comision'];
                                $('#tablaComprobantes tbody').append([ele].map(ItemDeudas).join(''));
                                sumarDetalles();
                            })
                            $('#detalles_deudas tbody tr').each(function(e,data) {
                                $(this).find(".insertar").prop('checked',true)
                            })
                        }
                    }); 
            }else{
                //removemos todo
                $('#tablaComprobantes tbody tr').remove();
                $('#totalGeneral').text(0);
                $('#totalSaldo').text(0);
            }

        }
        function toDataTableSimple(data) {
            $('#' + data.table).DataTable({
                order: [
                    [0, "desc"]
                ],
                responsive: true,
                autoWidth: false,
                ajax: data.ajax,
                columns: data.columns,
                language: espanis_data,
                pageLength: 80,
                dom: 'Bfrtip',
                buttons: [],
                initComplete: function() {},
                drawCallback: function(settings) {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });
        }

        function getComprobantes(ruta, proveedor) {
            var table = $('#detalles_deudas').DataTable();
            table.ajax.url(ruta).load();
            var titulo = 'Pagos pendientes';
            $('#pid').val(proveedor);
            $('#comprobantesProveedorTitle').html(titulo);
            $('#tablaComprobantes tbody tr').remove();
            $('#totalGeneral').text(0);
            $('#totalSaldo').text(0);
            $('#comprobantesProveedor').modal('show');
        }

        function insertarOrdenes(algo,id, ruta) {
            if ($(algo).prop('checked')) {
            if (!$("#tr_detalle_" + id).length) {
                    getData(ruta).then(function(rta) {
                        console.log(rta);
                        var ele = {};
                        ele.id = rta.id; //este id es referente a la venta detalle id
                        ele.fecha = rta.fecha;
                        ele.total = rta.precio_total;
                        ele.ar_name = rta.ar_name;
                        ele.porcenta_socio = rta.porcenta_socio;
                        ele.comision = rta.comision;
                        $('#tablaComprobantes tbody').append([ele].map(ItemDeudas).join(''));
                        sumarDetalles();
                    });
                    alertaTipo('Proveedor Agregado', 'success')
                } else {
                    alertaTipo('El Proveedor ya Existe en la Lista', 'warning')
                }
            }else{
                //quitamos
                quitar(id);
            }
        }
        
        const ItemDeudas = ({
            id,
            fecha,
            ar_name,
            comision,
            total,
            porcenta_socio
        }) => `
            '<tr id="tr_detalle_${id}">';
            '<td>${id}</td>';
            '<td>${fecha}</td>';
            '<td>${ar_name}</td>';
            '<td align="right" class="porcentaje">${comision}</td>';
            '<td align="right" class="total" >${total}</td>';
            '<td align="right" class="comision">${comision}</td>';
            '<td>
            <input  type="hidden" name="comprobantes[]" id="comprobante_${id}" value="${id}">
            </td>';
            '</tr>';
            `;

        function sumarDetalles() {
            var total = 0;
            var saldo = 0;
            $('#tablaComprobantes tbody tr').each(function(e, data) {
                total = total + parseInt($(this).find(".total").text());
                saldo = saldo + parseInt($(this).find(".comision").text());
            })
            $('#totalGeneral').text(total);
            $('#totalSaldo').text(saldo);
        }

        function quitar(id) {
            $('#tr_detalle_' + id).remove();
            alertaTipo('Removido', 'success')
            sumarDetalles();
        }

        function alertaTipo(messa, tipo) {
            toastr.options = {
                "closeButton": true,
                "positionClass": "toast-top-right",
                "showDuration": "1500",
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "preventDuplicates": false,
                "onclick": null,
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            if (tipo == "error") {
                toastr.error('', messa);
            } else if (tipo == "warning") {
                toastr.warning('', messa);
            } else if (tipo == "info") {
                toastr.info('', messa);
            } else if (tipo == 'success') {
                toastr.success('', messa);
            }
        }
    </script>
@stop
