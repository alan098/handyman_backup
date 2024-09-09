
@extends('adminlte::page')

{{-- @dd($gastos) --}}

@section('content')
    <div class="">
        <div class="card shadow mb-1" style="margin: 20px 0px 0px 0px;">
            <div class="card-body" style="padding: 0;">
                <div class="col-sm-12" style="padding: 10px 0; overflow: hidden;">

                    <div class="col-md-3 col-sm-3" style="float: left;">
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Desde</span>
                            </div>
                            <input type="date" class="form-control" aria-label="Desde" aria-describedby="basic-addon1" value="<?php echo date("Y-m-01")?>" id="desde">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3" style="float: left;">
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Hasta</span>
                            </div>
                            <input type="date" class="form-control" aria-label="Hasta" aria-describedby="basic-addon1" value="<?php echo date("Y-m-d")?>" id="hasta">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3" style="float: left;">
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Clientes</span>
                            </div>
                            <select name="cliente_id" id="cliente_id" class="mr-3 form-control form-control-sm col-12 select2">
                                <option value=""> Seleccione un cliente</option>
                                @foreach ($clientes as $item)
                                    <option value="{{$item->id}}">{{$item->name}} - {{$item->ruc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-1" style="float: left;">
                        <a href="javascript:void(0);" class="btn btn-success btn-icon-split" style="font-size: 0.64rem;" onclick="filtrar();">
                            <span class="icon text-white-50">
                              <i class="fas fa-check"></i>
                            </span>
                            <span class="text">Filtrar</span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
        <hr>
        <div class="card shadow mb-3 col-12 responsive">
            <div class="card-body">
                <table class="display responsive nowrap" id="tablaListado" style="width:100%">
                    <thead>
                        <tr>
                            <th>Fecha Compra</th>
                            <th>Cliente</th>
                            <th>Monto Abonado</th>
                            <th>Saldo restante</th>
                            <th>Veneficiario</th>
                            <th>Numero o Detalle gifcard</th>
                            <th width='120px'>  </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script src=" {{ asset('js/comunes.js') }} "></script>
    <script>
$(document).ready(function() {
    var _url = "{{ route('admin.giftcard.datatable') }}" + '?cliente_id='+$('#cliente_id').val()+'&desde='+$('#desde').val()+'&hasta='+$('#hasta').val();
    var data = {
        table: "tablaListado",
        ajax : _url,
        topMsg: "",
        filename: "Listado",
        title: 'Listado',
        columns: [
            {data: 'fecha', name: 'fecha', title: 'Fecha de compra',class: 'noexport dt-center'},
            {data: 'cliente.persona.name', name: 'Nombre', title: 'Cliente',class: 'noexport dt-center'},
            {data: 'importe', name: 'importe', title: 'Monto Abonado',class: 'noexport dt-center'},
            {data: 'saldo', name: 'Saldo', title: 'Saldo restante',class: 'noexport dt-center'},
            {data: 'name', name: 'name', title: 'Veneficiario',class: 'noexport dt-center'},
            {data: 'numero_gifcard', name: 'numero_gifcard', title: 'Numero o detalles',class: 'noexport dt-center'},
            {data: 'acciones', name: 'acciones',title:"Acciones", orderable: false, searchable: false, class: 'noexport dt-center'}
        ]
    };
    toDataTableSimple(data);
});
function filtrar(){
    var _url = "{{ route('admin.giftcard.datatable') }}" + '?cliente_id='+$('#cliente_id').val()+'&desde='+$('#desde').val()+'&hasta='+$('#hasta').val();
    var table = $('#tablaListado').DataTable();
    table.ajax.url(_url).load();
}
var buttons_data = {
messageTop: 'Gastos registrados',
messageBottom: 'Francisco Noceda',
filename: 'gastos',
title: 'Gastos',
table: 'tablaListado',
newUrl: '{{ route('admin.giftcard.create') }}',
};
function toDataTableSimple(data) {
        $('#' + data.table).DataTable({
        order: [[0, "desc"]],
        autoWidth: false,
        paging: false,
        ajax: data.ajax,
        columns: data.columns,
        language: espanis_data,
        searching: false,
        dom: 'Bfrtip',
        buttons: getButtons(buttons_data),
        drawCallback: function( settings ) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
}

function getButtons(data) {
    var buttons = [{
        extend: 'pageLength',

    },
    {
        extend: 'copy',
        text: '<i class="fas fa-file-alt"></i>',
        titleAttr: 'Copiar a Porta Papeles',
        exportOptions: {
            columns: 'th:not(.notexport)'
        }
    },
    {
        extend: 'print',
        text: '<i class="fas fa-print"></i>',
        titleAttr: 'Imprimir',
        exportOptions: {
            columns: 'th:not(.notexport)'
        }
    },
    {
        extend: 'excel',
        text: '<i class="fas fa-file-excel"></i>',
        messageTop: data.topMsg,
        messageBottom: data.footerMsg,
        filename: data.filename,
        title: data.title,
        titleAttr: 'Descargar en Excel',
        exportOptions: {
            columns: 'th:not(.notexport)'
        }
    },
    {
        extend: 'pdf',
        text: '<i class="fas fa-file-pdf"></i>',
        messageTop: data.topMsg,
        messageBottom: '\n' + data.footerMsg,
        filename: data.filename,
        title: data.title,
        titleAttr: 'Descargar en PDF',
        exportOptions: {
            columns: 'th:not(.notexport)'
        },
        customize: function (doc) {
            var colCount = new Array();
            $('#' + data.table).find('tbody tr:first-child td').each(function () {
                if ($(this).attr('colspan')) {
                    for (var i = 1; i <= $(this).attr('colspan'); $i++) {
                        colCount.push('*');
                    }
                } else {
                    colCount.push('*');
                }
            });
            doc.content[1].table.widths = colCount;
        }
    },
    {
        text: 'Nuevo',
        titleAttr: 'Agregar uno Nuevo',
        action: function (e, dt, node, config) {
            window.location.href = data.newUrl;
        }
    },
    ];
    return buttons;
    }
    function eliminame(ruta){
    console.log(ruta);
    const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger'
    },
    buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
    title: 'No podras revertir esta accion!',
    text: "Estas seguro de eliminar el Gifcard la venta sera anulada?",
    html: "",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Si, borrarlo ya!',
    cancelButtonText: 'No, Cancelar!',
    reverseButtons: true
    }).then((result) => {
    if (result.isConfirmed) {
        var formData = new FormData();
        formData.append( '_token', '{{ csrf_token() }}');
        postData(ruta, formData).then(function(rta){
            alertaTipo('Eliminado con exito','success')
            filtrar()
        }).catch(function(error){
            console.log('populate dio error'); console.log(error);
            Swal.fire('Ocurrio un Error', error.message, 'error');
        });
     }
    });

}

    </script>
@stop



