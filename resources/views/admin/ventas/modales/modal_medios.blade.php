<div class="modal fade bd-example-modal-lg" id="modal_medios_pagos"   role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 100%;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Añadir Metodos de pago</h4>
            </div>
            <div id="formMedios">
                <div class="modal-body">
                    <div class="form-row mb-1">
                        <div class="col-1">
                            <x-jet-label value="Medio De Pago" />
                        </div>
                        <div class="col-2">
                            <x-jet-label value="Bancos" />
                        </div>
                        <div class="col-2">
                            <x-jet-label value="Cuentas:" />
                        </div>
                        <div class="col-1">
                            <x-jet-label value="Tarjetas:" />
                        </div>
                        <div class="col-2">
                            <x-jet-label value="Documento:" />
                        </div>
                        <div class="col-1">
                            <x-jet-label value="Importe:" />
                        </div>
                        <div class="col-1">
                            <x-jet-label value="Fecha de Emision:" />
                        </div>
                        <div class="col-1">
                            <x-jet-label value="Fecha de Vencimiento:" />
                        </div>
                        <div class="col-1">
                            <x-jet-label value="Más Medios" />
                        </div>
                    </div>
                    <div class="form-row mb-1 fila_medio" >
                        <div class="col-1">
                            <select class="form-control select2" id="met_medio" 
                                style="width: 100%; font-size: 20px !important;" name="medios[0][medio]">
                                @foreach($medios as $med)
                                <option value="{{$med->id}}">{{$med->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <select class="form-control desabilitar select2" id="met_banco" 
                                style="width: 100%; font-size: 20px !important;" disabled  name="medios[0][banco]">
                                <option value="0" selected>Bancos</option>
                                @foreach($bancos as $med)
                                <option value="{{$med->id}}">{{$med->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <select class="form-control desabilitar select2" id="met_cuenta" 
                                style="width: 100%; font-size: 20px !important;" disabled  name="medios[0][cuenta]">
                                <option value="0" selected>Cuenta</option>
                                @foreach($cuentas as $med)
                                <option value="{{$med->id}}">{{$med->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-1">
                            <select class="form-control desabilitar" id="met_tarjeta" 
                                style="width: 100%; font-size: 20px !important;" disabled  name="medios[0][tarjeta]">
                                <option value="0" selected>Tarjetas</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <input id="met_documento" type="text" class="form-control col-12 desabilitar siempreCero" placeholder="N°"
                                 disabled  name="medios[0][documento]">
                        </div>
                        <div class="col-1">
                            <input id="met_monto" placeholder="Monto"  name="medios[0][importe]" type="text" value="0" class="form-control  text-right formatogs" >

                        </div>
                        <div class="col-1">
                            <input id="met_fecha_ini" type="date" class=" form-control col-12 desabilitar" disabled  name="medios[0][inicio]">
                        </div>
                        <div class="col-1">
                            <input id="met_fecha_fin" type="date" class=" form-control col-12 desabilitar" disabled  name="medios[0][fin]">
                        </div>
                        <div class="col-1">
                            <button type="button" class="btn btn-primary" title="Añadir metodo de pago" id="añadir"><i
                                    class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    <div id="seccion_add">

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>