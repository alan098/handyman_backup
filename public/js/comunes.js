/*
        "lengthMenu": "Mostrando " +
                               `
                               <select class="custom-select custom-select-sm form-control form-control-sm">
                                   <option value='10'>10<option>
                                   <option value='25'>25<option>
                                   <option value='50'>50<option>
                                   <option value='100'>100<option>
                                   <option value='-1'>Todo<option>
                               <select>

                               `
                               + " registros por página",

       */


$.datepicker.regional['es'] = {
    closeText: 'Cerrar',
    prevText: '< Ant',
    nextText: 'Sig >',
    currentText: 'Hoy',
    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
    weekHeader: 'Sm',
    dateFormat: 'dd/mm/yy',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
};
$.datepicker.setDefaults($.datepicker.regional['es']);


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
                $('#password').attr('placeholder', '');
                $('#password').attr('required', true);
                $('#id').val('');
                $('#formCrud').trigger('reset');
                $('#formCrudModal').modal('show');
                $('#formCrudModal').on('shown.bs.modal', function () {
                    $('#formCrud input:text:visible:first', this).focus();
                });
                $('.select2').select2( ).trigger('change');
                $('input:checkbox').attr('checked', false);
                $('#es_activo').attr('checked', true);
                $('#activo').attr('checked', true);
                $('.dias').attr('checked', true);
                $('.chsucursales').attr('checked', true);
            }
        },
    ];
    return buttons;
}
function puntearNum(num){
    num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
    num = num.split('').reverse().join('').replace(/^[\.]/,'');
    return num;
}

// #tablaCrud_filter label input

function toDataTable(data) {
    $('#' + data.table).DataTable({
        order: [[0, "desc"]],
        responsive: true,
        autoWidth: false,
        ajax: data.ajax,
        columns: data.columns,
        language: espanis_data,
        dom: 'Bfrtip',
        buttons: getButtons(data),
        initComplete: function () {
            // console.log( '#'+data.table+'_filter label input' );
            // console.log( $('#'+data.table+'_filter label input') );
            // $('#'+data.table+'_filter label input').focus();
        },
        drawCallback: function( settings ) {
            $('[data-toggle="tooltip"]').tooltip();
            // $('search').focus();
            // $('#example_filter label input').focus();
            $('#tablaCrud_filter label input').on('keydown',function(e) {
                console.log( 'entra => ' + e.which );
                if ( (e.which == 78)) {
                    $('#formCrudModal').modal('show');
                }
            });

        }
    });
}
function cambiarSucursal(){
    $('#cam_sucu').appendTo("body").modal('show'); //este inserta el modal dentro del body
    var ruta='admin/navbar/optener/sucursal'
    //eliminamos los anteriores 
    sessionStorage.removeItem('ent');
    sessionStorage.removeItem('suc');
    sessionStorage.removeItem('dep');
    getData(ruta).then(function(rta){
     //y volvemos a insertar
     sessionStorage.setItem("ent",JSON.stringify(rta.ent));
     sessionStorage.setItem("suc",JSON.stringify(rta.suc));
     sessionStorage.setItem("dep",JSON.stringify(rta.depo));
     //rellenamos las sucursales
     var numero_entidad= 1
     $('#cam_sucu .entidad_ option').remove().promise().done(function(){
        $.each(rta.ent, function(i, item) {
            if (numero_entidad == item.id) {
                $("#cam_sucu .entidad_").append("<option selected value="+item.id+">"+item.name+"</option>");
            }else{
                $("#cam_sucu .entidad_").append("<option value="+item.id+">"+item.name+"</option>"); 
            }
        });
    });
    $('#cam_sucu .sucursal_ option').remove().promise().done(function(){
        $.each(rta.suc, function(i, item) {
            if (numero_entidad == item.entidad_id) {
                $("#cam_sucu .sucursal_").append("<option value="+item.id+">"+item.name+"</option>");
            } 
        });
    });
    $('#cam_sucu .deposito_ option').remove().promise().done(function(){
        $.each(rta.depo, function(i, item) {
            if (numero_entidad == item.entidad_id) {
                $("#cam_sucu .deposito_").append("<option value="+item.id+">"+item.name+"</option>");
            } 
        });
    });
    }).catch(function(error){
        console.log('getData dio error'); console.log(error);
        Swal.fire('Ocurrio un Error', error.message, 'error');
    });
}
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
        buttons: [],
        drawCallback: function( settings ) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
}
function ajustarFac(tam, num) {
    if (num.toString().length <= tam) return ajustarFac(tam, "0" + num)
    else return num;
}

//aqui ajuste
function postData(ruta, data) {
    console.log('postData');
    // console.log(data);

    return new Promise(function (resolve, reject) {
        $('#sumbitButton').attr('disabled', true);
        $('#submitSpinner').addClass('spinner-border');
        $.ajax({
            url: ruta,
            type: 'POST',
            method: 'POST',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            success: function (rta) {

                $('#sumbitButton').attr('disabled', false);
                $('#submitSpinner').removeClass('spinner-border');

                if (rta.cod == 200) {
                    resolve(rta);
                } else {
                    var mensaje = '';
                    if(rta.dat){ //kaka
                        $.each(rta.dat, function (key, val) {
                            mensaje += '[<b>' + key + '<b>]: '+val + '<br />';
                        });
                    }
                    // Swal.fire(rta.msg, mensaje, 'error');
                    Swal.fire({
                        title: rta.msg,
                        icon: 'warning',
                        html: mensaje
                    });

                    reject(rta);
                }
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            $('#sumbitButton').attr('disabled', false);
            $('#submitSpinner').removeClass('spinner-border');
            var error = '';
            if (jqXHR.status === 0) {
                errror = 'Not connect: Verify Network.';
            } else if (jqXHR.status == 404) {
                error = 'Requested page not found [404]';
            } else if (jqXHR.status == 500) {
                error = 'Internal Server Error [500].';
            } else if (textStatus === 'parsererror') {
                error = 'Requested JSON parse failed.';
            } else if (textStatus === 'timeout') {
                error = 'Time out error.';
            } else if (textStatus === 'abort') {
                error = 'Ajax request aborted.';
            } else {
                error = 'Uncaught Error: ' + jqXHR.responseText;
            }
            reject(error);
        });
    });
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
function addFecha(id,fecha){
    var ts = new Date(fecha);
    datetext = ts.toTimeString();
    datetext = datetext.split(' ')[0];
    $('#'+id).val(datetext.substring(0,5));
}
function addFechaModal(id,fecha,modal){
    var ts = new Date(fecha);
    datetext = ts.toTimeString();
    datetext = datetext.split(' ')[0];
    $('#'+modal+' #'+id).val(datetext.substring(0,5));
}
function formatearFecha(fecha){
    var hora =fecha.split(' ')[1];
    var repla1= hora.split(':');
    var json1= repla1[0] + ':' + repla1[1];
    // console.log(json1)
    return json1;
}

function sumPrecioHora(){
    var total=0;
    var hor1='00:00'
    var end='00:00'
    $('#formCrudModal #tabla-lista tbody tr').each(function(e,data) {
        //dinero
        total=   total +   parseInt($('#'+data.id+'_td').attr('precio'));
        //horas
        var repla1= hor1.split(':');
        var repla2= $('#'+data.id+'_td').attr('dura').split(':');
        var json1 = { hour : repla1[0], minutes : repla1[1] };
        var json2 = { hour : repla2[0], minutes : repla2[1] };

        hr            = parseInt(json1.hour) + parseInt(json2.hour);
        mn            = parseInt(json1.minutes) + parseInt(json2.minutes);
        final_hr      = hr + Math.floor(mn/60);
        final_mn      = mn%60;
        final_mn      = (final_mn < 10) ? '0' + final_mn : final_mn;
        console.log(final_hr + ':' + final_mn);

        hor1= final_hr + ':' + final_mn;
        end= $('#'+data.id+'_td').attr('fin');

    });

    $("#formCrudModal #id-total").html(total);
    $("#formCrudModal #id-tiempo-total").text(hor1);
    $('#formCrudModal #end').val(end)
}
function iva5(importe){
    var iva = importe - (importe / 1.05);
    return Math.round(iva);
}
function iva10(importe){
    var iva = importe - (importe / 1.1);
    return Math.round(iva);
}

function sumHours(hor1,hor2,modalinicio,modalfin,duracion){
    var repla1= hor1.split(':');
    if (hor2 == null) { hor2='00:30';}
    var repla2= hor2.split(':');
    var json1 = { hour : repla1[0], minutes : repla1[1] };
    var json2 = { hour : repla2[0], minutes : repla2[1] };
    if (repla1[0].length == 1) {
        $(modalinicio).val(ajustarFac(1,repla1[0]) + ':' + repla1[1])
   }else{
        $(modalinicio).val(hor1)
   }

    $(duracion).val(repla2[0] + ':' + repla2[1])
    sumHoursJson(json1, json2,modalfin)
}
function sumHoursJson(json1, json2,modalfin) {
    hr            = parseInt(json1.hour) + parseInt(json2.hour);
    mn            = parseInt(json1.minutes) + parseInt(json2.minutes);
    final_hr      = hr + Math.floor(mn/60);
    final_mn      = mn%60;
    final_mn      = (final_mn < 10) ? '0' + final_mn : final_mn;
    var fin="";
    if (String(final_hr).length == 1) {
         fin= ajustarFac(1,final_hr) + ':' + final_mn;
    }else{
         fin=final_hr + ':' + final_mn;
    }
    $(modalfin).val(fin)
}
function resHours(hor1,hor2,modalinicio,modalfin,duracion){
    var repla1= hor1.split(':');
    var repla2= hor2.split(':');
    var json1 = { hour : repla1[0], minutes : repla1[1] };
    var json2 = { hour : repla2[0], minutes : repla2[1] };
    $(modalinicio).val(hor1)
    $(duracion).val(repla2[0] + ':' + repla2[1])
    resHoursJson(json1, json2,modalfin)
}
function resHoursJson(json1, json2,modalfin) {
    hr            = parseInt(json1.hour) - parseInt(json2.hour);
    mn            = parseInt(json1.minutes) - parseInt(json2.minutes);
    final_hr      = hr + Math.floor(mn/60);
    final_mn      = mn%60;
    final_mn      = (final_mn < 10) ? '0' + final_mn : final_mn;

    if (String(final_hr).length == 1) {
        fin= ajustarFac(1,final_hr) + ':' + final_mn;
   }else{
        fin=final_hr + ':' + final_mn;
   }
   console.log("alan"+fin);
    $(modalfin).val(fin)
}
function toadErrores(msg){
    toastr.options = {
        "closeButton": true,
        "positionClass": "toast-top-full-width",
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
    toastr.error(msg);
}

function getData(ruta) {

    return new Promise(function (resolve, reject) {
        $('#sumbitButton').attr('disabled', true);
        $('#submitSpinner').addClass('spinner-border');
        $.ajax({
            url: ruta,
            type: 'GET',
            method: 'GET',
            processData: false,
            contentType: false,
            cache: false,
            success: function (rta) {
                $('#sumbitButton').attr('disabled', false);
                $('#submitSpinner').removeClass('spinner-border');
                resolve(rta);
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            $('#sumbitButton').attr('disabled', false);
            $('#submitSpinner').removeClass('spinner-border');
            var error = '';
            if (jqXHR.status === 0) {
                errror = 'Not connect: Verify Network.';
            } else if (jqXHR.status == 404) {
                error = 'Requested page not found [404]';
            } else if (jqXHR.status == 500) {
                error = 'Internal Server Error [500].';
            } else if (textStatus === 'parsererror') {
                error = 'Requested JSON parse failed.';
            } else if (textStatus === 'timeout') {
                error = 'Time out error.';
            } else if (textStatus === 'abort') {
                error = 'Ajax request aborted.';
            } else {
                error = 'Uncaught Error: ' + jqXHR.responseText;
            }
            if (error != '') {

                reject(error);
            }
        });
    });
}

function populateForm(formId, data,dataExtra=0) {


    $.each(data, function (key, value) {
        $('.chsucursales').attr('checked', false);
        if ($('#' + formId + ' #' + key).length > 0) {
            // console.log('No Array :: ' + key +' => '+ value);
            if( key == 'imagen'){
                if(value){
                    $('#preview').html("<img id='target' src='" + value + "' style='display: inline-block;'>");
                    var src = document.getElementById("imagen");
                    var target = document.getElementById("target");
                    showImage(src,target);
                    $('#eliminarImagen').show();
                }else{
                    $('#eliminarImagen').hide();
                }
            }else{
                if( $( '#' + formId + ' #' + key ).is(':checkbox')){ //si es checkbox comprobamos para poner como checked o no
                    if(value === true){
                        $( '#' + formId + ' #' + key ).attr('checked', true);
                    }else{
                        $( '#' + formId + ' #' + key ).attr('checked', false);
                    }
                }else{ //si es un input cualquiera asiganmos su valor
                    $('#' + formId + ' #' + key).val(value);
                }
            }
        } else {
            //  console.log(key + ' no existe por id buscamos por nombre');
            if ( $('#' + formId + ' [name="' + key + '[]"]').length > 0) {
                // console.log(key + 'existe por nombre');
                let esArray = Array.isArray(value);
                if(esArray){
                    // console.log('Es Array :: ' + key); console.log(value);
                    if( $('#' + formId + ' [name="' + key + '[]"]').is(':checkbox')){ //si es checkbox comprobamos para poner como checked o no
                        $.each(value, function (k, v) {
                            $( '#' + formId + ' #' + key + '_' + v.id ).attr('checked', true);
                        });
                    }else{ //si es un input cualquiera asiganmos su valor
                        $('#' + formId + ' #' + key).val(value);

                    }
                }
            }
        }
    });
    if (dataExtra == 0) {
        $('.select2').select2().trigger('change');
    }
   
}


function store(formData, ruta){
    postData(ruta, formData).then(function(rta){
        console.log('postData OK'); console.log(rta);
        $('#formCrud').trigger('reset');
        $('#formCrudModal').modal('hide');
        toastr.options = { "closeButton": true, };
        toastr.success(rta['msg'], 'Buen Trabajo!');
        //console.log('recargando');
        $('#tablaCrud').DataTable().ajax.reload();

    }).catch(function(error){
        console.log('postData dio errorrrr'); console.log(error);
        // Swal.fire('Ocurrio un Error', error.message, 'error');
    });
}

function update(formData, ruta){
    postData(ruta, formData).then(function(rta){
        console.log('postData OK'); console.log(rta);
        $('#formCrud').trigger('reset');
        $('#formCrudModal').modal('hide');
        toastr.options = { "closeButton": true, };
        toastr.success(rta['msg'], 'Buen Trabajo!');
        //console.log('recargando');
        $('#tablaCrud').DataTable().ajax.reload();
    }).catch(function(error){
        console.log('postData dio errors'); console.log(error);
        // Swal.fire('Ocurrio un Error', error.message, 'error');
    });
}

function editar( ruta ){ //kaka
    //console.log(ruta);
    $('#password').attr('placeholder', 'Solo ingrese si desea cambiar');
    $('#password').attr('required', false);

    getData(ruta).then(function(rta){
        //console.log('getData OK'); console.log(rta);
        populateForm('formCrud', JSON.parse( rta ) );
        $('#formCrudModal').modal('show');
    }).catch(function(error){
        console.log('getData dio error'); console.log(error);
        Swal.fire('Ocurrio un Error', error.message, 'error');
    });
}
function cargando(accion,tam ='50px',button){
    $('.loader').css('width',tam)
    $('.loader').css('height',tam)
    if (accion == 'show') {
        $('.loader').show()
        $(button).attr('disabled',true);
    }else if (accion == 'hide') {
        $('.loader').hide()
        $(button).attr('disabled',false);
    }
}
function Generales(datos){
    /*esta es una una funcion que recorre y completa de acuerdo a lo que se necesite
        & = son saltos de lineas
        # = son comas
        eL ultimo DATO SIEMPRE VA A SER EL MODAL QUE SE DEBE ABRIR
    */
    var arrayUno = datos.split('&');
    var longitud = arrayUno.length;
    arrayUno.forEach(function callback(ele,key) {

        if (key == (longitud -1 )) {
            console.log(ele+"/"+key)
            $('#'+ele).modal('show');
        }else{
            var arrayDos= ele.split('#');
            llamarData(arrayDos);
        }

    });
}
/*
    +generales
        -arrayDos[0] = es el tipo
        -arrayDos[1] = es la ruta
    +populate
        -necesita el tipo y la ruta
        -arrayDos[2] = es el nombre del formulario
    + chekect
        -necesita el tipo y la ruta
        -arrayDos[2] = es el nombre del  del id sin la concatenacion ejemplo(sucursal_,entidad_,deposito_ etc.)
        -arrayDos[3] = es el nombre para buscar dentro del arreglo y concatentar con arrayDos[2] ejemplo ((sucursal_1...,entidad_1...,deposito_1.. etc.))
    +append
        -necesita el tipo y la ruta
        -arrayDos[2] = es el nombre del  del id nada mas
        -arrayDos[3] = es el nombre de la funcion asociada que maneja el html en esa pagina en especifica
 */
function llamarData(arrayDos){
    //populate
    if(arrayDos[0] == 'populate'){
        getData(arrayDos[1]).then(function(rta){
            console.log(rta);
            populateForm(arrayDos[2], JSON.parse( rta ) );
        }).catch(function(error){
            console.log('populate dio error'); console.log(error);
            Swal.fire('Ocurrio un Error', error.message, 'error');
        });
    }
    //cheket
    else if (arrayDos[0] == 'checked') {
        getData(arrayDos[1]).then(function(rta){
            $("input[id^='"+arrayDos[2]+"']" ).prop('checked', false).promise().done(function(){
                if(rta.length > 0){
                    $.each(rta, function (key, ele) {
                        $('#'+arrayDos[2]+ele[arrayDos[3]]).prop('checked', true);
                    });
                }
            })
        }).catch(function(error){
            console.log('checked dio error'); console.log(error);
            Swal.fire('Ocurrio un Error', error.message, 'error');
        });
    }
    //append
    else if (arrayDos[0] == 'append') {
        getData(arrayDos[1]).then(function(data){
                if(data.length > 0){
                    $.each(data, function (key, ele) {
                        // var x = String(arrayDos[3]);
                        // console.log(x);
                        $('#'+arrayDos[2]).append( [ele].map(Item).join('') );
                    });
            }
        }).catch(function(error){
            console.log('append dio error'); console.log(error);
            Swal.fire('Ocurrio un Error', error.message, 'error');
        });
    }
}


function eliminar(id, _token, rutaConfirm, rutaDestroy){
    getData(rutaConfirm).then(function(rta){
        //console.log('getData OK'); console.log(rta);
        var data = JSON.parse( rta );

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
          })

          swalWithBootstrapButtons.fire({
            title: 'No podras revertir esta accion!',
            text: "Estas seguro de eliminar a "+data.name+"?",
            html: "Estas seguro de eliminar a <b>"+data.name+"</b>?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si, borrarlo ya!',
            cancelButtonText: 'No, Cancelar!',
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {

                var formData = new FormData(); // Currently empty
                formData.append('id', id);
                formData.append('_token', _token);

                //ar formData = { "id":id,  "_token": "{{ csrf_token() }}" }
                postData(rutaDestroy, formData).then(function(rta){
                    console.log('postData OK'); console.log(rta);
                    toastr.options = { "closeButton": true, };
                    toastr.success(rta['msg'], 'Buen Trabajo!');
                    $('#tablaCrud').DataTable().ajax.reload();
                }).catch(function(error){
                    console.log('postData dio error'); console.log(error);
                    Swal.fire('Ocurrio un Error', error, 'error');
                });

            }
          });
    }).catch(function(error){
        console.log('getData dio error'); console.log(error);
        Swal.fire('Ocurrio un Error', error.message, 'error');
    });
}

function forPromesas(promesas){
    //por favor no colocar console.log porque explota todo o si coloca solo pra pruebas
    var longitud_promesa=promesas.length;//1 2 3
    var cont=0;  var rta=true;
    return new Promise(function (resolve, reject) {
        promesas.map(function(x) {
            reorganizar(x.id_divisoria,x.name);
            cont = cont + 1;
         });
        if (cont == longitud_promesa) {
            resolve(rta); 
        }
        if ("no"=="si") {
            reject((rta=false))
        }
    })
}
function reorganizar(id_divisoria,name){
    //por favor no colocar console.log porque explota todo o si coloca solo pra pruebas
    var error=0; var rta=true;
    var con_li= $(id_divisoria).length
    return new Promise(function (resolve, reject) {
        if (con_li == 0) {
            resolve(rta);
        }else{
            $(id_divisoria).each(function(e,data) {
                $($(this).find($('[name^="'+name+'"]')) ).each(function() {
                        var name = $(this).attr('name').split('[]');
                        var new_name=name[0]+'['+e+']'+name[1];
                        $(this).attr('name', new_name);
                })
                if (error != 0) { 
                    reject((rta=false));
                }
                if (e == (con_li - 1 ) ) {
                    resolve(rta); 
                }
            })
        }
    }); 
}

function realizarCambiosEntidades(){
    const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger'
    },
    buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
    title: 'Realizar el cambio de Entidad!',
    html: "todas las acciones se realizaran de acuerdo a la entidad seleccionada",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Si,Cambiar',
    cancelButtonText: 'No, Cancelar!',
    reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            var ruta='admin/navbar/change/'+$('#cam_sucu .entidad_').val()+'/'+$('#cam_sucu .sucursal_').val()+"/"+$('#cam_sucu .deposito_').val();
            getData(ruta).then(function(rta){
               console.log(rta);
            }).catch(function(error){
                console.log('getData dio error'); console.log(error);
                Swal.fire('Ocurrio un Error', error.message, 'error');
            });
        }
    });
}

function escucharCambios(){
var ruta='admin/navbar/optener/sucursal'
getData(ruta).then(function(rta){

    $("#ul_cambio_entidad").html('Entidad: '+rta.ent_ent);
    $("#ul_cambio_sucursal").html('Sucursal: '+rta.su_su);
    $("#ul_cambio_deposito").html('Deposito: '+rta.dep_dep);

}).catch(function(error){
    console.log('getData dio error'); console.log(error);
    Swal.fire('Ocurrio un Error', error.message, 'error');
});

var sucursales= JSON.parse(sessionStorage.getItem('suc'));
var depositos=  JSON.parse(sessionStorage.getItem('dep'));

$("#cam_sucu .entidad_").change(function() {
    var numero_entidad=$(this).val();
    $('#cam_sucu .sucursal_ option').remove().promise().done(function(){
        $.each(sucursales, function(i, item) {
            if (numero_entidad == item.entidad_id){
                $("#cam_sucu .sucursal_").append("<option value="+item.id+">"+item.name+"</option>");
            }
        });
    });
    $('#cam_sucu .deposito_ option').remove().promise().done(function(){
        $.each(depositos, function(i, item) {
            if (numero_entidad == item.entidad_id) {
                if ($("#cam_sucu .sucursal_").val() == item.sucursal_id) {
                    $("#cam_sucu .deposito_").append("<option value="+item.id+">"+item.name+"</option>");
                }
            }
            
        });
    });
});
$("#cam_sucu .sucursal_").change(function() {
    var numero_entidad = $('#cam_sucu .entidad_').val();
        $('#cam_sucu .deposito_ option').remove().promise().done(function(){
            $.each(depositos, function(i, item) {
                if (numero_entidad == item.entidad_id) {
                    if ($(this).val() == item.sucursal_id) {
                            $("#cam_sucu .deposito_").append("<option value="+item.id+">"+item.name+"</option>");
                    }
                }   
            });
      });
});
 
}

$( document ).ready(function() {

    const ItemCambioS = () => `
        <ul class="navbar-nav" id="ul_cambio">
            <button class="btn btn-primary"  onclick="cambiarSucursal()">Cambiar Entidad</button>
            <div class="modal fade" id="cam_sucu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="">Cambiar Entidad</h5>
                    </div>
                    <div class="modal-body">
                        
                        <div class="form-row mb-2">
                            <div class="col-2">
                                <label for=""> Entidad</label>
                            </div>
                            <div class="col-8">
                                <select class="form-control entidad_">
                                </select>
                            </div>
                        </div>
                        <div class="form-row mb-2">
                            <div class="col-2">
                                <label for=""> Sucursal</label>
                            </div>
                            <div class="col-8">
                                <select class="form-control sucursal_">
                                </select>
                            </div>
                        </div>
                        <div class="form-row mb-2">
                            <div class="col-2">
                                <label for=""> Deposito</label>
                            </div>
                            <div class="col-8">
                                <select class="form-control deposito_">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="realizarCambiosEntidades()">Guardar Cambios</button>
                    </div>
                </div>
                </div>
            </div>
        </ul>
        <ul class="navbar-nav ml-1 mr-1" id="ul_cambio_entidad"> Entidad: </ul>
        <ul class="navbar-nav ml-1 mr-1" id="ul_cambio_sucursal"> Sucursal: </ul>
        <ul class="navbar-nav ml-1 mr-1" id="ul_cambio_deposito"> Deposito: </ul>
    `;
    // if ( $('#ul_cambio').length == 0  ) {
    //     $('.main-header').append(ItemCambioS);
    //     if ($('#ul_cambio').length != 0 ){
    //         escucharCambios();
    //         $('.main-header ul').each(function(e,data) {
    //             if (e == 0) {
    //                 const span = document.getElementById("ul_cambio");
    //                 this.insertAdjacentElement("afterend", span);
    //             }
    //         })
    //     }
    // }
   

    // $( ".datepicker" ).datepicker( { altFormat: "yy-mm-dd" } );
    $('.datepicker').datepicker({
        language:'es',
        dateFormat: "dd/mm/yy",
    });
    //no se donse se encuentra los estilos de css asi que voy a dejar esto aqui
    $('.agrandar').attr('class', 'modal-dialog modal-lg');

    //aplicamos una funcion a un input que siempre sea cero
    $(document).on( "keyup", ".siempreCero", function(e){
      this.value= this.value.replace(/[^0-9]/g,'');
        if (!this.value) {
            $(this).val(0);
        }else{
            if ((this.value.length == 2) && (this.value[0] == 0) ) {
                this.value = this.value.replace(/^0+/, '');
            }  
        }        
        if(e.keyCode == 46) {
            if (!this.value) {
               $(this).val(0);
            }
        }
        if(e.keyCode == 8) {
            if (!this.value) {
                $(this).val(0);
            }
        }
    });
    $(document).on( "focus", ".siempreCero", function(){
        const end=this.value.length;
        const input = this;
        input.setSelectionRange(end, end);
        input.focus();
    });

    $('#formCrudModal').on('shown.bs.modal', function () {
        $('input:text:visible:first', this).focus();
    });

    $('#formCrudModal').on('hide.bs.modal', function () {
        if( $('#tabla-lista').length > 0 ){
            $('#tabla-lista tbody').empty(); //limpia la tabla que contiene opciones si es que existe
        }
    });

    $(document).on( "keyup", ".siempreCero", function(e){
        if(e.keyCode == 46) {
            if (!this.value) {
               $(this).val(0);
            }
        }
        if(e.keyCode == 8) {
            if (!this.value) {
                $(this).val(0);
            }
        }
    });

    $(document).on('keypress',function(e) {
        // console.log(e.which); console.log(e.key);
        if ( (e.which == 14)) {
            $('#formCrudModal').modal('show');
        }else if(e.which == 2){
            // console.log('focus');
            $('#tablaCrud_filter label input').focus();
        }
    });

    $('.select2').select2();

    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });

      $(document).on('focus', '.select2-selection.select2-selection--single', function (e) {
        $(this).closest(".select2-container").siblings('select:enabled').select2('open');
      });

      // steal focus during close - only capture once and stop propogation
      $('select.select2').on('select2:closing', function (e) {
        $(e.target).data("select2").$selection.one('focus focusin', function (e) {
            e.stopPropagation();
        });
      });


      $(document).on('change', '.sumar', function(){
        //   console.log('sumar');
        var suma = 0;
        $('.sumar').each(function(){
            if($(this).val()){
                suma += Number($(this).val());
            }
        });
        // console.log(suma);
        $('.total').val(suma);
      });

      $(document).on('change', '.sumar2', function(){
        //   console.log('sumar');
        var suma = 0;
        $('.sumar2').each(function(){
            if($(this).val()){
                suma += Number($(this).val());
            }
        });
        // console.log(suma);
        $('.total2').val(suma);
      });
      
//este es un stilo de 
$( 
`
    <style>
    .loader {
    border: 16px solid #f3f3f3;
    border-radius: 50%;
    border-top: 16px solid blue;
    border-right: 16px solid green;
    border-bottom: 16px solid red;
    border-left: 16px solid pink;
    width: 150px;
    height: 150px;
    -webkit-animation: spin 2s linear infinite;
    animation: spin 2s linear infinite;
    position: relative;
    }
    @-webkit-keyframes spin {
    0% { -webkit-transform: rotate(0deg); }
    100% { -webkit-transform: rotate(360deg); }
    }
    @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
    }
    </style>
   
`
).appendTo( '#loader_WH'  ).promise().done(function(){
    $('.loader').hide()
});

    // $(document).on('change', '.sumar', function(){

    // });

});
