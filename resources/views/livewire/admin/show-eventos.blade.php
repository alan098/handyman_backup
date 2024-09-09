<div wire:init="LoatCalendar">
    {{-- colaboradores --}}
    @if (count($sucursales))
    <div class="card shadow mb-3 mt-0 col-md-12">
        <div class="card-body">
            <form>
                <div class="form-row mb-1">
                    <div class="col-2">
                        <x-jet-label value="Fecha:" />
                    </div>
                    <div class="col-4">
                        <x-jet-input type="date" id="fecha_principal" name=fecha value="{{$fecha}}"
                            wire:model.lazy="fecha" class="form-control" />
                        <x-jet-input-error for="titulo" />
                    </div>
                </div>
                {{-- <div class="form-row mb-1">
                    <div class="col-2">
                        <x-jet-label value="Sucursal" />
                    </div>
                    <div class="col-4">
                        <select name="sucursales" class="form-control select2 sucursales" style="width: 100%" onchange="sucursal_change(this);" id="sucursal_cha">
                            @foreach ($sucursales as $suc)
                            @if ($suc->id == Auth()->user()->sucursal_id)
                             <option value="{{$suc->id}}" selected> {{$suc->name}}</option>
                            @else
                            @role('Agenda')
                                <option value="{{$suc->id}}" > {{$suc->name}}</option>
                            @endrole
                            @endif
                            @endforeach
                        </select>
                        <input type="hidden">
                        <x-jet-input-error for="titulo" />
                    </div>
                </div> --}}
                <div class="form-row mb-1">
                    <div class="col-2">
                        <x-jet-label value="Colaborador:" />
                    </div>
                    <div class="col-4">
                        <select name="colaborador" class="form-control select2" style="width: 100%" onchange="colaborador_add(this);">
                            <option value="" selected disabled></option>
                            @foreach ($colaboradores as $col)
                            <option value="{{$col->id}}"
                               > {{$col->name}}
                            </option>
                            @endforeach
                        </select>
                        <input type="hidden">
                        <x-jet-input-error for="titulo" />
                    </div>
                </div>
                <div>
                    <div class="form-row ">
                        <div class="col-2">
                        </div>
                        <div class="col-4">
                            <fieldset class="form-group">
                                <div class="row" id="seccion_sin_eventos">

                                <!--los colaboradores que tinen -->  
                                {{-- pre --}}
                                    @if (count($colaboradoresEventos)) 
                                    @php $contador=0; @endphp
                                    @foreach ($colaboradoresEventos as $cole)
                                        @if ($contador == 0) 
                                        <div class="col"> 
                                        @endif
                                        <div class="form-check">
                                            <input class="form-check-input marcados_{{$cole->id}}" type="checkbox" name="gridRadios" wire:click="excluidos({{$cole->id}})" checked  value="{{$cole->id}}">
                                            <label class="form-check-label" for="gridRadios1">
                                                {{$cole->name}}
                                            </label>
                                        </div>
                                        @php $contador++; if ($contador == 3) { $contador=0; } @endphp
                                        @if ($contador == 0)
                                        </div> 
                                        @endif
                                    @endforeach
                                    @endif 
                                    {{-- pre --}}
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-4 ">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- calendarios --}}
    <br>
    <div>
        <div class="card shadow mb-3 col-12">
            <div class="card-header">
                <x-cabecera>
                    <x-slot name='title'>
                        Calendario
                    </x-slot>
                    <x-slot name='subtitle'>
                        @if (count($colaboradoresEventos))
                            Elija alguno de estos para poder editar la información
                        @else
                            Seleccione un Colaborador para iniciar
                        @endif
                    </x-slot>
                </x-cabecera>
            </div>
            <style>
                .fc-event-title-container{
                    color: black !important;
                }
                .columna_colaborador{
                    max-width: 18%;
                }
                .testimonial-group > .row {
                    display: block;
                    overflow-x: auto;
                    white-space: nowrap;
                }
                .testimonial-group > .row > .col-4 {
                display: inline-block;
                }
        
            </style>
            <div class="card-body">
                <div id="id_calendar">
                    <div class="row">
                        <div class="col-12">
                                <div class="container testimonial-group col-12">
                                    <div class="row scroll" id="calendar_map">
                                                @if (count($colaboradoresEventos))
                                                @foreach ($colaboradoresEventos as $col)
                                                <div class="col-4 columna_colaborador_{{$col->id}} columna_colaborador" >
                                                <div class="form-row container-fluid">
                                                <div class="col-"></div>
                                                <div class="col-4">
                                                <h4>
                                                <strong>{{$col->name}}</strong>
                                                </h4>
                                                <div class="col-4"></div>
                                                </div>
                                                <div id="agenda_numero_{{$col->id}}" colaborador="{{$col->id}}" cliente=""></div>
                                                </div>
                                                </div>
                                                @endforeach
                                                @else
                                                <div>
                                                Ahun no existen eventos
                                                </div>
                                                @endif   
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @else
    <h3>Cargando...</h3>
    @endif
</div>