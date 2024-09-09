<div class="card shadow mb-3 col-md-12"  style="background: #bf6b99;">
    <div class="card-header">
        <x-cabecera>
            <x-slot name='title'>
                Elija Eventos que desee crear cuenta
            </x-slot>
            <x-slot name='subtitle'>
                
            </x-slot>
        </x-cabecera>
    </div>
    <div class="card-body">
        <form>
            <div class="form-row mb-1">
                <div class="col-2">
                    <x-jet-label value="Clientes"/>
                </div>
                <div class="col-4">
                    <select class="js-data-clientes" style="width: 100%" id="cliente_evento_id">
                    </select>
                </div>
            </div>
            <div class="form-row mb-1">
                <div class="col-2">
                    <x-jet-label value="Fecha Desde:"/>
                </div>
                <div class="col-3">
                    <input autocomplete="off" type="date" class="form-control form-control-sm" id="fecha_desde_evento" value="{{date("Y-m-d")}}">
                </div>
                <div class="col-2">
                    <x-jet-label value="Fecha Hasta:"/>
                </div>
                <div class="col-3">
                    <input autocomplete="off" type="date" class="form-control form-control-sm" id="fecha_hasta_evento" value="{{date("Y-m-d")}}" >
                </div>
            </div>
            <div class="form-row mb-1">
                <div class="col-8"></div>
                <div class="col-2">
                    <div class="col-4 form-inline" id="loader_WH">
                        <div class="loader"></div>
                        <button type="button" class="btn btn-primary" onclick="getdataevento()">Buscar</button>
                    </div>                   
                </div>
            </div>
        </form>
    </div>
</div>