<div class="card shadow mb-3 col-md-12 bg-info">
    <div class="card-header">
        <x-cabecera>
            <x-slot name='title'>
                Filtros
            </x-slot>
            <x-slot name='subtitle'>
                Elija alguno de estos filtros para visualizar la informacion que desea
            </x-slot>
        </x-cabecera>
    </div>
    <div class="card-body">
        <form id="form-por">
            <div class="form-row mb-1">
            </div>
            <div class="form-row mb-1">
                <div class="col-2">
                    <x-jet-label value="Cliente:" />
                </div>
                <div class="col-4">
                    <select class="js-data-clientes-ajax" style="width:100%" id="cliente_id">
                        <option value="">Todos los clientes</option>
                    </select>
                </div>
            </div>
            <div class="form-row mb-1">
                <div class="col-2">
                    <x-jet-label value="Fecha Desde:"/>
                </div>
                <div class="col-3">
                    <input autocomplete="off" type="date" class="form-control form-control-sm" id="fecha_desde" value="{{date("Y-m-d")}}" name="fecha_desde" >
                </div>
                <div class="col-2">
                    <x-jet-label value="Fecha Hasta:"/>
                </div>
                <div class="col-3">
                    <input autocomplete="off" type="date" class="form-control form-control-sm" id="fecha_hasta" value="{{date("Y-m-d")}}" name="fecha_hasta" >
                </div>
            </div>
            <div class="form-row mb-1">
                <div class="col-2">
                    <x-jet-label value="Sucursal" />
                </div>
                <div class="col-4">
                    <select name="sucursales" id="sucursales" class="form-control select2 sucursales" style="width: 100%">
                        @if ($defoScu == "")
                            <option value="" selected>Todas</option>
                            @foreach ($sucursales as $suc)
                            <option value="{{$suc->id}}">{{$suc->name}}</option>
                            @endforeach
                        @else
                            <option value="">Todas</option>
                            @foreach ($sucursales as $suc)
                            @if ($suc->id == $defoScu)
                            <option value="{{$suc->id}}" selected>
                                {{$suc->name}}</option>
                            @else
                            <option value="{{$suc->id}}">
                                {{$suc->name}}</option>
                            @endif
                            @endforeach
                        @endif
                       
                    </select>
                    <input type="hidden">
                    <x-jet-input-error for="titulo" />
                </div>
            </div>
            <div class="form-row mb-1">
                <div class="col-8"></div>
                <div class="col-2">
                    <div class="col-4 form-inline" id="loader_WH">
                        <div class="loader"></div>
                        <button type="button" class="btn btn-primary" onclick="getdatacuenta()" id="get_lis">Buscar</button>
                    </div>                   
                </div>
            </div>
            
        </form>
    </div>
</div>