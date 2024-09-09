<div class="card shadow mb-3 col-md-12">
    <div class="card-header">
        <x-cabecera>
            <x-slot name='title'>
                Filtros Disponibles
            </x-slot>
            <x-slot name='subtitle'>
                Elija alguno de estos filtros para visualizar la informacion que desea
            </x-slot>
        </x-cabecera>
    </div>
    <div class="card-body">
        <form>
            <div class="form-row mb-1">
                <div class="col-sm-1" style="display: none; float: right;" id="esperando">
                    <div class="loader"></div>
                </div>
            </div>
            <div class="form-row mb-1">
                <div class="col-2">
                    <x-jet-label value="Colaborador" />
                </div>
                <div class="col-2">
                    <x-jet-label value="Condicion"/>
                </div>
                <div class="col-2">
                    <x-jet-label value="Sucursal"/>
                </div>
                <div class="col-2">
                    <x-jet-label value="Fecha Desde:"/>
                </div>
                <div class="col-2">
                    <x-jet-label value="Fecha Hasta:"/>
                </div>
            </div>
            <div class="form-row mb-1">
                <div class="col-2">
                    <select name="cliente_id" id="cliente_id" class="form-control select2" style="width: 100%" required>
                        <option value="">Todos</option>
                        <optgroup label="Colaboradores">
                            @foreach ($colaboradores as $cli)
                            <option value="{{ $cli->id }}">{{ $cli->name }}</option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>
                <div class="col-2">
                    <select name="condicion" id="condicion" class="form-control select2" style="width: 100%">
                        <option value="">Todos</option>
                        <option value="1">Contado</option>
                        <option value="2">Credito</option>
                    </select>
                </div>
                <div class="col-2">
                    <select name="sucursales" id="sucursales" class="form-control select2 " style="width: 100%">
                        @foreach ($sucursales as $suc)
                        @if ($suc->id == Auth()->user()->sucursal_id)
                        <option value="{{$suc->id}}"  selected>
                            {{$suc->name}}</option>
                        @else
                        <option value="{{$suc->id}}">
                            {{$suc->name}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" class="form-control form-control-sm datepicker" id="fecha_desde" value="{{date("Y-m-01")}}" name="fecha_desde" >
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" class="form-control form-control-sm datepicker" id="fecha_hasta" value="{{date("Y-m-30")}}" name="fecha_hasta" >
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-primary" onclick="descargarReporte()">Generar Reporte</button>
                </div>
            </div>
        </form>
    </div>
</div>