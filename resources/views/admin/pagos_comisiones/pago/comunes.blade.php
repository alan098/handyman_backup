<div class="modal fade" id="compraDetalles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #4e73df; color: white;">
                <h5 class="modal-title">Detalles de la compra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background: red; border: solid red;">
                    <span style="color: white;" aria-hidden="true" id="close_modal_2">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" id="datos_proveedor"></div>
                <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Código de producto</th>
                            <th scope="col">Artículo</th>
                            <th scope="col">Código de barra</th>
                            <th scope="col">Precio Unitario</th>
                            <th scope="col">Excenta</th>
                            <th scope="col">Gravada 5%</th>
                            <th scope="col">Gravada 10%</th>
                            <th scope="col">Precio Total</th>
                        </tr>
                        </thead>
                        <tbody id="cuerpoCompraDetalles">

                        </tbody>
                    </table>
            </div>
            <div class="modal-footer" style="border-top: none;">
                <button type="button" class="btn btn-primary" id="close_modal" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<script>
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

    function verComprobante(e, p, r){
            $('#compraDetalles').modal('show');
            var id = e;
            var append = '';
            var proveedor = p;
            var ruc = r;
            $.ajax({
                type:"GET",
                url: "{{route('compras.listarComprasDetalles')}}",
                data: { id: id },
                success: function(data){
                    console.log(data);
                    if(data){
                        var cod_ba = '';
                        for (var i=0; i<data.length;i++){
                            var cod_ba = data[i].cod_barras;
                            if (cod_ba == null){
                                cod_ba = '';
                            }
                            append+='<tr>'+
                                // '<td>'+data[i].i+'</td>'+
                                /*'<td>'+'Gs. '+data[i].created_at+'</td>'+*/
                                '<td>'+parseInt(data[i].cantidad)+'</td>'+
                                '<td>'+data[i].cod_articulo+'</td>'+
                                '<td>'+data[i].articulo+'</td>'+
                                '<td>'+cod_ba+'</td>'+
                                '<td>'+'Gs. '+format(data[i].precio_unitario)+'</td>'+
                                '<td>'+'Gs. '+format(data[i].excenta)+'</td>'+
                                '<td>'+'Gs. '+format(data[i].gravada_5)+'</td>'+
                                '<td>'+'Gs. '+format(data[i].gravada_10)+'</td>'+
                                '<td>'+'Gs. '+format(data[i].precio_total)+'</td>'+
                                '</tr>',
                                $("#cuerpoCompraDetalles").empty();
                            $('#cuerpoCompraDetalles').append(append);
                        }
                        $('#datos_proveedor').html('' +
                            '<div class="col-md-2">\n' +
                            '<span> <p>Proveedor: <b>'+proveedor+'</b>  </p> </span>\n' +
                            '</div>\n' +
                            '<div class="col-md-2">\n' +
                            '<span><p>RUC: <b>'+ruc+'</b>  </p></span>\n' +
                            '</div>' +
                            '');
                    }
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
            });

            console.log(id);
        }

</script>
