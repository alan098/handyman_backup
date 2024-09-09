<div id="formServicios">
    <div class="card shadow mb-3 col-md-12">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-7">
                    <div class="form-row mb-1">
                        <div class="col-4">
                            <x-jet-label value="Tipo Servicio:" />
                        </div>
                        <div class="col-8">
                            <select id="servicio_id" class=" form-control select2" style="width: 100%">
                                <option value="null">Elija un Servicio</option>
                                <optgroup label="Servicios">
                                    @foreach ($articulos as $ser)
                                    @if ( $ser->tipo == 'servicio' )
                                    <option value="{{ $ser->id }}">{{ $ser->name}}</option>
                                    @endif
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="form-row mb-1">
                        <div class="col">
                            <x-jet-label value="Colaborador:" />
                        </div>
                        <div class="col">
                            <select id="colaborador_id" class="form-control select2 reset_" style="width: 100%">
                                <option value="null">Elija un Colaborador</option>
                                <optgroup label="Colaborador">
                                    @foreach ($colaboradores as $col)
                                    <option value="{{ $col->id }}">{{ $col->name
                                        }}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="form-row mb-1">
                        <div class="col">
                            <x-jet-label value="Importe:" />
                        </div>
                        <div class="col">
                            <x-jet-input type='text' id="precio_servicio_g" class="form-control" readonly />
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-row mb-1">
                        <div class="col">
                            <x-jet-label value="Inicio:" />
                        </div>
                        <div class="col">
                            <x-jet-input type='time' id="ini_show" class="form-control " />
                        </div>
                    </div>
                    <div class="form-row mb-1">
                        <div class="col">
                            <x-jet-label value="Fin:" />
                        </div>
                        <div class="col">
                            <x-jet-input type='time' id="fin_show" class="form-control "  />
                        </div>
                    </div>
                    <div class="form-row mb-1">
                        <div class="col">
                            <x-jet-label value="Duracion:" />
                        </div>
                        <div class="col">
                            <x-jet-input type='text' id="duracion_show" class="form-control " readonly />
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <button id="add-detalle" type="button" class="btn btn-primary m-r-sm" onclick="agregraDetalle()"
                    @if (isset($id_venta) && ($cerrada->concluido == true) )
                    disabled
                    @endif
                    ><i
                            class="fa fa-check"></i>
                        Agregar al
                        detalle
                    </button>
                </div>
            </div>
            {{-- tablas --}}
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-responsive" id="tabla-lista">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Colaborador</th>
                                    <th>Servicio</th>
                                    <th>Com. Col</th>
                                    <th>Com. Afi.</th>
                                    <th>Afiliado</th>
                                    <th>Inicio / Fin</th>
                                    <th>Importe</th>
                                    <th>Descuento</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>