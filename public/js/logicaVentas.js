
$('.select2').select2().trigger('change'); 
var generales;
cambioArticulo();
seccionDetalles();
seccionMetodosPagos();
MediosPagos();
eliminarServicio();
//generales
function manejoErrores(mesage,funcion,id){
    Swal.fire({
        title: mesage,
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar!'
      }).then((result) => {
        if (result.isConfirmed) {
            funcion.fun.apply(id)
        }
      })
}
//constantes generales
function azarDetalle(){
    var num_li = $('#formDatosDetalles #tabla-lista-detalles tbody').length + 1;
    num_li = (num_li * 1000) + getRandomArbitrary(1, 100);
    return num_li
}
function azarMedio(){
    var num_li = $('#formMedios #seccion_add').length + 1;
    num_li = (num_li * 1000) + getRandomArbitrary(1, 100);
    return num_li
}

const ItemDetalles = ({ num_li=azarDetalle(),optionsC,optionsP}) => `
<tr class="fila_producto">
    <td style="width:5%">
    <button class="btn btn-danger" id="remove_detalles"  type="button">
            <i class="fa fa-trash" aria-hidden="true"></i>
    </button>
    <input type="hidden" id="detalle_iva" name="detalles[${num_li}][iva]">
    <input type="hidden" id="es_promo" name="detalles[${num_li}][es_promo]">
    <input type="hidden" id="es_combo" name="detalles[${num_li}][es_combo]">
    <input type="hidden" id="combinacion" name="detalles[${num_li}][combinacion]">
    </td>
    <td style="width:5%">
        <input type="text" class="form-control siempreCero text-right" value="0" id="detalles-cantidad" name="detalles[${num_li}][cantidad]">
    </td>
        <td style="width:30%">
            <select id="producto_id" class="select2 form-control" style="width: 100%"  name="detalles[${num_li}][articulo]">
                <option value="0" selected disabled>Elija un producto o Combo</option>
                <optgroup label="Productos">
                    ${optionsP}
                </optgroup>
                <optgroup label="Combos">
                    ${optionsC}
                </optgroup>
            </select>
        </td>
    <td>
        <input type="text" class="form-control  formatogs text-right" value="0" id="detalles-precio"  name="detalles[${num_li}][precio]">
    </td>
    <td>
        <input type="text" class="form-control" value="0" readonly value="${optionsP}" id="detalles-excenta" >
    </td>
    <td>
        <input type="text" class="form-control" value="0" readonly id="detalles-cinco">
    </td>
    <td>
        <input type="text" class="form-control" value="0" readonly id="detalles-diez">
    </td>
</tr>
`;
const ItemMetodos = ({ num_li=azarMedio(), optionsm,optionsb,optionsc,}) => `
<div class="form-row mb-1 fila_medio">
<div class="col-1">
    <select class="form-control select2" id="met_medio" 
        style="width: 100%; font-size: 20px !important;" name="medios[${num_li}][medio]">
        <option value="0" selected disabled >Seleccione</option>
        ${optionsm}
    </select>
</div>
<div class="col-2">
    <select class="form-control select2 desabilitar" id="met_banco" 
        style="width: 100%; font-size: 20px !important;" disabled name="medios[${num_li}][banco]">
        <option value="0" selected>Bancos</option>
        ${optionsb}
    </select>
</div>
<div class="col-2">
    <select class="form-control select2 desabilitar" id="met_cuenta" 
        style="width: 100%; font-size: 20px !important;" disabled name="medios[${num_li}][cuenta]">
        <option value="0" selected>Cuenta</option>
        ${optionsc}
    </select>
</div>
<div class="col-1">
    <select class="form-control" id="met_tarjeta desabilitar" 
        style="width: 100%; font-size: 20px !important;" disabled name="medios[${num_li}][tarjeta]">
        <option value="0" selected>Tarjetas</option>
    </select>
</div>
<div class="col-2">
    <input id="met_documento" type="text" class="form-control col-12 desabilitar siempreCero " placeholder="N°"
         disabled name="medios[${num_li}][documento]">
</div>
<div class="col-1">
    <input id="met_monto" placeholder="Monto" name="medios[${num_li}][importe]" type="text" value='0' class="form-control formatogs text-right" >

</div>
<div class="col-1">
    <input id="met_fecha_ini" type="date" class=" form-control col-12 desabilitar" disabled name="medios[${num_li}][inicio]">
</div>
<div class="col-1">
    <input id="met_fecha_fin" type="date" class=" form-control col-12 desabilitar" disabled name="medios[${num_li}][fin]">
</div>
<div class="col-1">
    <button type="button" class="btn btn-danger quitar" title="Eliminar Metodo"  ><i class="fas fa-minus"></i></button>
</div>
</div>
`;
const ItemPromos = ({ promo_name,detalle_promo,promo_id}) => `
    <div class="form-row mb-1 border .promo_" id="promo_${promo_id}" promo="${promo_id}">
        <div class="col-4 border">
            ${promo_name}
        </div>
        <div class="col-6 border">
            ${detalle_promo}
        </div>
        <div class="col-2">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="buton_promo_${promo_id}" promo="${promo_id}" >
            <label class="form-check-label">
               Marque aqui
            </label>
        </div>
        </div>
    </div>
`;
//seccion metodos pagos
function seccionMetodosPagos(){
    $("#formMedios #añadir").click(function() {
        var optionsm="";
        var optionsb="";
        var optionsc="";
        var op={};
        medios_js.map(function(x) {
            if (x.name != 'Efectivo') {
                optionsm+="<option value='"+x.id+"'> "+x.name+" </option>";
            }
        });
        bancos_js.map(function(x) {
            optionsb+="<option value='"+x.id+"'> "+x.name+" </option>";
        });
        cuentas_js.map(function(x) {
            optionsc+="<option value='"+x.id+"'> "+x.name+" </option>";
        });
        op.optionsm=optionsm; op.optionsb=optionsb; op.optionsc=optionsc; 
        $('#formMedios #seccion_add').append([op].map(ItemMetodos).join(''));
    });
}
$(document).on("change", "#timbrado_id", function(){
    var factura="";
    timbrados_js.map(function(x) {
        if ($('#timbrado_id').val() == x.timbrado_id) {
            var fac_actual= x.factura_actual + 1;
            // factura =''+ajustarFac(2,x.sucursal_id)+'-'+ajustarFac(2,x.punto_de_venta_id)+'-'+ajustarFac(6,fac_actual);
            factura =ajustarFac(6,fac_actual);
        }
    });
    $('#numero_timbrado').val(factura);
    $('#numero_timbrado_real').val(factura);
})
$(document).on("keyup", ".formatogs", function(){
    getFormatGS(this)
})
function getFormatGS(input)
{
    var num = input.value.replace(/\./g,'');
    if (num) {
        if(!isNaN(num)){
            if ((input.value.length == 2) && (input.value[0] == 0) ){
                input.value = input.value.replace(/^0+/, '');
                num = input.value.replace(/\./g,'');
            }
            num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
            num = num.split('').reverse().join('').replace(/^[\.]/,'');
            input.value = num;
        }else{
            input.value = input.value.replace(/[^\d\.]*/g,'');
            if(input.value.trim() == ''){
                input.value = 0;
            }
        }
    }else{
        input.value = 0;
    }
}
function puntear(num){
    num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
    num = num.split('').reverse().join('').replace(/^[\.]/,'');
    return num;
}
function MediosPagos(){
    /*esta funcion sirve para cuando se cambie el inpu a tajeta o banco pregunte por el numero*/
    $(document).on("change", "#formMedios select[id^='met_medio']", function(){
        $(this).closest( ".fila_medio" ).find("input[id='met_monto']").val()
        var ele = medios_js.find( item => item.id == this.value );
        //deberiasmos bloquear todo y sola mente dejar lo que se va a utilizar
        $(this).closest( ".fila_medio" ).find(".desabilitar" ).attr('disabled',true);

        $(this).closest( ".fila_medio" ).find('#met_documento').attr('placeholder',ele.documento);
        if (ele.requiere_numero == true) {
                $(this).closest( ".fila_medio" ).find('#met_documento').attr('disabled',false);
        }
        if (ele.requiere_fecha == true) {
                $(this).closest( ".fila_medio" ).find('#met_fecha_ini').attr('disabled',false);
                $(this).closest( ".fila_medio" ).find('#met_fecha_fin').attr('disabled',false);
        }    
        if (ele.requiere_banco == true) {     
                $(this).closest( ".fila_medio" ).find('#met_banco').attr('disabled',false);
        }
        if (ele.requiere_marca == true) {     
                $(this).closest( ".fila_medio" ).find('#met_tarjeta').attr('disabled',false);
        }   
        if (ele.requiere_cuenta == true) {  
                $(this).closest( ".fila_medio" ).find('#met_cuenta').attr('disabled',false);
        }
    });
    $(document).on("click", "#formMedios .quitar", function(){
            var indice= $(this).closest( ".fila_medio" );
                    const remo = {
                    fun: function() {
                        indice.remove();
                        CalculosDetalles()
                    }
                }
            var message="Desea eliminar este Medio de Pago";
            manejoErrores(message,remo,indice)
    });
}
$("#modal_medios_pagos").on("hidden.bs.modal", function () {
    calcularImporte();
})
//clietes
$("#form-cliente #cliente_id" ).on({
    change:function(){
        var ele = personas_js.find( item => item.id == this.value );
        $("#form-cliente #persona_name" ).val(ele.name);
        $("#form-cliente #persona_direcion" ).val(ele.direccion);
        $("#form-cliente #persona_telefono" ).val(ele.telefono);
    },
});
//detalles
function seccionDetalles(){}
$("#add_detalles_venta").click(function() {
    var optionsP="";
    var optionsC="";
    var op={};
    articulos_js.map(function(x) {
        if (x.tipo == 'producto') {
            optionsP+="<option value='"+x.id+"'> "+x.name+" </option>";
        }else if (x.tipo == 'combo') {
            optionsC+="<option value='"+x.id+"'> "+x.name+" </option>";
        }
    });
    op.optionsC=optionsC; op.optionsP=optionsP; 
    $('#formDatosDetalles #tabla-lista-detalles').append([op].map(ItemDetalles).join(''));
});
function cambioArticulo(){
//cantidad
$(document).on("change", "#formDatosDetalles input[id^='detalles-cantidad']", function(){
        CalculosDetalles();
}); 
    //articulo
    $(document).on("change", "#formDatosDetalles select[id^='producto_id']", function(){
            //el indice se refiere a el lugar de donde se esta necesitando los datos
            var indice= $(this).closest( ".fila_producto" );
            var ele = articulos_js.find( item => item.id == this.value );
            if (ele.existencia.length == 0) {
                if ($('#cargando').val() == 'no') {
                    Swal.fire('ATENCION.! Este articulo no posee existencia', "", 'warning'); 
                }
            }
            if (ele.tipo == "combo") {//si es combo no importe si es promo se inserta todo
                comboArticulos(this.value,indice)
            }else{
                if (promos_js.cod == 200) {
                    var ar_pr=promos_js.data.ar_c_pr;
                    const found = ar_pr.find(element => element == this.value);
                    if (found) {//si existe una promo se la enseñamos
                        generales=indice
                        $("#modal_promos #precio").val(ele.precio); 
                        $("#modal_promos #iva").val(ele.iva);
                        promoArticulos(this.value,'producto');
                    }else{
                        insertProduc(indice,ele);
                    }
                }else{
                    insertProduc(indice,ele);
                }
            }
    }); 
    //precio
    $(document).on("change", "#formDatosDetalles input[id^='detalles-precio']", function(){
        CalculosDetalles();
    }); 
    //remove
    $(document).on("click", "#formDatosDetalles button[id^='remove_detalles']", function(){
        var indice= $(this).closest( ".fila_producto" );
        const remo = {
            fun: function() {
                indice.remove();
                CalculosDetalles();
            }
        }
        var message="Desea eliminar este item";
        manejoErrores(message,remo,indice)   
    }); 
}
function insertProduc(indice,ele){
    indice.find("input[id='detalles-precio']").val(puntear(ele.precio))//aqui va con puntos
    indice.find("input[id='detalle_iva']").val(ele.iva)
    CalculosDetalles();
}
function CalculosDetalles(){
    var total=0;
    var TE=0; 
    var T5=0; 
    var T10=0;
    $('#formDatosDetalles #tabla-lista-detalles tr').each(function(e,data) {
        var cant= parseInt($(this).find("input[id='detalles-cantidad']").val());
        var prec= parseInt( $(this).find("input[id='detalles-precio']").val().replace(/\./g,'') );
        var art= $(this).find("select[id='producto_id']").val();
        if(!isNaN(cant)){
            if(!isNaN(prec)){
                if (art != null) {
                    var ele = articulos_js.find( item => item.id == art );
                    total= total + (cant * prec);
                    if (ele.iva == 10) {
                         T10= T10 + (cant * prec);
                         $(this).find("input[id='detalles-diez']").val((cant * prec))
                    }else if (ele.iva == 5) {
                         T5= T5 + (cant * prec);
                         $(this).find("input[id='detalles-cinco']").val((cant * prec))
                    }else if (ele.iva == 0) {
                         TE= TE + (cant * prec);
                         $(this).find("input[id='detalles-excenta']").val((cant * prec))
                    }
                }else{
                    $(this).find("select[id='producto_id']").focus();
                }
            }else{ 
                $(this).find("input[id='detalles-precio']").focus();
            }
        }else{
            $(this).find("input[id='detalles-cantidad']").focus();
        }   
    })
    //for servicios solo sumamos si alguno de los dos existe
    $('#formServicios #tabla-lista tbody tr').each(function(e,data) {
        var cant= parseInt($(this).find("input[id='cantidad_servicio']").val());
        var prec= parseInt($(this).find("input[id='precio_servicio']").val().replace(/\./g,''));
        var art= $(this).find("input[id='cantidad_servicio']").attr('servicio');
        if(!isNaN(cant)){
            if(!isNaN(prec)){
                if (art != null) {
                    var ele = articulos_js.find( item => item.id == art );
                    total= total + (cant * prec);
                    if (ele.iva == 10) {
                         T10= T10 + (cant * prec);
                    }else if (ele.iva == 5) {
                         T5= T5 + (cant * prec);
                    }else if (ele.iva == 0) {
                         TE= TE + (cant * prec);
                    }
                }
            }
        }  
    })

    if ($('#formResumen #seccion_descuento').css('display') == 'block') {//descuento
        var descuento= total - parseInt($("#descuentoDado").val())
        $("#formResumen #total-pagar" ).text(descuento)
        $("#formResumen #iva-total" ).text((iva5(T5) + iva10(T10) ));
    }else{
        $("#formResumen #total-pagar" ).text(total)
        $("#formResumen #iva-total" ).text((iva5(T5) + iva10(T10) ));
    }
    $("#formResumen #sub-ex" ).text(TE)
    $("#formResumen #sub-5" ).text(T5)
    $("#formResumen #sub-10" ).text(T10)
    $("#formResumen #iva-5" ).text(iva5(T5))
    $("#formResumen #iva-10" ).text(iva10(T10))

}
function vaciarModal(){
    $('#ruc_persona').val("")
    $('#name_persona').val("")
    $('#nombre_fantasia_persona').val("")
    $('#direccion_persona').val("")
    $('#telefono_persona').val("")
    $('#email_persona').val("")
}
//seccion de servicios
function azarServis(){
    var num_li = $('#formServicios #tabla-lista tbody').length + 1;
    num_li = (num_li * 1000) + getRandomArbitrary(1, 100);
    return num_li
}
const ItemServicios = ({num_li=azarServis(), fecha,optionsm,servicio,desde,hasta,precio_actual,servicio_id,iva,porcentaje_colaborador=30,precio_real,imp=0,imd=0,read,tama=6,display='style="display: block"'}) => `
<tr class="servicio_datos">
            <td>
                <input type="hidden"  value="1" servicio="${servicio_id}" id="cantidad_servicio" name="servis[${num_li}][cantidad]">
                <input type="hidden"  name="servis[${num_li}][servicio]" value='${servicio_id}'>
                <input type="hidden"  name="servis[${num_li}][iva]" value="${iva}">
                <input type="hidden" id="es_promo" name="servis[${num_li}][es_promo]">
                <input type="hidden" id="es_combo" name="servis[${num_li}][es_combo]">
                <input type="hidden" id="combinacion" name="servis[${num_li}][combinacion]"> ${fecha}
            </td>
            <td>
                <select id="colaborador_id" class="select2 form-control" style="width: 100%"  name="servis[${num_li}][colaborador_id]" ${read}>
                    <optgroup label="Colaboradores">
                    ${optionsm}
                    </optgroup>
                </select>
            </td>
            <td>${servicio}</td>
            <td style="width:7%" >
                <input type="text" class="form-control  siempreCero" value="${porcentaje_colaborador}" id="porcentaje_" name="servis[${num_li}][porcentaje]" readOnly>
            </td>
            <td>
                <input type="time" class="form-control"  value="${desde}" id="servicio_ini_" name="servis[${num_li}][ini]" ${read}>
            </td>
            <td style="width:15%" class="border">
            <div class="form-row">
                <div class="col-${tama}" id="spiner_c">
                    <input type="time" class="form-control"  value="${hasta}" id="servicio_fin_" name="servis[${num_li}][fin]" ${read}> 
                </div>
                <div class="col-2" ${display} id="spiner_a">
                    <div class="spinner-grow spinner-grow-sm text-info" role="status"> 
                    </div>
                </div>
                <div class="col-3" ${display} id="spiner_b">
                    <a class="btn btn-primary" id="verificar_hora" onclick="verificar_hora(this)" title="Necesita Confirmar Horario" ><i class="fas fa-clock"></i></a>
                </div>
            </div>
            </td>
            <td>
                <input type="text" class="form-control formatogs text-right" value="${precio_actual}" id="precio_servicio"  name="servis[${num_li}][precio]">
                <input type="hidden"  value="${precio_real}" id="precio_real"  name="servis[${num_li}][precio_real]">
                <input type="hidden" class="form-control  text-right"  id="importe_descuento" value="${imd}"  name="servis[${num_li}][importe_descuento]">
                <input type="hidden" class="form-control  text-right"  id="importe_porcentaje"  value="${imp}" name="servis[${num_li}][importe_porcentaje]">
            </td>
            <td style="width:5%" >
                <input type="text" class="form-control"  id="descuento_ser" value="${imp}%" readOnly>
            </td>
            <td>
                <button type="button" class="btn btn-danger quitarser" ><i class="fas fa-trash-alt"></i></button>
                <button type="button" class="btn btn-primary" onclick="abrirModalDescuento(this)"><i class="fas fa-percent"></i></button>
            </td>
    </tr>
`;
$('#formServicios #servicio_id').on('change', function(){
    var id = $(this).val();
    if( id != 'null' ){
      var ele = articulos_js.find( item => item.id == id  );
      var dt = new Date(); var time = dt.getHours() + ":" + dt.getMinutes();
      var time = dt.getHours() + ":" + dt.getMinutes();
      $('#formServicios #ini_show').val(time);
      $('#formServicios #precio_servicio_g').val(ele.precio);
      sumHours(time,ele.end,'#formServicios #ini_show','#formServicios #fin_show','#formServicios #duracion_show')
    }else{
        console.log('vacio');
    }
});

$(document).on("change", "#formServicios input[id^='porcentaje_']", function(){
    if ($(this).val() >  100) {
        $(this).val(100)
    }else if ($(this).val() < 0) {
        $(this).val(0)
    }
}); 


$('#formServicios #ini_show').on('change', function(){
    var id = $('#formServicios #servicio_id').val();
    console.log(id);
    if( id != 'null' ){
      var ele = articulos_js.find( item => item.id == id  );
      sumHours($(this).val(),ele.end,'#formServicios #ini_show','#fin_show','#formServicios #duracion_show')
    }else{
      $('#formServicios #servicio_id').focus();
    }
});
function agregraDetalle(){
    if (reglas()) {
        disponibilidad();
      }  
}
function eliminarServicio(){
    $(document).on("click", "#formServicios .quitarser", function(){
        var indice= $(this).closest( ".servicio_datos" );
        const remo = {
            fun: function() {
                indice.remove();
                CalculosDetalles()
            }
        }
        var message="Desea eliminar este servicio";
        manejoErrores(message,remo,indice)
    });
}
  
function reglas(){
if (($('#formServicios #colaborador_id').val() == 'null')){
    toadErrores('Necesita seleccionar un colaborador')
    return false;
}else if(($('#formServicios #servicio_id').val() == 'null')){
    toadErrores('Necesita seleccionar un servicio')
    return false;
}else if($('#formServicios #ini_show').length === 0 ){
    toadErrores('Necesita seleccionar un Horario i')
    return false;
}else if(($('#formServicios #fin_show').length === 0 )){
    toadErrores('Necesita seleccionar un Horario f')
    return false;
}else if (!($('#fecha').val())) {
    toadErrores('Necesita seleccionar una Fecha')
}else{
    return true
}
}
function reset(){
$('#formServicios #ini_show').val("");
$('#formServicios #fin_show').val("");
$('#formServicios #duracion_show').val("");
$('#formServicios #servicio_id').val('null');
$('#formServicios #servicio_id').trigger('change'); 
$('#formServicios .reset_').val('null');
$('#formServicios .reset_').trigger('change');
}
//aplicar Promo
$("#aplicar_promo ").on({
    click:function(e){
        e.preventDefault();
        var no=false; var promo="";
        $('#seccion_promos input').each(function(e,data) {
           if ($(this).prop('checked')) {
               promo = $(this).attr('promo'); no=true;
           }
        }).promise().done(function(){
            if (!no) {
                toadErrores("POR FAVOR SELECCIONA UNA PROMO ANTES DE CONTINUAR..!")
            }else{
                $("#aplicar_promocion").val('si')
                insertarPromos(promo);
            }
        })
    },
});
function comboArticulos(arti,indice){
    indice.remove();
    var com=combos_js.data.combo;
    com.map(function(x){
        if (x.id == arti) {
            var numero_azar = $('#formServicios #tabla-lista tbody').length + 1;
            numero_azar = (numero_azar * 1000) + getRandomArbitrary(1, 100);

            x.combo_articulos.map(function(y){
                console.log(y);
                var ele = articulos_js.find( item => item.id == y.articulo_id);
                if (ele.tipo == 'producto'){
                    $("#add_detalles_venta").click();
                    var ultimo=$('#formDatosDetalles #tabla-lista-detalles tr').last()
                    ultimo.find("select[id='producto_id']").val(ele.id)
                    ultimo.find("input[id='detalles-precio']").val(puntear(y.precio_combo)) //aqui va con puntos
                    ultimo.find("input[id='detalles-cantidad']").val(y.cantidad)
                    ultimo.find("input[id='detalle_iva']").val(ele.iva)
                    numeroAzar('pro',ultimo,arti,'combo',numero_azar)
                }else if (ele.tipo == 'servicio'){
                    insertarServiceVacio(ele.id,arti,'combo',numero_azar)
                }
            });
            //alerta de insercion
            toastr.options = { "closeButton": true, };
            toastr.success('Combo asignado', 'Buen Trabajo!');
        }
    });
    //podria ser todos combos de servicios asi que hay que prever que no quede vacio o queda feo
    if ($('#formDatosDetalles #tabla-lista-detalles tr').length == 0) {
        $("#add_detalles_venta").click();
    }
    CalculosDetalles()
    $("#modal_promos").modal('hide');
}
function getRandomArbitrary(min, max) {
    return Math.round(Math.random() * (max - min) + min);
}
function numeroAzar(tipo,local,vari,tipo2,random){
    //tipo= producto o servicio //local =ubicacion del tr //viari= el id del combo o promo //tipo dos si entro como combo o promo 
    //random= el numero aleatorio para identificar
    if (tipo == "ser") {//esta en servicio       
        if(tipo2 == "combo"){
            $('es_combo')
            local.find("[id='es_combo']").val(vari)   
            local.find("[id='combinacion']").val(random)          
        }else if(tipo2 == "promo"){
            local.find("[id='es_promo']").val(vari)
            local.find("[id='combinacion']").val(random)
        }
    }else{ //esta en los productos
        if(tipo2 == "combo"){
            local.find("[id='es_combo']").val(vari)
            local.find("[id='combinacion']").val(random)
        }else if(tipo2 == "promo"){
            local.find("[id='es_promo']").val(vari)
            local.find("[id='combinacion']").val(random)
        }
    }
}
function promoArticulos(arti,tipo){
    $('#seccion_promos').empty();
    $('#tipo_promo').val(tipo);
   
    var pro=promos_js.data.promos;
    pro.map(function(x) {
        var det="";
        var op={};
        var promo_id= x.articulos.find( item => item == arti );
        if (promo_id) {
        x.promo_articulos.map(function(y) {
            var ele = articulos_js.find( item => item.id == y.articulo_id);
            det+='<div class="form-row mb-1"><div class="col-4 border">'+y.cantidad+'</div> <div class="col-4 border">'+ele.name+'</div> <div class="col-4 border">'+y.precio_promo+'</div> </div>';
        });
        op.promo_id=x.id
        op.promo_name=x.name
        op.detalle_promo=det;
        $('#modal_promos #seccion_promos').append([op].map(ItemPromos).join(''));
        }
    });


    if ($('#cargando').val() == 'no') {
        $('#modal_promos').modal('show');
    }
   
}
$("#modal_promos").on("hidden.bs.modal", function () {
        console.log($("#aplicar_promocion").val());
        if ($("#aplicar_promocion").val() == 'no') {
            if ($('#tipo_promo').val() == 'servicio') {
                insertarService('')
            }else if ($('#tipo_promo').val() == 'producto') {
                var ind =generales;
                var ele={};
                ele.precio= $("#modal_promos #precio").val();
                console.log(ele);
                ele.iva =  $("#modal_promos #iva").val();
                insertProduc(ind,ele);
            }
        }    
    CalculosDetalles()
})
function insertarPromos(promo){
    var pro=promos_js.data.promos;
    var ind=generales;
    //este solo se debe remover si es necesadio
    if (ind) {
        ind.remove();
    }
    pro.map(function(x){
        if (x.id == promo) {
            var numero_azar = $('#formServicios #tabla-lista tbody').length + 1;
            numero_azar = (numero_azar * 1000) + getRandomArbitrary(1, 100);

            x.promo_articulos.map(function(y){
                var ele = articulos_js.find( item => item.id == y.articulo_id);
                if (ele.tipo == 'producto'){
                    $("#add_detalles_venta").click();
                    var ultimo=$('#formDatosDetalles #tabla-lista-detalles tr').last()
                    ultimo.find("select[id='producto_id']").val(ele.id)
                    ultimo.find("input[id='detalles-precio']").val(puntear(y.precio_promo))//aqui va con puntos
                    ultimo.find("input[id='detalles-cantidad']").val(y.cantidad)
                    ultimo.find("input[id='detalle_iva']").val(ele.iva)
                    numeroAzar('pro',ultimo,promo,'promo',numero_azar)
                }else if (ele.tipo == 'servicio'){
                    insertarServiceVacio(ele.id,promo,'promo',numero_azar)
                }
            });
        }
    });
    CalculosDetalles()
    $("#modal_promos").modal('hide');
    setTimeout(function(){$("#aplicar_promo").val('no')},2000);
}
function insertarServiceVacio(id,i_d,tipo,numero_azar){
    var ele = articulos_js.find( item => item.id == id  );
    ele.fecha= $('#fecha').val();
    ele.desde='';
    ele.hasta='';
    ele.colaborador_id='';
    ele.servicio= ele.name;
    ele.servicio_id= ele.id;
    ele.precio_actual= puntear(ele.precio);//aqui va con puntos
    ele.precio_real=puntear(ele.precio);
    var optionsm="";
    colaboradores_js.map(function(c){ 
        optionsm+="<option value='"+c.id+"'> "+c.name+" </option>";
    });
    ele.optionsm=optionsm;
    $('#formServicios #tabla-lista tbody').append([ele].map(ItemServicios).join(''));
    var ultimo=$('#formServicios #tabla-lista tbody tr').last()
    numeroAzar('ser',ultimo,i_d,tipo,numero_azar)
    CalculosDetalles()
}
function calcularImporte(){
    //debe ser para servicios y para productos
    var total= 0;
    $('#modal_medios_pagos #formMedios .fila_medio').each(function(e,data){
        var imort=  parseInt($(this).find("input[id='met_monto']").val().replace(/\./g,''));
        if(!isNaN(imort)){
            total= total + parseInt(imort);
        }else{
            $('#modal_medios_pagos').modal('show');
            $(this).find("input[id='met_monto']").focus();
            toadErrores('Necesita asignar un importe','')
        }
    });
    $("#input-total-fuera" ).val(total)

}

function logicaDescuentos(){
    $(document).on("change", "#descuento_efectivo_modal", function(){
       
        var totalidad=parseInt( $("#descuento_real").val().replace(/\./g,''));
        var total=0
        var valides= $(this).val().replace(/\./g,'');
        if (($(this).val() >  totalidad)) {
            valides= totalidad
            $("#formResumen  #descuento_efectivo_modal").val(totalidad)
        }
        total=( 100 * valides ) / totalidad;
        $("#descuento_porcentaje_modal").val(Math.round(total))
        
    })
    $(document).on("change", "#descuento_porcentaje_modal", function(){
        var totalidad=parseInt( $("#descuento_real" ).val());
        var total=0
        var valides=$(this).val();
        if ($(this).val() >  100) {
            valides= 100
            $("#descuento_porcentaje_modal").val(100)
        }
        total= (totalidad * valides ) / 100;
        $("#descuento_efectivo_modal").val(total)       
    }); 
}
function abrirModalDescuento(lugar){
    var to=$(lugar).closest( ".servicio_datos" ).find("input[id='precio_real']").val().replace(/\./g,'');
    var po=$(lugar).closest( ".servicio_datos" ).find("input[id='importe_porcentaje']").val().replace(/\./g,'');
    //preguntamos si ya tiene un descueno
   $('#tabla_descuento_general #descuento_real').val(to)
   $('#tabla_descuento_general #descuento_porcentaje_modal').val(po)
   $('#tabla_descuento_general #descuento_porcentaje_modal').trigger('change')
   descuento_mometaneo=lugar;
   $('#modal_descuentos').modal('show')
}
function aplicarDescuento(){
    var modal_p=$('#descuento_porcentaje_modal').val().replace(/\./g,'')
    var modal_e=$('#descuento_efectivo_modal').val().replace(/\./g,'')
    var to=$(descuento_mometaneo).closest( ".servicio_datos" ).find("input[id='precio_real']").val().replace(/\./g,'');

    $(descuento_mometaneo).closest( ".servicio_datos" ).find("input[id='precio_servicio']").val(puntear(to - modal_e));

    $(descuento_mometaneo).closest( ".servicio_datos" ).find("input[id='importe_porcentaje']").val(modal_p);
    $(descuento_mometaneo).closest( ".servicio_datos" ).find("input[id='importe_descuento']").val(modal_e);

    $(descuento_mometaneo).closest( ".servicio_datos" ).find("input[id='descuento_ser']").val(modal_p+"%");

    $('#modal_descuentos').modal('hide')
    CalculosDetalles()
}