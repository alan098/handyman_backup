@extends('layouts.admin')
    @section('styles')
        <link href="{{ asset('vendor/jquery-ui-1.12.1/jquery-ui.min.css') }}" rel="stylesheet">
        <style>
            table.dataTable thead th, table.dataTable thead td{
                padding: 10px;
            }

            .botones{
                font-size: 20px;
                margin-top: 12px;
            }

            .botonera{
                margin: 10px 0px 10px 0px;
            }

        </style>
    @endsection

    @section('main-content')

        <div class="card shadow mb-3 col-12 p-0">
            <div class="card-body" style="padding: 10px 20px 0px 20px;">
                <div class="card-header py-3" style="padding: 5px 10px 4px 0px !important;font-size: 20px;font-weight: bold;">
                    Artículos en Stock
                </div>
                <div id="datos_tabla">
                    @include('stock.existencia.listar_datos')
                </div>
            </div>
        </div>

    @endsection

    @section('script')

        <script src="{{ asset('vendor/jquery-ui-1.12.1/jquery-ui.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js"></script>

        <script type="text/javascript">

            //<editor-fold desc="Funciones para formatear">
            var format = function(num){
                var str = num.toString().replace("$", ""), parts = false, output = [], i = 1, formatted = null;
                if(str.indexOf(",") > 0) {
                    parts = str.split(",");
                    str = parts[0];
                }
                str = str.split("").reverse();
                for(var j = 0, len = str.length; j < len; j++) {
                    if(str[j] != ",") {
                        output.push(str[j]);
                        if(i%3 == 0 && j < (len - 1)) {
                            output.push(".");
                        }
                        i++;
                    }
                }
                formatted = output.reverse().join("");
                return(formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
            };

            function formatearFecha(fecha){
                return fecha.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
            }

            //</editor-fold>

            //<editor-fold desc="Paginado Ajax">

            $(document).on('click', 'div#paginado_normal .pagination a', function (event){
                //alert('ok');
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                paginadoAjax(page);
            });

            function paginadoAjax(page){
                var deposito_id = $('#deposito_id').val();
                var busqueda = $('#buscar_articulos').val();
                var estante_id = $('#estante_id').val();
                //alert(deposito_id);
                $.ajax({
                    url: "{{route('stock.existencia.paginadoAjax')}}"+'?page='+page,
                    data: {deposito_id: deposito_id, busqueda: busqueda},
                    success:function (data){
                        $('#datos_tabla').html(data);
                    }
                });
            }

            //</editor-fold>

            //<editor-fold desc="Impresiones">

            function printDiv(nombreDiv) {
                var contenido= document.getElementById(nombreDiv).innerHTML;
                var contenidoOriginal= document.body.innerHTML;
                document.body.innerHTML = contenido;
                window.print();
                document.body.innerHTML = contenidoOriginal;
                despuesDeLaImpresion();
            }

            function despuesDeLaImpresion(){
                console.log('OK despuesDeLaImpresion');
                // $( "#razon_social" ).autocomplete({
                //     source: array_nombres,
                //     select: function(){
                //         var newTag = $(this).val();
                //     }
                // }).promise().done(function(){
                //     esperar_cambios_razon();
                // });
                //
                // $( "#producto" ).autocomplete({
                //     source: array_nombres_productos,
                //     select: function(){
                //         var newTag = $(this).val();
                //     }
                // }).promise().done(function(){
                //     esperar_cambios_producto();
                // });
            }

            //</editor-fold>

            //<editor-fold desc="Exportaciones">

            function exportTableToExcel(tableID, filename){
                var downloadLink;
                var dataType = 'application/vnd.ms-excel';
                var tableSelect = document.getElementById(tableID);
                var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

                // Specify file name
                filename = filename?filename+'.xls':'excel_data.xls';

                // Create download link element
                downloadLink = document.createElement("a");

                document.body.appendChild(downloadLink);

                if(navigator.msSaveOrOpenBlob){
                    var blob = new Blob(['\ufeff', tableHTML], {
                        type: dataType
                    });
                    navigator.msSaveOrOpenBlob( blob, filename);
                }else{
                    // Create a link to the file
                    downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

                    // Setting the file name
                    downloadLink.download = filename;

                    //triggering the function
                    downloadLink.click();
                }
            }

            function exportPDF(div_id, filename) {
                var pdf = new jsPDF('p', 'pt', 'letter');
                // source can be HTML-formatted string, or a reference
                // to an actual DOM element from which the text will be scraped.
                source = $(div_id)[0];

                // we support special element handlers. Register them with jQuery-style
                // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
                // There is no support for any other type of selectors
                // (class, of compound) at this time.
                specialElementHandlers = {
                    // element with id of "bypass" - jQuery style selector
                    '#tablaReporteProveedores': function (element, renderer) {
                        // true = "handled elsewhere, bypass text extraction"
                        return true
                    }
                };
                margins = {
                    top: 10,
                    left: 10,
                    right: 10,
                    width: 500
                };
                // all coords and widths are in jsPDF instance's declared units
                // 'inches' in this case
                pdf.fromHTML(
                    source, // HTML string or DOM elem ref.
                    margins.left, // x coord
                    margins.top, { // y coord
                        'width': margins.width, // max width of content on PDF
                        'elementHandlers': specialElementHandlers
                    },

                    function (dispose) {
                        // dispose: object with X, Y of the last line add to the PDF
                        //          this allow the insertion of new lines after html
                        pdf.save(filename+'.pdf');
                    }, margins);
            }

            //</editor-fold>


            function onchange_estante(){
                var estante_id = $('#estante_id').val();
                var deposito_id = $('#deposito_id').val();
                $.ajax({
                    url: "{{ route('stock.existencia.paginadoAjax') }}",
                    data: {deposito_id: deposito_id, estante_id: estante_id },
                    success:function (data){
                        console.log(data);
                        $('#datos_tabla').html(data);
                        //paginadoAjaxDeposito(this.value)
                        //despuesDelAjax(deposito_id);
                    }
                });
            }

            function buscarArticulos(){
                var deposito_id = $('#deposito_id').val();
                var busqueda = $('#buscar_articulos').val();
                $.ajax({
                    url: "{{ route('stock.existencia.paginadoAjax') }}",
                    data: {deposito_id: deposito_id, busqueda: busqueda },
                    success:function (data){
                        console.log(data);
                        $('#datos_tabla').html(data);
                    }
                });
            }

            //
            // function despuesDelAjax(deposito_id){
            //     $('.paginado_filtro').on('click', '.pagination a', function(event){
            //         event.preventDefault();
            //         //alert('ok');
            //         //console.log('deposito_id: '+deposito_id);
            //         var page = $(this).attr('href').split('page=')[1];
            //         paginadoAjaxDeposito(page, deposito_id);
            //     });
            // }

            {{--function paginadoAjaxDeposito(page, deposito_id){--}}
            {{--    $.ajax({--}}
            {{--        url: "{{route('stock.existencia.filtro')}}"+'?page='+page,--}}
            {{--        data: {deposito_id: deposito_id},--}}
            {{--        success:function (data){--}}
            {{--            $('#datos_tabla').html(data);--}}
            {{--        }--}}
            {{--    });--}}
            {{--}--}}


function onchange_deposito(){
    var deposito_id = $('#deposito_id').val();
    var estante_id = $('#estante_id').val();
    $.ajax({
        url: "{{ route('stock.existencia.paginadoAjax') }}",
        data: {deposito_id: deposito_id, estante_id: estante_id },
        success:function (data){
            console.log(data);
            $('#datos_tabla').html(data);
            //paginadoAjaxDeposito(this.value)
            //despuesDelAjax(deposito_id);
        }
    });

};
$("#entidad_id").change(function() {
    var entidad_id = $(this).val();
    var deposito_id = $('#deposito_id').val();
    var estante_id = $('#estante_id').val();
      $.ajax({
        type:"GET",
        url: "{{ route('stock.existencia.paginadoAjax') }}",
        type: 'GET',
        data: {id:sucursal},

        success: function(rta){
          console.log(rta);
          $('#caja_timbrado option').remove().promise().done(function(){
            $.each(rta, function(i, item) {
            $("#caja_timbrado").append("<option value="+item.id+">"+item.name+"</option>");

          });
  });
          
          
          
        }
      }).fail( function( jqXHR, textStatus, errorThrown ) {
            if (jqXHR.status === 0) {
                console.log('Not connect: Verify Network.');
            } else if (jqXHR.status == 404) {
                console.log('Requested page not found [404]');
            } else if (jqXHR.status == 500) {
                console.log('Internal Server Error [500].');
            } else if (textStatus === 'parsererror') {
                console.log('Requested JSON parse failed.');
            } else if (textStatus === 'timeout') {
                console.log('Time out error.');
            } else if (textStatus === 'abort') {
                console.log('Ajax request aborted.');
            } else {
                console.log('Uncaught Error: ' + jqXHR.responseText);
            }
        }).promise().done(function(){
            console.log('data tableando');
        });
    });

$("#sucursal_id").change(function() {
      var sucursal = $(this).val()
      $.ajax({
        type:"GET",
        url: "{{route('get_data')}}",
        type: 'GET',
        data: {id:sucursal},

        success: function(rta){
          console.log(rta);
          $('#caja_timbrado option').remove().promise().done(function(){
            $.each(rta, function(i, item) {
            $("#caja_timbrado").append("<option value="+item.id+">"+item.name+"</option>");

          });
  });
          
          
          
        }
      }).fail( function( jqXHR, textStatus, errorThrown ) {
            if (jqXHR.status === 0) {
                console.log('Not connect: Verify Network.');
            } else if (jqXHR.status == 404) {
                console.log('Requested page not found [404]');
            } else if (jqXHR.status == 500) {
                console.log('Internal Server Error [500].');
            } else if (textStatus === 'parsererror') {
                console.log('Requested JSON parse failed.');
            } else if (textStatus === 'timeout') {
                console.log('Time out error.');
            } else if (textStatus === 'abort') {
                console.log('Ajax request aborted.');
            } else {
                console.log('Uncaught Error: ' + jqXHR.responseText);
            }
        }).promise().done(function(){
            console.log('data tableando');
            //$("#table-analysis").DataTable();
        });
    });





$("#deposito_id").change(function() {
      var sucursal = $(this).val()
      $.ajax({
        type:"GET",
        url: "{{route('get_data')}}",
        type: 'GET',
        data: {id:sucursal},

        success: function(rta){
          console.log(rta);
          $('#caja_timbrado option').remove().promise().done(function(){
            $.each(rta, function(i, item) {
            $("#caja_timbrado").append("<option value="+item.id+">"+item.name+"</option>");

          });
  });
          
          
          
        }
      }).fail( function( jqXHR, textStatus, errorThrown ) {
            if (jqXHR.status === 0) {
                console.log('Not connect: Verify Network.');
            } else if (jqXHR.status == 404) {
                console.log('Requested page not found [404]');
            } else if (jqXHR.status == 500) {
                console.log('Internal Server Error [500].');
            } else if (textStatus === 'parsererror') {
                console.log('Requested JSON parse failed.');
            } else if (textStatus === 'timeout') {
                console.log('Time out error.');
            } else if (textStatus === 'abort') {
                console.log('Ajax request aborted.');
            } else {
                console.log('Uncaught Error: ' + jqXHR.responseText);
            }
        }).promise().done(function(){
            console.log('data tableando');
            //$("#table-analysis").DataTable();
        });
    });

        </script>

    @endsection
