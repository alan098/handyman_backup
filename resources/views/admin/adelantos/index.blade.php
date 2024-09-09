
@extends('adminlte::page')

{{-- @dd($gastos) --}}


@section('content_header')
   <div class="mt-n1"><b>ADELANTOS</b></div>
@stop

@section('content')

    <div class=" container-fluid">
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
                    <div class="col-sm-1" style="float: left;">
                        <a href="javascript:void(0);" class="btn btn-success btn-icon-split" style="font-size: 0.64rem;" onclick="getListado();">
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
            getListado();;
        });

        var table;
        var buttons_data = {
            messageTop: ' registrados',
            messageBottom: 'Francisco Noceda',
            filename: '',
            title: '',
            table: 'tablaListado',
            newUrl: '{{ route('admin.adelantos.create') }}',
        };
        var espanis_data = {
            "processing": "Procesando...",
            "zeroRecords": "No se encontraron resultados",
            "emptyTable": "Ningún dato disponible en esta tabla",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "search": "Buscar:",
            "infoThousands": ",",
            "loadingRecords": "Cargando...",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "buttons": {
                "copy": "Copiar",
                "colvis": "Visibilidad",
                "collection": "Colección",
                "colvisRestore": "Restaurar visibilidad",
                "copyKeys": "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br \/> <br \/> Para cancelar, haga clic en este mensaje o presione escape.",
                "copySuccess": {
                    "1": "Copiada 1 fila al portapapeles",
                    "_": "Copiadas %d fila al portapapeles"
                },
                "copyTitle": "Copiar al portapapeles",
                "csv": "CSV",
                "excel": "Excel",
                "pageLength": {
                    "-1": "Mostrar todas las filas",
                    "1": "Mostrar 1 fila",
                    "_": "Mostrar %d filas"
                },
                "pdf": "PDF",
                "print": "Imprimir"
            },
            "autoFill": {
                "cancel": "Cancelar",
                "fill": "Rellene todas las celdas con <i>%d<\/i>",
                "fillHorizontal": "Rellenar celdas horizontalmente",
                "fillVertical": "Rellenar celdas verticalmentemente"
            },
            "decimal": ",",
            "searchBuilder": {
                "add": "Añadir condición",
                "button": {
                    "0": "Constructor de búsqueda",
                    "_": "Constructor de búsqueda (%d)"
                },
                "clearAll": "Borrar todo",
                "condition": "Condición",
                "conditions": {
                    "date": {
                        "after": "Despues",
                        "before": "Antes",
                        "between": "Entre",
                        "empty": "Vacío",
                        "equals": "Igual a",
                        "notBetween": "No entre",
                        "notEmpty": "No Vacio",
                        "not": "Diferente de"
                    },
                    "number": {
                        "between": "Entre",
                        "empty": "Vacio",
                        "equals": "Igual a",
                        "gt": "Mayor a",
                        "gte": "Mayor o igual a",
                        "lt": "Menor que",
                        "lte": "Menor o igual que",
                        "notBetween": "No entre",
                        "notEmpty": "No vacío",
                        "not": "Diferente de"
                    },
                    "string": {
                        "contains": "Contiene",
                        "empty": "Vacío",
                        "endsWith": "Termina en",
                        "equals": "Igual a",
                        "notEmpty": "No Vacio",
                        "startsWith": "Empieza con",
                        "not": "Diferente de"
                    },
                    "array": {
                        "not": "Diferente de",
                        "equals": "Igual",
                        "empty": "Vacío",
                        "contains": "Contiene",
                        "notEmpty": "No Vacío",
                        "without": "Sin"
                    }
                },
                "data": "Data",
                "deleteTitle": "Eliminar regla de filtrado",
                "leftTitle": "Criterios anulados",
                "logicAnd": "Y",
                "logicOr": "O",
                "rightTitle": "Criterios de sangría",
                "title": {
                    "0": "Constructor de búsqueda",
                    "_": "Constructor de búsqueda (%d)"
                },
                "value": "Valor"
            },
            "searchPanes": {
                "clearMessage": "Borrar todo",
                "collapse": {
                    "0": "Paneles de búsqueda",
                    "_": "Paneles de búsqueda (%d)"
                },
                "count": "{total}",
                "countFiltered": "{shown} ({total})",
                "emptyPanes": "Sin paneles de búsqueda",
                "loadMessage": "Cargando paneles de búsqueda",
                "title": "Filtros Activos - %d"
            },
            "select": {
                "1": "%d fila seleccionada",
                "_": "%d filas seleccionadas",
                "cells": {
                    "1": "1 celda seleccionada",
                    "_": "$d celdas seleccionadas"
                },
                "columns": {
                    "1": "1 columna seleccionada",
                    "_": "%d columnas seleccionadas"
                },
                "rows": {
                    "1": "1 fila seleccionada",
                    "_": "%d filas seleccionadas"
                }
            },
            "thousands": ".",
            "datetime": {
                "previous": "Anterior",
                "next": "Proximo",
                "hours": "Horas",
                "minutes": "Minutos",
                "seconds": "Segundos",
                "unknown": "-",
                "amPm": [
                    "am",
                    "pm"
                ]
            },
            "editor": {
                "close": "Cerrar",
                "create": {
                    "button": "Nuevo",
                    "title": "Crear Nuevo Registro",
                    "submit": "Crear"
                },
                "edit": {
                    "button": "Editar",
                    "title": "Editar Registro",
                    "submit": "Actualizar"
                },
                "remove": {
                    "button": "Eliminar",
                    "title": "Eliminar Registro",
                    "submit": "Eliminar",
                    "confirm": {
                        "_": "¿Está seguro que desea eliminar %d filas?",
                        "1": "¿Está seguro que desea eliminar 1 fila?"
                    }
                },
                "error": {
                    "system": "Ha ocurrido un error en el sistema (<a target=\"\\\" rel=\"\\ nofollow\" href=\"\\\">Más información&lt;\\\/a&gt;).<\/a>"
                },
                "multi": {
                    "title": "Múltiples Valores",
                    "info": "Los elementos seleccionados contienen diferentes valores para este registro. Para editar y establecer todos los elementos de este registro con el mismo valor, hacer click o tap aquí, de lo contrario conservarán sus valores individuales.",
                    "restore": "Deshacer Cambios",
                    "noMulti": "Este registro puede ser editado individualmente, pero no como parte de un grupo."
                }
            },
            "info": "Mostrando de _START_ a _END_ de _TOTAL_ entradas"
        };


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

        //funcion para los detalles
        function formatDetalles ( d ) {
            // console.log(d);
            var html = '<table class="display" style="width:100%">';
            html += '<thead><tr><th>&nbsp;</th><th>Cantidad</th><th>Concepto</th><th>Centro de Costo</th><th>Unitario</th><th>Importe</th></tr></thead>';
            html += '<tbody>';
            d.detalles.forEach(function(valor, indice, array){
                console.log(valor);
                let importe = Number(valor.gravadas_10) + Number(valor.gravadas_5) + Number(valor.excentas);
                html += '<tr>';
                    html += '<td>&nbsp;</td>';
                    html += '<td>'+valor.cantidad+'</td>';
                    html += '<td>'+valor.concepto+'</td>';
                    html += '<td>'+valor.centrocosto.name+'</td>';
                    html += '<td class="dt-right">'+valor.unitario+'</td>';
                    html += '<td class="dt-right">'+importe+'</td>';
                html += '</tr>';

            });
            html += '</tbody>';
            html += '</table>';
            return html;
        }

        function getListado(){
            var _url = 'adelantos/datatable?desde='+$('#desde').val()+'&hasta='+$('#hasta').val();

            if ( $.fn.dataTable.isDataTable( '#tablaListado' ) ) { //limpiamos las cabeceras ya que por alguna razon duplica si no hacemos esto
                $('#tablaListado').DataTable().destroy();
                $('div').each(function(){
                    if( $(this).hasClass('DataTables_sort_wrapper') ){
                        $(this).remove();
                    }
                });
                $('#tablaListado tbody').unbind('click');
            }

            var childRows = null;

             table = $('#tablaListado').DataTable({
                 fixedColumns: true,
                 order: [[ 1, "desc" ]],
                 responsive: true,
                 autoWidth: true,
                 dom: 'Bfrtip',
                 language: espanis_data,
                 ajax : _url,
                 buttons: getButtons(buttons_data),
                 columns: [
                    { "data": "id", "title":"ID", "className": 'details-control' },
                    { "data": "fecha", "title":"Fecha de creacion", "className": 'details-control',},
                    { "data": "entregado_name", "title":"Entregado por", "className": 'details-control',},
                    { "data": "para_name", "title":"Para", "className": 'details-control', },
                    { "data": "recibido_name", "title":"Recibido por", "className": 'details-control'},
                    { "data": "importe", "title":"Importe", "className":"details-control" },
                    { "data": "fecha_recibido", "title":"Fecha Recibido", "className":"dt-right details-control" },
                    { "data": 'acciones', 'title': 'acciones', orderable: false, searchable: false, class: 'noexport, dt-center'}
                ],
                "initComplete": function () {
                    childRows = table.rows($('.shown'));
                },
            });

            var isMobile = false; //initiate as false
            // device detection
            if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
                || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) {
                isMobile = true;
            }
            if(!isMobile){

                console.log('is NOT mobile');
                $('#tablaListado tbody').removeClass('details-control-img');

                $('#tablaListado tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = table.row( tr );
                } );
            }else{
                console.log('is not movbile');
            }
        }

        function eliminarme(id, _token , rutaDestroy){
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
          })
          swalWithBootstrapButtons.fire({
            title: 'No podras revertir esta accion!',
            text: "Estas seguro de eliminar el Adelanto?",
            html: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si, borrarlo ya!',
            cancelButtonText: 'No, Cancelar!',
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData();
                formData.append('id', id);
                formData.append('_token', _token);
                postData(rutaDestroy, formData).then(function(rta){
                    console.log('postData OK'); console.log(rta);
                    toastr.options = { "closeButton": true, };
                    toastr.success(rta['msg'], 'Buen Trabajo!');
                    $('#tablaListado').DataTable().ajax.reload();
                }).catch(function(error){
                    console.log('postData dio error'); console.log(error);
                    Swal.fire('Ocurrio un Error', error, 'error');
                });

            }
          });
}


    </script>
@stop

@section('css')
<style>
    td.details-control {
        cursor: pointer;
    }
</style>
@stop

