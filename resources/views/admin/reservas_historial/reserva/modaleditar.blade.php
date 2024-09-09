<!-- Modal agregar -->

<div class="modal " id="evento_edit" role="dialog">
    <div class="modal-dialog  modal-lg" style="max-width: 50%;">
        <div class="modal-content">
            <form id="edit_formCrud" name="edit_formCrud">
                @csrf
                <input type="hidden" name="id_reserva" id="id_reserva">
                <input type="hidden" name="id_detalle" id="id_detalle">
                <input type="hidden" name="id_col_default" id="id_col_default">
                <div class="col-sm-12">
                    <div class="modal-body">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-lg-6 mr-1">
                                    <div class="form-row mb-1">
                                        <div class="col-4">
                                            <x-jet-label value="Clientes:" />
                                        </div>
                                        <div class="col-8">
                                            <x-jet-input type='text' name="edit_cliente_id" id="edit_cliente_id"
                                                class="form-control" readonly />
                                        </div>
                                    </div>
                                    <div class="form-row mb-1">
                                        <div class="col-4">
                                            <x-jet-label value="Fecha:"/>
                                        </div>
                                        <div class="col-6">
                                            <x-jet-input type='date' id="edit_fecha" name="edit_fecha"
                                                class="form-control "  />
                                        </div>
                                    </div>
                                    <div class="form-row mb-1">
                                        <div class="col-4">
                                            <x-jet-label value="Sucursal:" />
                                        </div>
                                        <div class="col-8">
                                            <select name="edit_sucursal" id="edit_sucursal" 
                                                class="form-control " style="width: 100%" >
                                                @foreach ($sucursal as $suc)
                                                @if ($suc->id == Auth()->user()->sucursal_id)
                                                <option value="{{$suc->id}}" selected> {{$suc->name}}</option>
                                                @else
                                                    <option value="{{$suc->id}}" > {{$suc->name}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                            {{-- <x-jet-input type='text' name="edit_sucursal" id="edit_sucursal"
                                                class="form-control" readonly /> --}}
                                        </div>
                                    </div>
                                    <div class="form-row mb-1">
                                        <div class="col-4">
                                            <x-jet-label value="Observacion:" />
                                        </div>
                                        <div class="col-8">
                                            <textarea
                                                class=" border-gray-300 focus:border-indigo-0 focus:ring focus:ring-indigo-0 focus:ring-opacity-50 rounded-md shadow-sm w-full "
                                                rows="2" name="descripcion" id="edit_descripcion" readonly>
                                                    </textarea>
                                        </div>
                                    </div>
                                    <div class="form-row mb-1">
                                        <div class="form-row mb-1">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" value="false" name="sin_prefe_edit" id="sin_prefe_edit">
                                                <label class="form-check-label" >
                                                  Sin Preferencia
                                                </label>
                                              </div>
                                              <div class="form-check ml-2">
                                                <input class="form-check-input" type="radio" value="true" name="sin_prefe_edit" id="con_prefe_edit">
                                                <label class="form-check-label" >
                                                 Con Preferencia
                                                </label>
                                              </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="row">
                                        <div class="card shadow mb-3 col-md-12">
                                            <div class="card-header">
                                                <x-cabecera>
                                                    <x-slot name='title'>
                                                        Total
                                                    </x-slot>
                                                    <x-slot name='subtitle'></x-slot>
                                                </x-cabecera>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-7">
                                                        <span>Total</span>
                                                        <h2 class="font-bold">
                                                            <x-jet-input type='text' id="edit_id-total"
                                                                class="form-control" readonly />
                                                        </h2>
                                                    </div>
                                                    <div class="col-lg-5">
                                                        <span>Duración</span>
                                                        <h2 class="font-bold">
                                                            <x-jet-input type='time' id="edit_id_tiempo_total"
                                                                class="form-control" readonly />
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                </div>
                            </div>
                            {{-- --}}
                            <div class="row border">
                                <div class="card shadow mb-3 col-md-12">
                                    <div class="card-header border">
                                        <x-cabecera>
                                            <x-slot name='title'>
                                                Servicios
                                            </x-slot>
                                            <x-slot name='subtitle'>
                                            </x-slot>
                                        </x-cabecera>
                                        <label for="" id="label_cantidad">Esta reserva incluye </label>

                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <div class="form-row mb-1">
                                                    <div class="col-4">
                                                        <x-jet-label value="Tipo Servicio:" />
                                                    </div>
                                                    <div class="col-8" >
                                                        <select  id="edit_articulo" name="edit_articulo" class="form-control" style="width: 100%">
                                                        <optgroup label="Servicios">
                                                            @foreach ($servicios as $ser)
                                                            <option value="{{ $ser->id }}">{{ $ser->name }}</option>
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
                                                        <select  id="edit_colaborador" name="edit_colaborador"
                                                            class="form-control "
                                                            style="width: 100%">
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
                                                        <x-jet-input type='text' id="edit_precio" name="edit_precio"
                                                            class="form-control " readonly />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-row mb-1">
                                                    <div class="col">
                                                        <x-jet-label value="Inicio:" />
                                                    </div>
                                                    <div class="col">
                                                        <x-jet-input type='time' id="edit_ini_show" name="edit_ini_show"
                                                            class="form-control "  />
                                                    </div>
                                                </div>
                                                <div class="form-row mb-1">
                                                    <div class="col">
                                                        <x-jet-label value="Fin:" />
                                                    </div>
                                                    <div class="col">
                                                        <x-jet-input type='time' id="edit_fin_show" name="edit_fin_show" 
                                                            class="form-control "  />

                                                    </div>
                                                </div>
                                                <div class="form-row mb-1">
                                                    <div class="col">
                                                        <x-jet-label value="Duracion:" />
                                                    </div>
                                                    <div class="col">
                                                        <x-jet-input type='text' id="edit_duracion_show"
                                                            class="form-control " readonly />

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--  --}}
                            <br>
                            <div class="row border">
                                <div class="col-lg-12">
                                    <div class="form-row mb-1 border">
                                        <div class="col-3">Seleccione el Estado:</div>
                                        <div class="col-4">
                                            <select name="estados" id="estados" class="form-control "
                                                style="width: 100%" required>
                                                <option disabled>Seleccione El estado</option>
                                                <optgroup label="Estados">
                                                    @foreach ($estados as $est)
                                                    <option value="{{ $est->id }}-{{$est->color}}">{{$est->name}}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="col-5 ">
                                            <div class="form-check float-right">
                                                <input class="form-check-input" type="checkbox" value="si" name="generar_cuenta" id="generar_cuenta">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Generar Cuenta
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-row mb-1">
                                        <div class="col-4">
                                            {{-- <button id="id_delete_reserve" onclick="eliminarReserva()" class="btn btn-danger"
                                                type="button"><i class="fa fa-delete"></i> Eliminar Reserva
                                            </button> --}}
                                        </div>
                                        <div class="col-4">
                                        </div>
                                        <div class="col-4">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Cerrar</button>
                                            <button id="id-modificar-reserva" onclick="ActualizarReserva()" class="btn btn-primary" type="button"><i class="fa fa-save"></i>
                                                Guardar
                                            </button>
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