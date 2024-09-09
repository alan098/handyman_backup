@extends('adminlte::page')
@section('title', 'Agendas')

@section('content_header')
@stop

@section('content')
    <div>
        @include('admin.calendar.stilos_calendarios')
        @include('admin.calendar.modalrecord')
        @include('admin.calendar.filtro')
    </div>
    @include('admin.calendar.calendarios')

    {{-- modales automaticos --}}
    <input type="hidden" id="sucursal_id" value="{{ Auth()->user()->sucursal_id }}">
    <input type="hidden" id="colaborador_id">
    @include('admin.calendar.modalreserva')
    @include('admin.calendar.modaleditar')
    @include('admin.calendar.modalpromo_combo')
    <br>
@stop

@section('js')
    <script src=" {{ asset('js/comunes.js') }} "></script>
    <script>
        $(document).ready(function() {
            //varibles genarales
            var ids_calendar = [];
            //la primera vez cargamos directo
            @php
                echo 'var servicios_ac = ' . json_encode($servicios) . '; ';
                echo 'var colaborador_js = ' . json_encode($colaboradores) . '; ';
                echo 'var colaborador_eve_js = ' . json_encode($colaboradoresEventos) . '; ';
                echo 'var defould_js = ' . json_encode($defould) . '; ';
            @endphp

            $('.select2').select2({
                dropdownParent: $('#formCrudModal')
            }).trigger('change');
            $('#articulo_pm').select2({
                dropdownParent: $('#promo_combo_edit')
            });
            //secion de changes
            $(document).on("change", "#fecha_principal", function() {
                console.log('alan')
                cambios_calendarios()
            })
            $("#seccion_sin_eventos [id^='marcados_']").change(function() {
                if (this.checked) {
                    $('.columna_colaborador_' + this.value).css('display', 'block')
                    $('.testimonial-group>.row>.columna_colaborador_'+this.value).css('display', 'inline-block')
                } else {
                    $('.columna_colaborador_' + this.value).css('display', 'none')
                }
            });

            function cambios_calendarios() {
                let ruta = '{{ route('admin.datos.rescar') }}' + '?fecha=' + $("#fecha_principal").val();
                getData(ruta).then(function(rta) {
                    if (rta.cod == 200) {
                        $('.columna_colaborador').css('display', 'block')
                        $('.testimonial-group>.row>.col-4').css('display', 'inline-block')
                        var longitud_da = ids_calendar.length;
                        ids_calendar.forEach(function callback(ele, index, array) {
                            //destruimos los calendarios y los volvemos a cargar
                            ele.id_cal.destroy()
                            if (index == (longitud_da - 1)) {
                                ids_calendar = []
                                colaborador_eve_js = rta.datos
                                cargar_Calendario()
                                ajustarCheck()
                            }

                        })
                    } else {
                        Swal.fire('Ocurrio un Error comuniquese con mantenimiento', "", 'error');
                    }
                }).catch(function(error) {
                    console.log('getData dio error');
                    console.log(error);
                    Swal.fire('Ocurrio un Error', error.message, 'error');
                });
            }
            //-----

            $('.js-data-clientes-ajax').select2({
                minimumInputLength: 2,
                minimumResultsForSearch: 10,
                dropdownParent: $('#formCrudModal'),
                ajax: {
                    url: '{{ route('admin.lista_reserva.clientes') }}',
                    dataType: "json",
                    type: "GET",
                    data: function(params) {
                        var queryParameters = {
                            term: params.term
                        }
                        return queryParameters;
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.text,
                                    id: item.id
                                }
                            })
                        };
                    }
                }
            });
            $('.js-data-clientes-ajax_two').select2({
                minimumInputLength: 2,
                minimumResultsForSearch: 10,
                dropdownParent: $('#promo_combo_edit'),
                ajax: {
                    url: '{{ route('admin.lista_reserva.clientes') }}',
                    dataType: "json",
                    type: "GET",
                    data: function(params) {
                        var queryParameters = {
                            term: params.term
                        }
                        return queryParameters;
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.text,
                                    id: item.id
                                }
                            })
                        };
                    }
                }
            });

            //scroll

            $(function() {
                $(".wrapper1").scroll(function() {
                    $(".wrapper2")
                        .scrollLeft($(".wrapper1").scrollLeft());
                });
                $(".wrapper2").scroll(function() {
                    $(".wrapper1")
                        .scrollLeft($(".wrapper2").scrollLeft());
                });
            });
            //promesas para cumplir  //cargar calendarios
            cargar_Calendario()

            function cargar_Calendario() {
                redit(colaborador_js).then(function(rta) {
                    colaborador_js.forEach(function callback(ele, index, array) {
                        if (ele.seleccionado == false) {
                            $('.columna_colaborador_' + ele.id).css('display', 'none')
                        }
                    })

                }).catch(function(error) {
                    console.log(error)
                    Swal.fire({
                        title: "Ocurrio un error comuniquese con soporte y mantenimiento",
                        icon: 'warning',
                        html: ""
                    });
                })
            }


            function redit(promesa) {
                var longitud_promesa = promesa.length;
                return new Promise(function(resolve, reject) {
                    promesa.forEach(function callback(ele, index, array) {
                        insertarFullcalendar(ele.id)
                        if (index == (longitud_promesa - 1)) {
                            resolve(true);
                        }
                    })
                })
            }


            function insertarFullcalendar(id) {
                var fecha = $('#fecha_principal').val();
                var calendarEl = document.getElementById('agenda_numero_' + id);
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'timeGridDay',
                    headerToolbar: {
                        left: 'prev,next,today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                    },
                    locale: "es",
                    editable: false,
                    themeSystem: 'bootstrap',
                    slotMinTime: "08:00:00",
                    slotMaxTime: "21:00:00",
                    slotDuration: '00:10:00',
                    allDaySlot: false,
                    slotLabelFormat: {
                        hour: '2-digit',
                        minute: '2-digit',
                        omitZeroMinute: false,
                        meridiem: 'short'
                    },
                    nowIndicator: true,
                    slotLabelInterval: '00:15:00',
                    contentHeight: "auto",
                    headerToolbar: false,
                    dateClick: function(info) {
                        var col = $(this)[0]['el']['attributes'][1].value;
                        comprobarBloqueo(info.dateStr, col)
                        limpiarModal(col)
                        addFechaModal('start', info.dateStr, 'formCrudModal')
                        addFechaModal('end', info.dateStr, 'formCrudModal')
                    },
                    eventClick: function(info) {

                        if (info.event.id) {
                            if (info.event.extendedProps.que_es == 'normal') {
                                populateModalEdit(info.event.id)
                            }else{
                                populateModalEditPM(info.event.id,info.event.extendedProps.evento_id)
                            }
                           
                        }
                    },
                });
                calendar.render()
                calendar.gotoDate(fecha)
                colaborador_eve_js.forEach(function callback(ele, index, array) {
                    if (ele.colaborador_id == id) {
                        // if (ele.block) {
                        // $(calendarEl).closest( ".columna_colaborador" ).css('max-width','30%')
                        // }
                        calendar.addEvent(ele)                        
                        //guardamos la referencia del calenadrio
                    }
                })
                ids_calendar.push({
                    'id_col': id,
                    'id_cal': calendar
                });

            }

            function comprobarBloqueo(hora, colaborador) {
                var ts = new Date(hora);
                fecha = ts.toUTCString();
                fecha = fecha.split(',')[0];
                datetext = ts.toTimeString();
                datetext = datetext.split(' ')[0];
                //en mantenimiento
                // let url = "{{ route('admin.fechear.rescar') }}" + "?hora=" + datetext + "&colaborador_id=" +
                //     colaborador +
                //     "&dia=" + fecha;
                // getData(url).then(function(rta) {
                //     if (rta.cod == 200) {
                        $('#formCrudModal').modal('show');
                //     } else {
                //         toastr.options = {
                //             "closeButton": true,
                //         };
                //         toastr.error("Colaborador con Horario Bloqueado", '');
                //     }
                // }).catch(function(error) {});
            }

            function limpiarModal(col) {
                $('#formCrudModal').trigger('reset');
                $('#formCrud #persona').val('')
                $('#formCrud #persona').trigger('change')
                $('#formCrud #text_area').val('')
                $("#formCrudModal #id-total").html(0);
                $("#formCrudModal #id-tiempo-total").text(0);
                $('#formCrudModal #sucursal').val($('#sucursal_id').val());
                $('#formCrudModal #fecha').val($('#fecha_principal').val());
                $('#formCrudModal #sucursal').trigger('change');
                $('#formCrudModal #colaborador').val(col);
                $('#formCrudModal #colaborador').trigger('change')
                $('#formCrudModal #ini_show').val("");
                $('#formCrudModal #fin_show').val("");
                $('#formCrudModal #duracion_show').val("");
                $('#formCrudModal #articulo').val('null');
                $('#formCrudModal #tabla-lista tbody').empty();
                $('#formCrudModal #articulo').trigger('change');
            }
            //seccion editar pm
            function populateModalEditPM(id,evento_id) {
                let url = "{{ route('admin.datos.editTwo') }}"+'?id='+id+'&evento_id='+evento_id;
                getData(url).then(function(rta) {
                    if (rta[2]) {
                        $('#pm_fecha').prop('readOnly', true);
                    } else {
                        $('#pm_fecha').prop('readOnly', false);
                    }
                    var pars = JSON.parse(rta[0])
                    $('#creacionpm').html('Creado por '+pars.creado_por)
                    var que_sera=[];

                    pars.forEach(function callback(ele, index, array) {
                        //enviamos el segundo como farsa
                        insertarComboPromoVacio(ele.edit_articulo_id,ele,'',ele)
                        if (ele.edit_promo_id != null ) {       que_sera[0]='promo';que_sera[1]=ele.edit_promo_id;}
                        else if (ele.edit_combo_id != null ) {  que_sera[0]='combo';que_sera[1]=ele.edit_combo_id;}
                    });
                    if (que_sera[0] == 'combo') {
                        var eler = combo_ac.find(item => item.id == que_sera[1]);
                        $.each(eler.combo_articulos, function(i, item) {
                        insertarComboPromoVacio(item.articulo_id,item,'combo',null,1)
                        })
                        $('#articulo_pm').val(pars[0].edit_combo_id+'-combo').trigger('change');

                    } else if(que_sera[0] == 'promo') {
                        var eler = promo_ac.find(item => item.id == que_sera[1]);
                        $.each(eler.promo_articulos, function(i, item) {
                            insertarComboPromoVacio(item.articulo_id,item,'promo',null,1)
                        })
                        $('#articulo_pm').val(pars[0].edit_promo_id+'-promo').trigger('change');
                    }
                    
                    if (pars[0].sin_prefe == true) {
                        $('#pm_preferencia').prop('checked', true).trigger('change')
                    } else {
                        $('#pm_preferencia').prop('checked', false).trigger('change')
                    }
                    $('#text_area_pm').val(pars[0].edit_descripcion);
                    

                    if (pars[0].edit_venta_id == null) { //solo permitiremos cambiar si no existe ya una venta
                        $('#id-modificar-reserva_pc').attr('disabled', false)
                        $('#verificar_h_pm').attr('disabled', false)
                        $('#id_delete_reserve_pc').attr('disabled', false)
                        $('#id_delete_reserve_pc').css('display', 'block');
                        $('#generar_cuenta_pm').css('display', 'block');
                    } else {
                        $('#id-modificar-reserva_pc').attr('disabled', true)
                        $('#verificar_h_pm').attr('disabled', true)
                        $('#id_delete_reserve_pc').attr('disabled', true)
                        $('#id_delete_reserve_pc').css('display', 'none');
                        $('#generar_cuenta_pm').css('display', 'none');
                    }
                    $('#id_pm').val(pars[0].id_reserva);
                    $('#sucursal_pm').val(pars[0].edit_sucursal);

                    $('#promo_combo_edit').modal('show').promise().done(function(){
                        $('.js-data-clientes-ajax_two option').remove().promise().done(function(){
                            var newOption = new Option(pars[0].edit_cliente_name, pars[0].edit_cliente_id, false, false);
                            $('.js-data-clientes-ajax_two').append(newOption).trigger('change')
                        })
                    });

                }).catch(function(error) {
                    console.log('populate dio error');
                    console.log(error);
                    Swal.fire('Ocurrio un Error', error.message, 'error');
                });
            }


            $('#modal_promo_combo').on('submit', function(e) {
                e.preventDefault();
                cargando('show', '30px', '#id-modificar-reserva_pc');
                if (($('#pm_datos .item_extra').length > 0)) {
                        var err=0;
                        $('#pm_datos .item_extra').each(function(e,data) {
                            if ($(this).find("input[id='pm_inicio']").length) {
                                var inicio=$(this).find("input[id='pm_inicio']").val()
                                var final=$(this).find("input[id='pm_fin']").val()
                                if ((inicio) && (final)) {
                                    $(this).find("input[id='pm_fin']").removeClass("errorCode").removeAttr("style");
                                    $(this).find("input[id='pm_inicio']").removeClass("errorCode").removeAttr("style");
                                }else{
                                    err=1;
                                    toadErrores('por favor brinde un horario valido', '!')
                                    $(this).find("input[id='pm_fin']").addClass("errorCode");
                                    $(this).find("input[id='pm_inicio']").addClass("errorCode");
                                }
                            }
                        }).promise().done(function() {
                            if (err == 0) {
                                    if (($('#pm_cliente_id').val() == null)) {
                                        toadErrores('Necesita seleccionar un Cliente')
                                        cargando('hide', '30px', '#id-modificar-reserva_pc');
                                    }else{
                                        enviar();
                                    }
                            }else{
                                cargando('hide', '30px', '#id-modificar-reserva_pc');
                            }
                        })  
                    
                } else {
                    cargando('hide', '30px', '#id-modificar-reserva_pc');
                    toadErrores('Necesita seleccionar un Promo o Combo')
                }

            });
            //funcion send
            function enviar(){
                var formData = new FormData($('#modal_promo_combo')[0]);
                if( $('#id_pm').val()  ){
                    var ruta = "{{ route('admin.rescar.updatetwo') }}";
                }else{
                    var ruta = "{{ route('admin.rescar.storetwo') }}";
                }
                var suc_mom = $('#sucursal_pm').val();
                postData(ruta, formData).then(function(rta) {
                    toastr.options = {  "closeButton": true, };
                    toastr.success(rta['msg'], 'Buen Trabajo!');
                    cargando('hide', '30px', '#id-modificar-reserva_pc');
                    $('#promo_combo_edit').modal('hide')
                    if (rta.redi == 200) {
                                window.location.href = "{{ route('admin.new_cuentas.index') }}" + "?sucursal=" +suc_mom;
                        } else {
                            resetPm()
                             cambios_calendarios()
                        }
                    
                }).catch(function(error) {
                    console.log('postData dio error');
                    console.log(error);
                    Swal.fire('Ocurrio un Error', error.msg, 'error');
                    cargando('hide', '30px', '#id-modificar-reserva_pc');
                }); 
               
            }
//-------------

    // a partir de aqui agrego la funcion de combos y promos
    // funcion de controlar hora
    $(document).on("click", "#verificar_h_pm", function(e){
        e.preventDefault()
    if($('#pm_datos .item_extra').length > 0){
        var err=0;
        $('#pm_datos .item_extra').each(function(e,data) {
            if ($(this).find("input[id='pm_inicio']").length) {
                var inicio=$(this).find("input[id='pm_inicio']").val()
                var final=$(this).find("input[id='pm_fin']").val()
                if ((inicio) && (final)) {
                    $(this).find("input[id='pm_fin']").removeClass("errorCode").removeAttr("style");
                    $(this).find("input[id='pm_inicio']").removeClass("errorCode").removeAttr("style");
                }else{
                    //alertamos
                    err=1;
                    toadErrores('por favor brinde un horario valido', '!')
                    $(this).find("input[id='pm_fin']").addClass("errorCode");
                    $(this).find("input[id='pm_inicio']").addClass("errorCode");
                }
            }
        }).promise().done(function() {
            if (err == 0) {
                agregraDetallepm()
                DuraccionPm()
                return true;
            }else{
                return false;
            }
            
        })
    }
   })

   $(document).on("change", "#pm_datos input[id^='pm_inicio']", function(){
            var inicio=$(this).val()
            var indice= $(this).closest( ".item_extra" );
            if ((inicio)) {
                var repla1= inicio.split(':');
                var repla2= $(indice).find("[id='articulo_pm']").attr('tiempo').split(':');
                var json1 = { hour : repla1[0], minutes : repla1[1] };
                var json2 = { hour : repla2[0], minutes : repla2[1] };
                hr            = parseInt(json1.hour) + parseInt(json2.hour);
                mn            = parseInt(json1.minutes) + parseInt(json2.minutes);
                final_hr      = hr + Math.floor(mn/60);
                final_mn      = mn%60;
                final_mn      = (final_mn < 10) ? '0' + final_mn : final_mn;
                hor1= final_hr + ':' + final_mn;
                var fin="";
                if (String(final_hr).length == 1) {
                    fin= ajustarFac(1,final_hr) + ':' + final_mn;
                }else{
                    fin=final_hr + ':' + final_mn;
                }
                $(indice).find("input[id='pm_fin']").val(fin)
            }
   })
        function agregraDetallepm() {
                var _url = "{{ route('admin.rescar.pm') }}";
                var formData = new FormData($('#modal_promo_combo')[0]);
                postData(_url, formData).then(function(rta) {
                    if (rta.cod_data == 500) {
                        $('#pm_datos .item_extra').each(function(e,data) {
                            if ($(this).find("input[id='pm_inicio']").length) {
                                var inicio=$(this).find("input[id='pm_inicio']").val()
                                var final=$(this).find("input[id='pm_fin']").val()
                                if ((inicio == rta.error_i) && (final == rta.error_f)) {
                                    $(this).find("input[id='pm_fin']").addClass("errorCode")
                                    $(this).find("input[id='pm_inicio']").addClass("errorCode")
                                }
                            }
                        })
                        toadErrores("Error este colaborador ya tiene una cita asignada")
                    }else{
                        toastr.success(rta['msg'], 'Horarios Libres!');
                        $('#verificar_h_pm').attr('disabled', false);
                    }
                }).catch(function(error) {
                    console.log('postData dio error');
                    console.log(error);
                    Swal.fire('Ocurrio un Error', error.message, 'error');
                })
            
        }
function DuraccionPm(){
    var total=0;
    var hor1='00:00'
    var end='00:00'
    $('#pm_datos .item_extra').each(function(e,data) {
        //dinero
        total=   total +   parseInt($(this).find("input[id='pm_precio']").val());
        //horas
        if ($(this).find("input[id='pm_inicio']").length) {
            var inicio=$(this).find("input[id='pm_inicio']").val()
            var final=$(this).find("input[id='pm_fin']").val()
            if ((inicio) && (final)) {
                var repla1= hor1.split(':');
                var repla2= $(this).find("[id='articulo_pm']").attr('tiempo').split(':');
                var json1 = { hour : repla1[0], minutes : repla1[1] };
                var json2 = { hour : repla2[0], minutes : repla2[1] };
                hr            = parseInt(json1.hour) + parseInt(json2.hour);
                mn            = parseInt(json1.minutes) + parseInt(json2.minutes);
                final_hr      = hr + Math.floor(mn/60);
                final_mn      = mn%60;
                final_mn      = (final_mn < 10) ? '0' + final_mn : final_mn;
                hor1= final_hr + ':' + final_mn;
                var fin="";
                if (String(final_hr).length == 1) {
                    fin= ajustarFac(1,final_hr) + ':' + final_mn;
                }else{
                    fin=final_hr + ':' + final_mn;
                }
                $("#pm_total_gen").val(total);
                $("#pm_tiempo_total").val(fin);
            }
        }
    });
}



    $('#promo_combo_edit').on('hide.bs.modal', function () {
        setTimeout(function(){
            resetPm()
        },1000);
    });
    function resetPm(){
        $('#pm_datos .item_extra').remove()
        $('#pm_total_gen').val('');
        $('#pm_tiempo_total').val('');
        $('#text_area_pm').val('');
        $('#articulo_pm').val('null').trigger('change')
        $('.js-data-clientes-ajax_two').val('null').trigger('change')  
        $('#id_pm').val('');  
        $('#generar_cuenta_pm').css('display', 'none');
        $('#id-modificar-reserva_pc').attr('disabled', false)
        $('#verificar_h_pm').attr('disabled', false)
        $('#id_delete_reserve_pc').attr('disabled', true)
        $('#id_delete_reserve_pc').css('display', 'none');
   
    }
    $('#promo_combo_edit').on('show.bs.modal', function () {
        $('#pm_fecha').val($('#fecha_principal').val())
    });
    
    $('#articulo_pm').on('change', function() {
        if ($('#promo_combo_edit').is(':visible')) {
            //hay que vaciar 
            $('#pm_datos .item_extra').remove()
            var id = $(this).val();
            var pC= id.split("-");
            if (pC[0] != 'null') {
                if (pC[1] == 'combo') {
                     var ele = combo_ac.find(item => item.id == pC[0]);
                    $.each(ele.combo_articulos, function(i, item) {
                        insertarComboPromoVacio(item.articulo_id,item,'combo')
                    })
                } else if(pC[1] == 'promo') {
                     var ele = promo_ac.find(item => item.id == pC[0]);
                     $.each(ele.promo_articulos, function(i, item) {
                        insertarComboPromoVacio(item.articulo_id,item,'promo')
                    })
                }
            } else {
                console.log('empty');
            }
        }
    })
    function insertarComboPromoVacio(id,detalles,esa,edita=null,es_se=null){
        var ele = artm_ac.find( item => item.id == id  );
        ele.cont=azarPM()
        ele.fin=ele.end;
        var optionsm="";
        var optionser="";
        if (edita == null) {
            colaboradores_ac.map(function(c){ 
                optionsm+="<option value='"+c.id+"'> "+c.name+" </option>";
            });
            if (esa == 'promo') {
                ele.precio=detalles.precio_promo
            } else if(esa == 'combo') {
                ele.precio=detalles.precio_combo
            }
        } else {
                colaboradores_ac.map(function(c){ 
                    if (c.id == edita.edit_colaborador_id ) {
                        optionsm+="<option value='"+c.id+"' selected> "+c.name+" </option>";
                    }else{
                        optionsm+="<option value='"+c.id+"'> "+c.name+" </option>";
                    }
                });
                ele.precio=edita.edit_precio
                ele.hori=edita.edit_ini_show
                ele.horf=edita.edit_fin_show
                ele.id_detalle=edita.edit_detalle_id
            
        }
        ele.optionsm=optionsm
        
        if (ele.tipo_no == 'producto') {
            $('#pm_datos').append([ele].map(Item_producto_PM).join(''));
        }else if (ele.tipo_no == 'servicio') {
            if (es_se==null) {
                servicios_ac.map(function(c){
                    if (c.id == id) {
                        optionser+="<option value='"+c.id+"'> "+c.name+" </option>";
                    }
                });
                ele.optionser=optionser;
                $('#pm_datos').append([ele].map(Item_PM).join(''));   
            }
        }

    }



    function azarPM(){
        var num_li = $('#pm_datos .item_extra').length + 1;
        num_li = (num_li * 1000) + getRandomArbitrary(1, 100);
        return num_li
    }
    function getRandomArbitrary(min, max) {
        return Math.round(Math.random() * (max - min) + min);
    }
    const Item_producto_PM = ({ name,precio }) => `
            <div class="card shadow col-md-12 bg-fuchsia item_extra">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="form-row mb-1">
                            <div class="col-4">
                                <x-jet-label value="Producto incluidos:" />
                            </div>
                            <div class="col-8">
                                <input class='form-control' value='${name}' type="text" readOnly >
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-row mb-1">
                            <div class="col">
                                <x-jet-label value="Precio :"/>
                            </div>
                            <div class="col">
                                <x-jet-input type='text' id='pm_precio' value='${precio}' class="form-control " readOnly />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
    `;
            const Item_PM = ({ cont,optionsm,optionser,precio,fin,hori='',horf='',id_detalle=0 }) => `
            <div class="card shadow col-md-12 bg-fuchsia item_extra">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="form-row mb-1">
                                    <div class="col-4">
                                        <x-jet-label value="Tipo Servicio:" />
                                    </div>
                                    <div class="col-8">
                                        <x-jet-input type='hidden' name="deta[${cont}][id_detalle]" value='${id_detalle}' class="form-control" />
                                        <select id="articulo_pm" name="deta[${cont}][articulo_pm]" tiempo='${fin}' class="form-control" style="width: 100%">
                                                ${optionser}
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row mb-1">
                                    <div class="col">
                                        <x-jet-label value="Colaborador:" />
                                    </div>
                                    <div class="col">
                                        <select id="pm_colaborador" name="deta[${cont}][colaborador]"
                                            class="form-control" style="width: 100%">
                                            <optgroup label="Colaborador">
                                                ${optionsm}
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row mb-1">
                                    <div class="col">
                                        <x-jet-label value="Importe:" />
                                    </div>
                                    <div class="col">
                                        <x-jet-input type='text' id="pm_precio" name="deta[${cont}][precio]" value='${precio}'
                                            class="form-control " readOnly />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-row mb-1">
                                    <div class="col">
                                        <x-jet-label value="Inicio:" />
                                    </div>
                                    <div class="col">
                                        <x-jet-input type='time' id="pm_inicio" value='${hori}'  name="deta[${cont}][inicio]" class="form-control " />
                                    </div>
                                </div>
                                <div class="form-row mb-1">
                                    <div class="col">
                                        <x-jet-label value="Fin:" />
                                    </div>
                                    <div class="col">
                                        <x-jet-input type='time' id="pm_fin" value='${horf}'   name="deta[${cont}][fin]" class="form-control " />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;


          
//-------------








            //seccion editar

            function populateModalEdit(id) {
                let url = "{{ route('admin.rescar.edit', ':id') }}";
                url = url.replace(':id', id);
                getData(url).then(function(rta) {
                    if (rta[2]) {
                        $('#edit_fecha').prop('readOnly', true);
                    } else {
                        $('#edit_fecha').prop('readOnly', false);
                    }
                    // cantidad de reservas
                    $('#label_cantidad').html('Esta reserva consta de ' + rta[1][0].eventos +
                        ' servicio/s');
                    //lo demas
                    populateForm('edit_formCrud', JSON.parse(rta[0]), 1);
                    var pars = JSON.parse(rta[0])
                    $('#edit_formCrud #creacion').html('Creado por '+pars.creado_por)
                    $('#edit_formCrud #edit_colaborador').val(pars.edit_colaborador_id);
                    $('#edit_formCrud #id_col_default').val(pars.edit_colaborador_id);
                    $('#edit_formCrud #id_detalle').val(pars.edit_detalle_id);
                    $('#edit_formCrud #edit_articulo').val(pars.edit_articulo_id);
                    //colocamos el horario manualmente porque o sino no funca
                    $('#edit_formCrud #edit_ini_show').val(pars.edit_ini_show);
                    $('#edit_formCrud #edit_fin_show').val(pars.edit_fin_show);
                    if (pars.sin_prefe == true) {
                        $('#edit_formCrud #con_prefe_edit').attr('checked', true)
                    } else {
                        $('#edit_formCrud #sin_prefe_edit').attr('checked', true)
                    }
                    if (pars.edit_venta_id == null) { //solo permitiremos cambiar si no existe ya una venta
                        $('#edit_formCrud #edit_fecha').prop('readonly', false);
                        $('#edit_formCrud #edit_sucursal').attr('readonly', false);
                        $('#edit_formCrud #edit_colaborador').attr('readonly', false);
                        $('#edit_formCrud #edit_ini_show').prop('readonly', false);
                        $('#edit_formCrud #edit_fin_show').prop('readonly', false);
                        $('#id_delete_reserve').attr('disabled', false)
                        $('#edit_articulo').select2({
                            dropdownParent: $('#evento_edit')
                        }).trigger('change');
                    } else {
                        $('#edit_formCrud #edit_fecha').prop('readonly', true);
                        $('#edit_formCrud #edit_sucursal').attr('readonly', true);
                        $('#edit_formCrud #edit_colaborador').attr('readonly', true);
                        $('#edit_formCrud #edit_ini_show').prop('readonly', true);
                        $('#edit_formCrud #edit_fin_show').prop('readonly', true);
                        $('#id_delete_reserve').attr('disabled', true)
                        $('#edit_articulo').select2({
                            dropdownParent: $('#nullos')
                        }).trigger('change');
                    }
                    $('#edit_formCrud #id_reserva').val(pars.id_reserva);
                    $('#edit_formCrud #estados').val(pars.estado_id + "-" + pars.color)

                    $('#evento_edit').modal('show');

                }).catch(function(error) {
                    console.log('populate dio error');
                    console.log(error);
                    Swal.fire('Ocurrio un Error', error.message, 'error');
                });
            }

            $('#edit_articulo').on('change', function() {
                //preguntamos si el modal esta abierto o sino no hacemos nada
                if ($('#evento_edit').is(':visible')) {
                    var id = $(this).val();
                    if (id != 'null') {
                        var ele = servicios_ac.find(item => item.id == id);
                        console.log(ele)
                        sumHours($('#edit_ini_show').val(), ele.end, '#edit_fin_show', '#edit_fin_show',
                            '#edit_duracion_show')
                        sumHours($('#edit_ini_show').val(), ele.end, '#edit_fin_show', '#edit_fin_show',
                            '#edit_id_tiempo_total')
                        $('#edit_precio').val(ele.precio);
                        $('#edit_id-total').val(ele.precio);
                    } else {
                        console.log('empty');
                    }
                }
            })
            $('#edit_ini_show').on('change', function() {
                //preguntamos si el modal esta abierto o sino no hacemos nada
                if ($('#evento_edit').is(':visible')) {
                    var id = $('#edit_articulo').val();
                    if (id != 'null') {
                        var ele = servicios_ac.find(item => item.id == id);
                        sumHours($('#edit_ini_show').val(), ele.end, '#edit_fin_show', '#edit_fin_show',
                            '#edit_duracion_show')
                        sumHours($('#edit_ini_show').val(), ele.end, '#edit_fin_show', '#edit_fin_show',
                            '#edit_id_tiempo_total')
                    } else {
                        console.log('empty');
                    }
                }
            })

            $('#formCrud').on('submit', function(e) {
                e.preventDefault();
                cargando('show', '30px', '#id-agregar-reserva');
                if ($('#formCrudModal #tabla-lista tbody tr').length > 0) {
                    var formData = new FormData($('#formCrud')[0]);
                    var ruta = "{{ route('admin.rescar.store') }}";
                    postData(ruta, formData).then(function(rta) {
                        toastr.options = {
                            "closeButton": true,
                        };
                        toastr.success(rta['msg'], 'Buen Trabajo!');
                        cargando('hide', '50px', '#id-agregar-reserva');
                        $('#id-agregar-reserva').attr('disabled', false)
                        $('#formCrudModal').modal('hide')
                        cambios_calendarios()
                    }).catch(function(error) {
                        console.log('postData dio error');
                        console.log(error);
                        Swal.fire('Ocurrio un Error', error, 'error');
                        $('#id-agregar-reserva').attr('disabled', false)
                    });
                } else {
                    cargando('hide', '30px', '#id-agregar-reserva');
                    toadErrores('Necesita seleccionar un servicio')
                }

            });
            $("#id-modificar-reserva").click(function(e) {
                e.preventDefault()
                $('#id-modificar-reserva').attr('disabled', true)
                ActualizarReserva()
            })

            function ajustarCheck() {
                defould_js.forEach(function callback(ele, key) {
                    $('#marcados_' + ele.colaborador_id).prop('checked', true)
                });

            }

            function ActualizarReserva() {
                if (rulesEdit()) {
                    var formData = new FormData($('#edit_formCrud')[0]);
                    formData.append('sucursal_id', $('#edit_sucursal').val());
                    var ruta = "{{ route('admin.rescar.update') }}";
                    var suc_mom = $('#edit_sucursal').val();
                    postData(ruta, formData).then(function(rta) {
                        $('#formCrud').trigger('reset');
                        $('#formCrudModal').modal('hide');
                        toastr.options = {
                            "closeButton": true,
                        };
                        toastr.success(rta['msg'], 'Buen Trabajo!');
                        $('#id-modificar-reserva').attr('disabled', false)
                        if (rta.redi == 200) {
                            window.location.href = "{{ route('admin.cuentas.index') }}" + "?sucursal=" +
                                suc_mom;
                        } else {
                            $('#evento_edit').modal('hide');
                            cambios_calendarios()
                        }
                    }).catch(function(error) {
                        console.log('postData dio error');
                        console.log(error);
                        if (error.alert) {
                            Swal.fire('Alerta', error.msg, 'warning');
                        } else {
                            Swal.fire('Ocurrio un Error', error.msg, 'error');
                        }
                    });
                } else {
                    return false
                }
            }
            $("#preferencia").click(function(e) {
                e.preventDefault()
                $('#preferencia').attr('disabled', true)
                guardarPreferencia()
            })
            function guardarPreferencia() {
                var formData = new FormData($('#form-prefe')[0]);
                var ruta = "{{ route('admin.rescar.prefe') }}";
                postData(ruta, formData).then(function(rta) {
                    toastr.success(rta['msg'], 'Preferencia Guardada!');
                    defould_js=rta.defo
                    colaborador_js=rta.caje_col
                    ajustarCheck()
                    $('#preferencia').attr('disabled', false)
                }).catch(function(error) {
                    console.log('postData dio error');
                    console.log(error);
                    if (error.alert) {
                        Swal.fire('Alerta', error.msg, 'warning');
                    } else {
                        Swal.fire('Ocurrio un Error', error.msg, 'error');
                    }
                });
            }









        }); //ready 
   //recodatorios
   var id_recordatorio = "";
            const Item_recorda = ({
                name,
                cliente,
                RUC,
                servicio_base,
                mensaje
            }) => `
            <div class="form-row">
                    <div class="col">
                    <x-jet-label value="${cliente}"/>
                    </div>
                    <div class="col">
                    <x-jet-label value="${RUC}"/>
                    </div>
                    <div class="col">
                    <x-jet-label value="${servicio_base}"/>
                    </div>
                    <div class="col">
                    <x-jet-label value="${mensaje}"/>
                    </div>
                </div>
                </hr>
            `;
            @if (Auth::user())
                $(function() {
                    setInterval(function checkSession() {
                        $.get("{{ route('admin.recordatorios.data') }}", function(data) {
                            if (data.deta.length > 0) { //solo si existe data enseñamos
                                id_recordatorio = data.ids
                                // vaciamos
                                $('#recordatorios').empty().promise().done(function() {
                                    data.deta.forEach(function callback(ele, key) {
                                        $('#recordatorios').append([ele]
                                            .map(Item_recorda).join(''));
                                        $('#modal_record').modal('show');
                                    })
                                })
                            }
                            if (data.cumple.length >
                                0) { //solo si existe cumpleaños tambien
                                $('#item_cumple').empty().promise().done(function() {
                                    data.cumple.forEach(function callback(ele,
                                        key) {
                                        $('#item_cumple').append([ele].map(
                                            Item_recorda).join(''));
                                        $('#modal_record').modal('show');
                                    })
                                })
                            }

                        });
                    }, 1800000); // treita minutos
                // }, 1800);
                });
            @endif
            function vistear() {
                if (id_recordatorio.length > 0 || $('#item_cumple').length > 0) {
                    var _url = "{{ route('admin.recordatorios.vistear') }}";
                    var formData = new FormData();
                    formData.append('ids', JSON.stringify(id_recordatorio));
                    formData.append('_token', '{{ csrf_token() }}');
                    postData(_url, formData).then(function(rta) {
                        if (rta.cod == 200) {
                            $('#modal_record').modal('hide');
                            toastr.options = {
                                "closeButton": true,
                            };
                            toastr.success(rta['msg'], 'Actualizado!');
                        }
                    }).catch(function(error) {
                        console.log('postData dio error');
                        Swal.fire('Ocurrio un Error', error.message, 'error');
                    })
                } else {
                    Swal.fire('Ocurrio un Error', "comuniquese con soporte y mantenimiento", 'error');
                }
            }


        //funcion de cambio de color
        var colorCero=0;
        var coloresB={  0 : '#007bff',1: '#6c757d',2: '#17a2b8'}
        $(function() { setInterval(function changeColor() {
            $('#combo_promo').css("background-color",coloresB[colorCero]);
            if (colorCero == 2) {
                colorCero=0;
            }else{
                colorCero++;
            }
            $('#combo_promo').css("background-color",coloresB[colorCero]);
        }
            , 18000); 
        });

        var colorError=0;
        var colorError={  0 : '#FFFFFF',1: '#FFFFFF',2: '#FF0000'}
        $(function() { setInterval(function changeColor() {
            $('.errorCode').css("background-color",coloresB[colorCero]);
            if (colorCero == 2) {
                colorCero=0;
            }else{
                colorCero++;
            }
            $('.errorCode').css("background-color",coloresB[colorCero]);
        }
            , 500); 
        });


        //funciones de sevivcio
        function agregraDetalle() {
            if (reglas()) {
                var _url = "{{ route('admin.rescar.verificar') }}";
                var formData = new FormData();
                formData.append('fecha', $('#fecha_principal').val());
                formData.append('desde', $('#formCrudModal #ini_show').val());
                formData.append('hasta', $('#formCrudModal #fin_show').val());
                formData.append('colaborador', $('#formCrudModal #colaborador').val());
                formData.append('_token', '{{ csrf_token() }}');
                postData(_url, formData).then(function(rta) {
                    if (rta.data == null) {
                        var ele = servicios_ac.find(item => item.id == $('#articulo').val());
                        ele.colId = $('#colaborador').val();
                        ele.colName = $("#colaborador option:selected").text();
                        ele.hor_ini = $('#formCrudModal #ini_show').val();
                        ele.hor_fin = $('#formCrudModal #fin_show').val();
                        ele.duracion = $('#formCrudModal #duracion_show').val();
                        if ($('#tr_' + ele.id).length > 0) {
                            toadErrores('No puede duplicar el articulo', 'Ese articulo ya esta en la lista!')
                        } else {
                            $('#formCrudModal #tabla-lista tbody').append([ele].map(Servicioo).join(''));
                            reset();
                            sumPrecioHora();
                        }
                    } else {
                        toadErrores("Error este colaborador ya tiene una cita asignada")
                        sumPrecioHora();
                    }
                }).catch(function(error) {
                    console.log('postData dio error');
                    console.log(error);
                    Swal.fire('Ocurrio un Error', error.message, 'error');
                })
            }
        }

        function reset() {
            $('#formCrudModal #ini_show').val("");
            $('#formCrudModal #fin_show').val("");
            $('#formCrudModal #duracion_show').val("");
            $('#formCrudModal #articulo').val('null');
            $('#formCrudModal #articulo').trigger('change');
            $('#formCrudModal #colaborador').val('null');
            $('#formCrudModal #colaborador').trigger('change')
        }

        function reglas() {
            if (($('#formCrudModal #colaborador').val() == 'null')) {
                toadErrores('Necesita seleccionar un colaborador')
                return false;
            } else if (($('#formCrudModal #articulo').val() == 'null')) {
                toadErrores('Necesita seleccionar un servicio')
                return false;
            } else if ($('#formCrudModal #ini_show').val().length == 0) {
                toadErrores('Necesita seleccionar un horario de inicio')
                return false;
            } else if ($('#formCrudModal #fin_show').val().length == 0) {
                toadErrores('Necesita seleccionar un horario de fin')
                return false;
            } else {
                return true
            }
        }


        function eliminarProducto(articulo) {
            var id = $('#tr_' + articulo).remove();
            sumPrecioHora();
        }

        function eliminarReserva() {
            Swal.fire({
                title: 'Desea Eliminar la Reserva',
                text: "Una vez eliminado no podra ser restaurado",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'si! Eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    var formData = new FormData($('#edit_formCrud')[0]);
                    var ruta = "{{ route('admin.rescar.destroy') }}";
                    store(formData, ruta);
                    $('#evento_edit').modal('hide');
                }
            })
        }
        function eliminarReservaPm() {
            Swal.fire({
                title: 'Desea Eliminar la Reserva',
                text: "Una vez eliminado no podra ser restaurado",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'si! Eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    var formData = new FormData($('#modal_promo_combo')[0]);
                    formData.append('id_reserva', $('#id_pm').val());
                    var ruta = "{{ route('admin.rescar.destroy') }}";
                    store(formData, ruta);
                    $('#promo_combo_edit').modal('hide');
                    $('#fecha_principal').trigger('change')
                }
            })
        }

        function rulesEdit() {
            if (($('#edit_formCrud #colaborador').val() == 'null')) {
                toadErrores('Necesita seleccionar un colaborador')
                return false;
            } else if (($('#edit_formCrud #articulo').val() == 'null')) {
                toadErrores('Necesita seleccionar un servicio')
                return false;
            } else if ($('#edit_formCrud #edit_ini_show').val().length == 0) {
                toadErrores('Necesita seleccionar un horario de inicio')
                return false;
            } else if ($('#edit_formCrud #edit_fin_show').val().length == 0) {
                toadErrores('Necesita seleccionar un horario de fin')
                return false;
            } else {
                return true
            }
        }


        @php
            echo 'var servicios_ac = ' . json_encode($servicios) . '; ';
            echo 'var promo_ac = ' . json_encode($promo) . '; ';
            echo 'var combo_ac = ' . json_encode($combo) . '; ';
            echo 'var artm_ac = ' . json_encode($artm) . '; ';
            echo 'var colaboradores_ac = ' . json_encode($colaboradores) . '; ';
        @endphp

        const Servicioo = ({
                id,
                name,
                precio,
                colName,
                colId,
                hor_ini,
                hor_fin,
                duracion
            }) =>
            ` <tr id="tr_${id}">
          <td>
            <input size="3" type="hidden" name="articulos[${id}][id]"  value="${id}">
            <input size="3" type="hidden" name="articulos[${id}][colaborador_id]"  value="${colId}">
            <input size="3" type="hidden" name="articulos[${id}][precio_actual]"  value="${precio}">
  
            <input size="3" type="hidden" name="articulos[${id}][start]"  value="${hor_ini}">
            <input size="3" type="hidden" name="articulos[${id}][end]"    value="${hor_fin}">
  
            <button class="btn btn-secondary" type="button" disabled><i class="fa fa-shopping-bag" aria-hidden="true"></i></button>
          </td>
          <td>${name}</td>
          <td>
              ${colName}
          </td>
          <td align="right" id="tr_${id}_td" ini="${hor_ini}" fin="${hor_fin}" dura="${duracion}" precio="${precio}">
                  <p>${hor_ini} - ${hor_fin}</p>
                  <p>Duración: ${duracion}</p>
          </td>
          <td align="right"> 
                  ${precio}
          </td>
          <td>
              <a class="btn btn-danger btn-sm" role="button" onclick="eliminarProducto(${id})"> <i class="fa fa-trash"></i></a>
          </td>
      </tr>`;


        $('#formCrudModal #articulo').on('change', function() {
            var id = $(this).val();
            if (id != 'null') {
                var ele = servicios_ac.find(item => item.id == id);
                if ($('#formCrudModal #tabla-lista tbody tr').length > 0) {
                    $('#formCrudModal #tabla-lista tbody tr').each(function(e, data) {
                        sumHours($('#' + data.id + '_td').attr('fin'), ele.end, '#formCrudModal #ini_show',
                            '#formCrudModal #fin_show', '#formCrudModal #duracion_show')
                    });
                } else {
                    sumHours($('#formCrudModal #start').val(), ele.end, '#formCrudModal #ini_show',
                        '#formCrudModal #fin_show', '#formCrudModal #duracion_show')
                    $('#formCrudModal #precio').val(ele.precio);
                }
            } else {
                console.log('empty');
            }
        });
        $('#ini_show').on('change', function() {
            SRHoras($(this).val(), $('#fin_show').val(), 'restar', '#formCrudModal #duracion_show')
        });
        $('#fin_show').on('change', function() {
            SRHoras($(this).val(), $('#ini_show').val(), 'restar', '#formCrudModal #duracion_show')
        });
        //estados
        $('#estados').on('change', function() {
            $('#estados_color').css('background-color', $(this).val().split('-')[1]);
        });

        function SRHoras(hor1, hor2, condicion, modal) {
            var repla1 = hor1.split(':');
            var repla2 = hor2.split(':');
            var json1 = {
                hour: repla1[0],
                minutes: repla1[1]
            };
            var json2 = {
                hour: repla2[0],
                minutes: repla2[1]
            };
            sumarHoursJson(json1, json2, condicion, modal)
        }

        function sumarHoursJson(json1, json2, condicion, modal) {
            var fin = "";
            if (condicion == 'sumar') {
                hr = parseInt(json1.hour) + parseInt(json2.hour);
                mn = parseInt(json1.minutes) + parseInt(json2.minutes);
                final_hr = hr + Math.floor(mn / 60);
                final_mn = mn % 60;
                final_mn = (final_mn < 10) ? '0' + final_mn : final_mn;
                fin = final_hr + ':' + final_mn;
            } else {
                hr = parseInt(json1.hour) - parseInt(json2.hour);
                mn = parseInt(json1.minutes) - parseInt(json2.minutes);
                final_hr = hr + Math.floor(mn / 60);
                final_mn = mn % 60;
                final_mn = (final_mn < 10) ? '0' + final_mn : final_mn;
                fin = ajustar(1, final_hr) + ':' + final_mn;
            }
            $('#duracion_show').val(fin);
        }

        function ajustar(tam, num) {
            if (num.toString().length <= tam) return ajustar(tam, "0" + num)
            else return num;
        }

    </script>

@stop
