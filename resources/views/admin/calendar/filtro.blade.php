<div class="card mb-0">
    <div class="card-header bg-info">
        <div class="form-row mb-1">
            <div class="col-1">
                <x-jet-label value="Fecha:" />
            </div>
            <div class="col-3">
                <x-jet-input type="date" id="fecha_principal" name=fecha value="{{ date('Y-m-d') }}"
                    class="form-control" />
                <x-jet-input-error for="titulo" />
            </div>
            <div class="col-1">
                <x-jet-label value="Sucursal:" />
            </div>
            <div class="col-3">
                <select name="sucursales" class="form-control" style="width: 100%" id="sucursal_cha">
                    @foreach ($sucursales as $suc)
                        @if ($suc->id == Auth()->user()->sucursal_id)
                            <option value="{{ $suc->id }}" selected> {{ $suc->name }}</option>
                        @else
                            @role('agenda')
                                <option value="{{ $suc->id }}"> {{ $suc->name }}</option>
                            @endrole
                        @endif
                    @endforeach
                </select>
                <input type="hidden">
                <x-jet-input-error for="titulo" />
            </div>
        </div>
    </div>
    <div class="card-body" style="background: #bf6b99;">
        <form action="#" id="form-prefe">
            @csrf
            <div class="form-row">
                <div class="col-8">
                    <div class="row" id="seccion_sin_eventos">
                        @php
                            $contador = 0;
                            $cantidades = count($colaboradores);
                        @endphp
                        @foreach ($colaboradores as $key => $cole)
                            @if ($contador == 0)
                                <div class="form-row col-12">
                            @endif
                            <div class="col">
                                <label class="switch">
                                    <input type="checkbox" value="{{ $cole->id }}" id="marcados_{{ $cole->id }}" class="marcados_{{ $cole->id }}"
                                        name="colaboradores[0][colaborador_{{ $cole->id }}]"
                                        @if ($cole->seleccionado == true) checked  @endif>
                                    <span class="slider round"></span>
                                </label>
                                <b>{{ $cole->name }}</b>
                            </div>
                            @php
                                $contador++;
                            @endphp
                            @if ($cantidades - 1 == $key || $contador == 4)
                    </div>
                    @php $contador=0; @endphp
                    @endif
                    @endforeach
                </div>
            </div>
            <div class="col-2 ">
                <button type="button" class="btn btn-dark float-right" id="preferencia" >Guardar Mi Preferencia</button>
            </div>
    </div>
    </form>
</div>
</div>
