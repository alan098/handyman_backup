
<!-- Modal preriosidad -->
<div class="modal inmodal" id="modalReservaPeriodicidad" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="modal-header" style="padding: 10px 15px 0px;">
                        <div class="col-lg-8">
                            <h3 style="text-align: left;"><span class="text-navy">Periodicidad
                                    personalizada</span></h3>
                        </div>
                        <div class="col-lg-4 pull-right">
                            <div class="btn-group">
                                <ul class="object-tools">
                                    <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar
                                    </button>
                                    <button id="id-agregar-periodicidad" class="btn btn-primary" type="button"><i
                                            class="fa fa-save"></i> Guardar
                                    </button>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <form id="periodicidad_form" class="form-horizontal">
                        <div class="modal-body" style="max-height: 800px; margin-bottom: 30px">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="row">
                                        <input type="text" name="id-reserva-period" id="id-reserva-period"
                                            hidden="true">



                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label class="col-sm-3"><span>Repetir cada
                                                        </span></label>
                                                    <div class="col-xs-2">
                                                        <input name="frecuencia" id="input-id-frecuencia" min="1"
                                                            max="1000" class="form-control" data-container="body"
                                                            data-placement="bottom"
                                                            data-content="Debe ingresar una cantidad valida!">
                                                        <i id="id-minus-f" class="fa fa-minus"
                                                            style="position: absolute;margin-left: -15px;margin-top: -20px;"></i>
                                                        <i id="id-plus-f" class="fa fa-plus"
                                                            style="position: absolute;margin-top: -20px;margin-left: 70px;"></i>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <select class="select2_demo_2 form-control"
                                                            id="id-frecuencia-repeticion" name="frecuencia-repeticion"
                                                            style="position: absolute;margin-left: -15px;margin-top: -20px;">
                                                            <option selected="selected" value="DIA">Días
                                                            </option>
                                                            <option value="SEM">Semanas</option>
                                                            <option value="MES">Meses</option>
                                                            <option value="ANH">Años</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-12" id="id-se-repite" hidden>
                                            <div class="form-group">
                                                <label class="col-lg-12"><span>Se repite
                                                        el</span></label>
                                            </div>
                                            <div class="form-group" id="id-dias-repeticion">
                                                <div class="col-lg-12">
                                                    <div>
                                                        <button id="id-domingo" value="1" name="btn-semana"
                                                            class="btn btn-outline btn-circle btn-primary"
                                                            type="button">D
                                                        </button>
                                                        <button id="id-lunes" value="2" name="btn-semana"
                                                            class="btn btn-outline btn-circle btn-primary"
                                                            type="button">L
                                                        </button>
                                                        <button id="id-martes" value="3" name="btn-semana"
                                                            class="btn btn-outline btn-circle btn-primary"
                                                            type="button">M
                                                        </button>
                                                        <button id="id-miercoles" value="4" name="btn-semana"
                                                            class="btn btn-outline btn-circle btn-primary"
                                                            type="button">M
                                                        </button>
                                                        <button id="id-jueves" value="5" name="btn-semana"
                                                            class="btn btn-outline btn-circle btn-primary"
                                                            type="button">J
                                                        </button>
                                                        <button id="id-viernes" value="6" name="btn-semana"
                                                            class="btn btn-outline btn-circle btn-primary"
                                                            type="button">V
                                                        </button>
                                                        <button id="id-sabado" value="7" name="btn-semana"
                                                            class="btn btn-outline btn-circle btn-primary"
                                                            type="button">S
                                                        </button>
                                                        <input type="hidden" id="dia-semana-selected"
                                                            name="dia-semana-selected">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 form-group" id="id-mes-repeticion" hidden>
                                            <select class="select2_demo_2 form-control" id="id-repetir-el"
                                                name="repetir-el">
                                            </select>
                                            <input type="hidden" id="id-repetir-dia-mensual"
                                                name="id-repetir-dia-mensual">
                                            <input type="hidden" id="id-repetir-semana-mensual"
                                                name="id-repetir-semana-mensual">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2"><span>Termina</span></label>
                                        </div>


                                        <div class="form-group">
                                            <div class="col-lg-12">
                                                <div class="iradio">
                                                    <label for="id-radio-nunca" class="col-lg-12">
                                                        <input type="radio" id="id-radio-nunca" name="iCheck">
                                                        Nunca
                                                    </label>
                                                    <input type="hidden" id="id-filtro-radio-nunca"
                                                        name="filtro-radio-nunca" value="true">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <div class="col-lg-12">
                                                <div class="iradio">
                                                    <label for="id-radio-fecha" class="col-lg-3">
                                                        <input type="radio" id="id-radio-fecha" name="iCheck">
                                                        El
                                                    </label>
                                                    <input type="hidden" id="id-filtro-radio-fecha"
                                                        name="filtro-radio-fecha" value="false">
                                                    <div class="input-group col-lg-5">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </span>
                                                        <input type="hidden" id="id-fecha-hasta" name="fecha-hasta"
                                                            class="form-control">
                                                        <input type="text" id="id-fecha-hasta-periodo"
                                                            name="id-fecha-hasta-periodo" class="form-control"
                                                            style="text-align: right">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-times clear-date-reserva"
                                                                id="clear-fecha-periodo"></i>
                                                        </span>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <div class="col-lg-12">
                                                <div class="iradio">
                                                    <label for="id-radio-limite" class="col-lg-3">
                                                        <input type="radio" id="id-radio-limite" name="iCheck" checked>
                                                        Despues de
                                                    </label>
                                                    <input type="hidden" id="id-filtro-radio-limite"
                                                        name="filtro-radio-limite" value="false">
                                                    <div class="col-lg-2">
                                                        <input name="limite" id="input-id-limite" min="1" max="1000"
                                                            class="form-control" data-container="body"
                                                            data-placement="bottom"
                                                            data-content="Debe ingresar una cantidad valida!">
                                                        <i id="id-minus-l" class="fa fa-minus"
                                                            style="position: absolute;margin-left: -15px;margin-top: -20px;"></i>
                                                        <i id="id-plus-l" class="fa fa-plus"
                                                            style="position: absolute;margin-top: -20px;margin-left: 70px;"></i>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <input type="text" disabled value="reservas"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
