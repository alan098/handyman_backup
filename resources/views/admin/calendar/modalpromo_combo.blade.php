<!-- Modal agregar -->

<div class="modal " id="promo_combo_edit" role="dialog">
    <div class="modal-dialog  modal-lg" style="max-width: 100%;">
        <div class="modal-content">
            <form id="modal_promo_combo">
                @csrf
                <input type="hidden" id="id_pm" name="id_pm">
                <div class="col-sm-12">
                    <div class="modal-body" style="background: #17a2b8;color: #000000;font-weight: 900;">
                        <div class="col-sm-12">
                            <div class="row mb-2">
                                <div class="col-6">
                                </div>
                                <div class="col-6">
                                    <div class="form-row mb-1">
                                        <div class="col-4">
                                            <button id="id_delete_reserve_pc" onclick="eliminarReservaPm()"
                                                class="btn btn-danger" style="display: none" type="button"><i
                                                    class="fa fa-delete"></i>
                                                Eliminar Reserva
                                            </button>
                                        </div>
                                        <div class="col-3">
                                        </div>
                                        <div class="col-4">
                                            <button type="button" class="btn btn-light"
                                                data-dismiss="modal">Cerrar</button>
                                            <button id="id-modificar-reserva_pc" 
                                                class="btn btn-primary"  type="submit"><i class="fa fa-save"></i>
                                                Guardar
                                            </button>
                                        </div>
                                        <div class="col-1">
                                            <div id="loader_WH">
                                                <div class="loader"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="bg-black">
                            <div class="row">
                                <div class="col-lg-6 mr-1">
                                    <div class="form-row mb-1">
                                        <div class="col-4">
                                            <x-jet-label value="Clientes:" />
                                        </div>
                                        <div class="col-8">
                                            <select class="js-data-clientes-ajax_two bg-fuchsia" style="width: 100%" name="pm_cliente_id" id="pm_cliente_id">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row mb-1">
                                        <div class="col-4">
                                            <x-jet-label value="Fecha:" />
                                        </div>
                                        <div class="col-8">
                                            <x-jet-input type='date' name="pm_fecha" id="pm_fecha" class="form-control bg-fuchsia" readOnly />
                                        </div>
                                    </div>
                                    <x-jet-input type='hidden' id="pm_start" name="pm_start" class="form-control" value='00:00' readonly />
                                    <x-jet-input type='hidden' id="pm_end" name='pm_end' class="form-control" value='00:00' readonly />
                                    <div class="form-row mb-1">
                                        <div class="col-4">
                                            <x-jet-label value="Promos o Combos:" />
                                        </div>
                                        <div class="col-8">
                                            <select id="articulo_pm" name="articulo_pm" class=" form-control" style="width: 100%">
                                                <option value="null">Elija una Promo o Combo</option>
                                                <optgroup label="Combos">
                                                    @foreach ($combo as $ser)
                                                        @if (isset($ser->comboArticulos[0]))
                                                            <option value="{{ $ser->id }}-combo">{{ $ser->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </optgroup>
                                                <optgroup label="Promos">
                                                    @foreach ($promo as $ser)
                                                        @if (isset($ser->promoArticulos[0]))
                                                            <option value="{{ $ser->id }}-promo">{{ $ser->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row mb-1">
                                        <div class="col-4">
                                            <x-jet-label value="Sucursal:" />
                                        </div>
                                        <div class="col-8">
                                            <select name="pm_sucursal_id" id="sucursal_pm" 
                                                class="form-control" style="width: 100%" >
                                                @foreach ($sucursales as $suc)
                                                @if ($suc->id == Auth()->user()->sucursal_id)
                                                <option value="{{$suc->id}}" selected> {{$suc->name}}</option>
                                                @else
                                                    <option value="{{$suc->id}}" > {{$suc->name}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row mb-1">
                                        <div class="col-4">
                                            <x-jet-label value="Observacion:" />
                                        </div>
                                        <div class="col-8">
                                            <textarea
                                                class="border-gray-300 focus:border-indigo-0 focus:ring focus:ring-indigo-0 focus:ring-opacity-50 rounded-md shadow-sm w-full "
                                                rows="2" cols="70" name="pm_descripcion" id="text_area_pm">
                                            </textarea>
                                            <x-jet-input type='hidden'  name='title' value="title" class="form-control" />
                                            <p>Maximo de caracteres 500</p>
                                        </div>
                                    </div>
                                    <div class="form-row mb-3">
                                        <div class="col-4">
                                            <x-jet-label value="Seleccione el Estado:" />
                                        </div>
                                        <div class="col-8">
                                            <select name="pm_estados" id="pm_estados" class="form-control bg-fuchsia"
                                                style="width: 100%" required>
                                                <option disabled>Seleccione El estado</option>
                                                <optgroup label="Estados">
                                                    @foreach ($estados as $est)
                                                        <option value="{{ $est->id }}-{{ $est->color }}">
                                                            {{ $est->name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-4">
                                        </div>
                                        <div class="col-8">
                                               <label for="">Sin Preferencia</label>
                                               <label for="" class=" float-right">Con Preferencia</label>
                                        </div>
                                    </div>
                                    <div class="form-row mb-5">
                                        <div class="col-4">
                                            <x-jet-label value="Seleccione:" />
                                        </div>
                                        <div class="col-8">
                                                <label class="switch1">
                                                  <input type="checkbox" checked name="pm_prefe" id="pm_preferencia">
                                                  <span class="sliround"></span>
                                                </label>
                                        </div>
                                    </div>
                                    <div class="form-row mt-5" style="display: none" id="generar_cuenta_pm">
                                        <div class="col-4">
                                            <x-jet-label value="Desea Generar cuenta:" />
                                        </div>
                                        <div class="col-8">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="si"
                                                    name="generar_cuenta_pm" id="generar_cuenta_pm">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Generar Cuenta
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-5">
                                    <div class="row">
                                        <div class="card shadow mb-3 col-md-12 bg-fuchsia">
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
                                                            <x-jet-input type='text' id="pm_total_gen" class="form-control" readonly />
                                                        </h2>
                                                    </div>
                                                    <div class="col-lg-5">
                                                        <span>Duración</span>
                                                        <h2 class="font-bold">
                                                            <x-jet-input type='time' id="pm_tiempo_total" class="form-control" readonly />
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
                            <div class="row-sm-12 bg-fuchsia">
                                <div class="col-12 text-center">¡Incluye!</div>
                            </div>
                            <div class="row-sm-12">
                                <div class="col-12 text-center mt-4">
                                    <button class="btn btn-secondary" type="button" id="verificar_h_pm">Verificar Horarios</button>
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>
                    {{-- detalles --}}
                    <div class="modal-footer" style="background: #17a2b8;color: #000000;font-weight: 900;">
                        <div class="col-sm-12" id="pm_datos">

                        </div>
                        <div >
                            <b id="creacionpm"></b>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
