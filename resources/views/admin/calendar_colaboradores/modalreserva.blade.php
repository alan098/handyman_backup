<!-- Modal agregar -->
<div class="modal inmodal" id="formCrudModal" role="dialog"  aria-labelledby="formCrudModalTitle">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="row">
                <form id="formCrud" name="formCrud" class="form-horizontal">
                    @csrf
                    <div class="col-lg-12">
                        <div class="modal-header" style="padding: 10px 15px 0px;">
                            <div class="col-lg-6">
                                <h3 style="text-align: left;"><span class="text-navy">Agregar Reserva</span>
                                </h3>
                            </div>
                            <div class="col-lg-6 pull-right">
                                <div class="btn-group">
                                    <div id="loader_WH">
                                        <div class="loader"></div>
                                    </div>
                                    <ul class="object-tools">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar
                                        </button>
                                        <button id="id-agregar-reserva" class="btn btn-primary" type="submit"
                                            type="button"><i class="fa fa-save"></i> Guardar
                                        </button>
                                    </ul>
                                </div>
                            </div>
                        </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-6 mr-1">
                                                <div class="form-row mb-1">
                                                    <div class="col-4">
                                                        <x-jet-label value="Clientes:" />
                                                    </div>
                                                    <div class="col-8">
                                                        <select class="js-data-clientes-ajax" style="width: 100%" name="cliente_id" id="persona">
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="form-row mb-1">
                                                    <div class="col-4">
                                                        <x-jet-label value="Fecha:" />
                                                    </div>
                                                    <div class="col-6">
                                                        <x-jet-input type='date' id="fecha" name="fecha"
                                                             class="form-control" readonly />
                                                    </div>
                                                </div>
                                                <div class="form-row mb-1">
                                                    <div class="col-4">
                                                        <x-jet-label value="Hora Inicio:" />
                                                    </div>
                                                    <div class="col-6">
                                                        <x-jet-input type='text' id="start" name="start"
                                                            class="form-control" readonly />
                                                    </div>
                                                </div>
                                                <div class="form-row mb-1">
                                                    <div class="col-4">
                                                        <x-jet-label value="Hora Fin:" />
                                                    </div>
                                                    <div class="col-6">
                                                        <x-jet-input type='text' id="end" name='end'
                                                            class="form-control " readonly />

                                                    </div>
                                                </div>
                                                <div class="form-row mb-1">
                                                    <div class="col-4">
                                                        <x-jet-label value="Sucursal:" />
                                                    </div>
                                                    <div class="col-8">
                                                        <select name="sucursal_id" id="sucursal" 
                                                            class="form-control" style="width: 100%" >
                                                            @foreach ($sucursales as $suc)
                                                            @if ($suc->id == Auth()->user()->sucursal_id)
                                                            <option value="{{$suc->id}}" selected> {{$suc->name}}</option>
                                                            @else
                                                            {{-- @role('Agenda') --}}
                                                                <option value="{{$suc->id}}" > {{$suc->name}}</option>
                                                            {{-- @endrole --}}
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
                                                            rows="2" name="descripcion" id="text_area">
                                                        </textarea>
                                                        <x-jet-input type='hidden' name='title' value="title" class="form-control" />
                                                        <p>Maximo de caracteres 500</p>
                                                    </div>
                                                </div>
                                                <style>
                                                    .big-checkbox {width: 20px; height: 20px;}
                                                </style>
                                                <div class="form-row mb-1">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" value="false" name="sin_prefe" id="sin_prefe" checked>
                                                        <label class="form-check-label" for="sin_prefe">
                                                          Sin Preferencia
                                                        </label>
                                                      </div>
                                                      <div class="form-check ml-2">
                                                        <input class="form-check-input" type="radio"  value="true" name="sin_prefe" id="con_prefe">
                                                        <label class="form-check-label" for="con_prefe">
                                                         Con Preferencia
                                                        </label>
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
                                                                <div class="col-lg-8">
                                                                    <span>Total</span>
                                                                    <h2 id="id-total" class="font-bold">
                                                                        0
                                                                    </h2>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <span>Duración</span>
                                                                    <h2 id="id-tiempo-total" class="font-bold">
                                                                        00:00
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
                                                <div class="card-header">
                                                    <x-cabecera>
                                                        <x-slot name='title'>
                                                            Servicios
                                                        </x-slot>
                                                        <x-slot name='subtitle'>
                                                        </x-slot>
                                                    </x-cabecera>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-7">
                                                            <div class="form-row mb-1">
                                                                <div class="col-4">
                                                                    <x-jet-label value="Tipo Servicio:" />
                                                                </div>
                                                                <div class="col-8">
                                                                    <select  id="articulo"
                                                                        class=" form-control select2"
                                                                        style="width: 100%">
                                                                        <option value="null">Elija un Servicio</option>
                                                                        <optgroup label="Servicios">
                                                                            @foreach ($servicios as $ser)
                                                                            <option value="{{ $ser->id }}">{{ $ser->name
                                                                                }}</option>
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
                                                                    <select  id="colaborador"
                                                                        class="form-control select2"
                                                                        style="width: 100%">
                                                                        <option value="null">Elija un Colaborador
                                                                            defecto</option>
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
                                                                    <x-jet-input type='text' id="precio"
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
                                                                    <x-jet-input type='time' id="ini_show"
                                                                        class="form-control " />
                                                                </div>
                                                            </div>
                                                            <div class="form-row mb-1">
                                                                <div class="col">
                                                                    <x-jet-label value="Fin:" />
                                                                </div>
                                                                <div class="col">
                                                                    <x-jet-input  type='time' id="fin_show"
                                                                        class="form-control "/>
                                                                </div>
                                                            </div>
                                                            <div class="form-row mb-1">
                                                                <div class="col">
                                                                    <x-jet-label value="Duracion:" />
                                                                </div>
                                                                <div class="col">
                                                                    <x-jet-input  type='time' id="duracion_show"
                                                                        class="form-control " readonly />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <button id="add-detalle" type="button"
                                                                class="btn btn-primary m-r-sm"
                                                                onclick="agregraDetalle()"><i class="fa fa-check"></i>
                                                                Agregar al
                                                                detalle
                                                            </button>
                                                        </div>
                                                    </div>
                                                    {{-- tablas --}}
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="table-responsive">
                                                                <table class="table table-striped" id="tabla-lista">
                                                                    <tbody>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
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