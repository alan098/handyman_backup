

//todo: logica de botones de accion
$(document).on('click', '.botonGroup .btn', function (e){
    //* colocar loading----
    $('#datatable_seccion').css('display','none');
    $('#loader_seccion').css('display','block');

    e.preventDefault();
    var id =$(this).attr('id');
    $('.botonGroup .btn').each(function(e,data) {
        $(this).attr('class', 'btn btn-primary')
    }).promise().done( () => $(this).attr('class', 'btn btn-secondary'));
        var fecha_desde=$('#fecha_desde').val();
        var fecha_hasta=$('#fecha_hasta').val();
        var anho_desde=$('#anho_desde').val();
        var anho_hasta=$('#anho_hasta').val();
        var colaborador=$('#colaborador_id').val();
        var af="a";
        var sucursal=$('#sucursales').val();
        if ($('#flexRadioDefault1').prop('checked')) {
            var af="f";
        }
        var datos='?sucursal='+sucursal+'&f_desde='+fecha_desde+'&f_hasta='+fecha_hasta+'&a_desde='+anho_desde+'&a_hasta='+anho_hasta+'&af='+af+'&col_id='+colaborador;
        
        if(id=='0_1'){
            //ocultamos todo
            ocultalDatatable()
            datatableVentas(datos,id);
        }else if(id=='0_2'){
                ocultalDatatable()
                 datatableServicios(datos,id);
            }else if(id=='0_3'){
                    ocultalDatatable()
                     datatableComision(datos,id);
                     getListadoComision(datos,id);
                }else if(id=='0_4'){
                    ocultalDatatable()
                    datatableLocal(datos,id);
                    }else if(id=='0_5'){
                        ocultalDatatable()
                        datatableResumen(datos,id);
                        grafic(datos);
                        }
    
});
//todo: archivo que crea el datable
function SimpleDataTable(data,id) {
        //eliminamos el datatable y lo volvemos a crear
    if ( $.fn.dataTable.isDataTable( '#'+data.table ) ) { 
        $('#'+data.table).DataTable().destroy();
        $('div').each(function(){
            if( $(this).hasClass('DataTables_sort_wrapper') ){
                $(this).remove();
            }
        });
        $('#'+data.table+'tbody').unbind('click');
    }

      var tablebase=  $('#' + data.table).DataTable({
        order: [[0, "desc"]],
        // pageLength: 20,
        autoWidth: true,
        paging: true,
        ajax: data.ajax,
        columns: data.columns,
        language: espanis_data,
        searching: false,
        dom: 'Bfrtip',
        columnDefs:data.columnDefs,
        "lengthMenu": [ [10, 25, 100, -1], [10, 25, 100, "Todos"] ],
        buttons: [{
            extend: 'pageLength',
        }  
        ],
        drawCallback: data.drawCallback,
        initComplete: function(settings, json) {
            $('#datatable_seccion').css('display','block');
            $('#loader_seccion').css('display','none');
            $('#i_'+id).css('display','block');
        }
        
    });
    return tablebase
}


//todo seccion de datatable
function datatableVentas(datos,id){




    if ( $.fn.dataTable.isDataTable( '#table_ingresos_a') ) { 
        $('#table_ingresos_a').DataTable().destroy();
        $('div').each(function(){
            if( $(this).hasClass('DataTables_sort_wrapper') ){
                $(this).remove();
            }
        });
        $('#table_ingresos_a tbody').unbind('click');
    }
    
    var _url= url_01 + datos;
    var table_uno = $('#table_ingresos_a').DataTable({
        responsive: false,
        autoWidth: false,
        pageLength: 20,
        dom: 'Bfrtip',
        'ajax': {
            url: _url,
                data : function(d){
                },
        },
        "language": {
            "decimal": ",",
            "thousands": "."
        },
        "lengthMenu": [ [10, 25, 100, -1], [10, 25, 100, "Todos"] ],
        buttons: [{
            extend: 'pageLength',
        } ],
        columns: [
            {data:'info', name:'info',title:'Mas Info',class: 'noexport dt-center details-control-uno'},
            {data:'fecha', name:'fecha',title:'fecha',class: 'noexport dt-center'},
            {data:'mes', name:'mes',title:'Mes',class: 'noexport dt-center'},
            {data:'sucursal', name:'sucursal',title:'Local',class: 'noexport dt-center'},
            {data:'num_fac', name:'num_fac',title:'Fac.Num',class: 'noexport dt-center'},
            {data:'cli_ser', name:'cli_ser',title:'Cliente Servicio',class: 'noexport dt-center'},
            {data:'cli_fac', name:'cli_fac',title:'Cliente Factura',class: 'noexport dt-center'},
            {data:'imp_bru', name:'imp_bru',title:'Importe Bruto',class: 'noexport dt-center'},
            {data:'des_impor', name:'des_impor',title:'Decuento General',class: 'dt-center'},
            {data:'des_in', name:'des_in',title:'Decuentos Individuales',class: 'dt-center'},
            {data:'imp_real', name:'imp_real',title:'Total',class: 'noexport dt-center'},
            {data:'iva', name:'iva',title:'Iva',class: 'noexport dt-center'},
            {data:'metodos', name:'iva',title:'Metodo',class: 'noexport dt-center'},
            {data:'pagos', name:'iva',title:'Pagos',class: 'noexport dt-center'},
        ],
        "initComplete": function () {
            $('#datatable_seccion').css('display','block');
            $('#loader_seccion').css('display','none');
            $('#i_'+id).css('display','block');
            childRows = table_uno.rows($('.shown'));
        },
            columnDefs: [
            {
                targets: [7,8,9, 10,11],
                render: $.fn.dataTable.render.number(',', '.', '')
            }
            ],
            drawCallback: function() {
                var api = this.api();
                var bruto = api.column(7).data().sum();
                var descuento = api.column(8).data().sum();
                var des_in = api.column(9).data().sum();
                var real= api.column(10).data().sum();
                $('#1_bru').text(getFormatGS(bruto));
                $('#1_des').text(getFormatGS(descuento));
                $('#1_des_in').text(getFormatGS(des_in));
                $('#1_re').text(getFormatGS(real));
            },
        });

        var isMobile = false; //initiate as false
        // device detection
        if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
            || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) {
            isMobile = true;
        }
        if(!isMobile){
            $('#table_ingresos_a tbody').on('click', 'td.details-control-uno', function () {
                var tr = $(this).closest('tr');
                var row = table_uno.row( tr );
                if ( row.child.isShown() ) {
                    row.child.hide();
                    tr.removeClass('shown');
                }else {
                    row.child( format(row.data()) ).show();
                    tr.addClass('shown');
                }
            } );
        }
}

function datatableServicios(datos,id) {
    var _url = url_02 + datos;
    var data = {
        table: "table_ingresos_i",
        ajax : _url,
        topMsg: "",
        filename: "Listado",
        title: 'Listado',
        columns: [
            {data:'fecha', name:'fecha',title:'fecha',class: 'noexport dt-center'},
            {data:'mes', name:'mes',title:'Mes',class: 'noexport dt-center'},
            {data:'sucursal', name:'sucursal',title:'Local',class: 'noexport dt-center'},
            {data:'num_fac', name:'num_fac',title:'Fac.Num',class: 'noexport dt-center'},
            {data:'prof', name:'prof',title:'Prof.',class: 'noexport dt-center'},
            {data:'cli_ser', name:'cli_ser',title:'Cliente',class: 'noexport dt-center'},
            {data:'ar_name', name:'ar_name',title:'Servicio',class: 'noexport dt-center'},
            {data:'imp_bru', name:'imp_bru',title:'Importe Bruto',class: 'noexport dt-center'},
            {data:'mon_pro_bru', name:'mon_pro_bru',title:'Producto Bruto',class: 'noexport dt-center'},
            {data:'mon_ser_bru', name:'mon_ser_bru',title:'Servicio Bruto',class: 'noexport dt-center'},
            {data:'des_impor', name:'des_impor',title:'Decuento X Servicio',class: 'noexport dt-center'},
            {data:'imp_real', name:'imp_real',title:'Total',class: 'noexport dt-center'},
            {data:'mon_pro', name:'mon_pro',title:'Tot. Serv.',class: 'noexport dt-center'},
            {data:'mon_ser', name:'mon_ser',title:'Tot. Prod.',class: 'noexport dt-center'},
            {data:'porc', name:'porc',title:'%',class: 'noexport dt-center'},
            {data:'comi_bruta', name:'comi_bruta',title:'Comision Bruta',class: 'noexport dt-center'},
            {data:'comi_rea', name:'comi_rea',title:'Comision',class: 'noexport dt-center'},
        ],
        columnDefs: [
        {
          targets: [7,8,9,10,11,12,13,14,15,16],
          render: $.fn.dataTable.render.number(',', '.', '')
        }
      ],
      drawCallback: function() {
        var api = this.api();
        var bruto_ser = api.column(9).data().sum();
        var bruto_pro = api.column(8).data().sum();
        
        var real_ser = api.column(13).data().sum();
        var real_pro = api.column(12).data().sum();

        var des_in = api.column(10).data().sum();
        var real = api.column(11).data().sum();
        
        $('#2_bru_ser').text(getFormatGS(bruto_ser));
        $('#2_bru_pro').text(getFormatGS(bruto_pro));
        $('#2_des').text(getFormatGS(des_in));
        $('#2_rel_ser').text(getFormatGS(real_pro));
        $('#2_rel_pro').text(getFormatGS(real_ser));
        $('#2_rel_rel').text(getFormatGS(real));
        },
    };
    SimpleDataTable(data,id);
}

function datatableComision(datos,id){
    var _url = url_03 + datos;
    var data = {
        table: "table_comisiones",
        ajax : _url,
        topMsg: "",
        filename: "Listado",
        title: 'Listado',
        columns: [
            {data:'mes', name:'mes',title:'Mes',class: 'noexport dt-center'},
            {data:'bruto', name:'bruto',title:'Importe Bruto',class: 'noexport dt-center'},
            {data:'real', name:'real',title:'Importe',class: 'noexport dt-center'},
        ],
        columnDefs: [
        {
        targets: [1,2],
          render: $.fn.dataTable.render.number(',', '.', '')
        }
        ],
        drawCallback:function( settings ) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    };
    SimpleDataTable(data,id);

}
function datatableLocal(datos,id){
    var _url = url_04 + datos;
    var data= {
        table: "table_locales",
        ajax : _url,
        topMsg: "",
        filename: "Listado",
        title: 'Listado',
        columns: [
            {data:'name', name:'name',title:'Sucursal',class: 'noexport dt-center'},
            {data:'detalles.importe', name:'importe',title:'Importe Bruto',class: 'noexport dt-center'},
            {data:'detalles.total', name:'total',title:'Importe',class: 'noexport dt-center'},
        ],
        columnDefs: [
        {
        targets: [1,2],
            render: $.fn.dataTable.render.number(',', '.', '')
        }
        ],
        drawCallback:function( settings ) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    };
    SimpleDataTable(data,id);
}
function datatableResumen(datos,id){
    var _url = url_05 + datos;
    var data = {
        table: "table_resumen",
        ajax : _url,
        topMsg: "",
        filename: "Listado",
        title: 'Listado',
        columns: [
            {data:'mes', name:'mes',title:'Mes',class: 'noexport dt-center'},
            {data:'importe', name:'importe',title:'Importe Bruto',class: 'noexport dt-center'},
            {data:'total', name:'total',title:'Importe',class: 'noexport dt-center'},
            {data:'comi', name:'comi',title:'Comision',class: 'noexport dt-center'},
        ],
        columnDefs: [
        {
        targets: [1,2,3],
            render: $.fn.dataTable.render.number(',', '.', '')
        }
        ],
        drawCallback:function( settings ) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    };
    SimpleDataTable(data,id);
}
function getListadoComision(datos,id){
    var _url= url_06 + datos;
    if ( $.fn.dataTable.isDataTable( '#table_comisiones_in') ) { 
        $('#table_comisiones_in').DataTable().destroy();
        $('div').each(function(){
            if( $(this).hasClass('DataTables_sort_wrapper') ){
                $(this).remove();
            }
        });
        $('#table_comisiones_in tbody').unbind('click');
    }
            var table_dos = $('#table_comisiones_in').DataTable({
            responsive: true,
            pageLength: 20,
            autoWidth: true,
            dom: 'Bfrtip',
            'ajax': {
                url: _url,
                    data : function(d){
                    },
            },
            "language": {
                "decimal": ",",
                "thousands": "."
            },
            "lengthMenu": [ [10, 25, 100, -1], [10, 25, 100, "Todos"] ],
            buttons: [{
                extend: 'pageLength',
            } ],
            searching: false,
            "iDisplayLength": 20,
            "columns": [
                {data:'info', name:'info',title:'Mas Info',class: 'noexport dt-center details-control'},
                {data:'name', name:'name',title:'Colaborador',class: 'noexport dt-center details-control'},
                {data:'bruto', name:'bruto',title:'Importe Bruto',class: 'noexport dt-center'},
                {data:'real', name:'real',title:'Importe Real',class: 'noexport dt-center'},
            ],
            columnDefs: [
                {
                  targets: [2, 3],
                  render: $.fn.dataTable.render.number(',', '.', '')
                }
              ],
            "initComplete": function () {
                $('#datatable_seccion').css('display','block');
                $('#loader_seccion').css('display','none');
                $('#i_'+id).css('display','block');
                childRows = table_dos.rows($('.shown'));
            },
                    
            });
        
    var isMobile = false; //initiate as false
    // device detection
    if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
        || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) {
        isMobile = true;
    }
    if(!isMobile){
        $('#table_comisiones_in tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table_dos.row( tr );
            if ( row.child.isShown() ) {
                row.child.hide();
                tr.removeClass('shown');
            }else {
                row.child( formatcomi(row.data()) ).show();
                tr.addClass('shown');
            }
        } );
    }
}

//FUNCIONES 

//FUNCION SUM
jQuery.fn.dataTable.Api.register( 'sum()', function ( ) {
    return this.flatten().reduce( function ( a, b ) {
        if ( typeof a === 'string' ) {
            a = a.replace(/[^\d.-]/g, '') * 1;
        }
        if ( typeof b === 'string' ) {
            b = b.replace(/[^\d.-]/g, '') * 1;
        }
        return a + b;
    }, 0 );
} );


//ventas generales
var base=` 
<tr>
    <th>Colaborador.</th>
    <th>Art./Ser.</th>
    <th>Cantidad</th>
    <th>Unitario</th>
    <th>Importe Bruto</th>
    <th>Importe</th>
    <th>Descuento unitario</th>
</tr>`;
function format ( d ) {
    var html = '<table class="display" style="width:100%">';
    html += '<thead>';
    html +=base;
    html += '</thead>';
    html += '<tbody>';
    d.venta_detalles.forEach(function(valor, indice, array){
        html += '<tr>';
        if(typeof(valor.colaora) != "undefined" && valor.colaora !== null) { 
            html += '<td>'+valor.colaora.name+'</td>';    
        }else{
            html += '<td>Articulo</td>';
        }
        html += '<td>'+valor.articulo.name+'</td>';
        html += '<td>'+valor.cantidad+'</td>';
        html += '<td>'+valor.precio_unitario+'</td>';
        html += '<td>'+valor.gravada10+'</td>';
        html += '<td>'+valor.precio_total+'</td>';
        html += '<td class="dt-right">'+valor.importe_descuento+'</td>';
    html += '</tr>';

    });
    html += '</tbody>';
    html += '</table>';
    return html;
}    
var basecomi=` 
<tr>
    <th>Mes</th>
    <th>Importe Bruto</th>
    <th>Total</th>
</tr>`;
function formatcomi ( d ) {
    var html = '<table class="display" style="width:100%">';
    html += '<thead>';
    html +=basecomi;
    html += '</thead>';
    html += '<tbody>';
    if(d.meses){
        d.meses.forEach(function(valor, indice, array){
            html += '<tr>';
                html += '<td>'+valor.mes+'</td>';
                html += '<td>'+getFormatGS(valor.bruto)+'</td>';
                html += '<td>'+getFormatGS(valor.real)+'</td>';
            html += '</tr>';
            });
    }
    
    html += '</tbody>';
    html += '</table>';
    return html;
} 
function ocultalDatatable(){
    $("[id^='i_0_']").css('display','none');
}
function getFormatGS(num)
{
        if(!isNaN(num)){
            num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
            num = num.split('').reverse().join('').replace(/^[\.]/,'');
            return num;
        }
        return 0;
}
