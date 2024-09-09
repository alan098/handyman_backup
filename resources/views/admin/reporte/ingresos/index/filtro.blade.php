<div class="card shadow mb-3 col-md-12 text-black" style="background: #7EC0EE;">
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
        <form>
            <div class="form-row mb-1">
                <div class="col-sm-1" style="display: none; float: right;" id="esperando">
                    <div class="loader"></div>
                </div>
            </div>
            <div class="form-row mb-1">
                <div class="col-2">
                    <x-jet-label value="Sucursal" />
                </div>
                <div class="col-4">
                    <select name="sucursales" id="sucursales" class="form-control select2 sucursales"
                        style="width: 100%">
                        <option value="" selected>Todas</option>
                        @foreach ($sucursales as $suc)
                            @if ($suc->id == Auth()->user()->sucursal_id)
                                <option value="{{ $suc->id }}" >
                                    {{ $suc->name }}</option>
                            @else
                                <option value="{{ $suc->id }}">
                                    {{ $suc->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    <input type="hidden">
                    <x-jet-input-error for="titulo" />
                </div>
            </div>
            <div class="form-row mb-1">
                <div class="col-2">
                    <x-jet-label value="Colaborador:" />
                </div>
                <div class="col-4">
                    <select name="colaborador_id" id="colaborador_id" class="form-control select2" style="width: 100%"
                        >
                        <option value="" selected >Todos</option>
                        <optgroup label="Clientes">
                            @foreach ($colaborador as $cli)
                                <option value="{{ $cli->id }}">{{ $cli->ruc }}-{{ $cli->name }}</option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>
            </div>
            <div class="form-row mb-2 mt-2" >
                <div class="col-3 border-1">
                    <div class="form-check">
                        <input class="form-check-input " type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="a" onclick="marcas(this)" checked>
                        <label class="form-check-label" for="flexRadioDefault2">
                          Por Años  
                        </label>
                      </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" onclick="marcas(this)" value="f" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1">
                          Por Fechas
                        </label>
                      </div>
                     
                </div>
            </div> 
            <div class="form-row mb-2 mt-2" id="por_fecha" style="display: none">
                <div class="col-2">
                    <x-jet-label value="Fecha Desde:" />
                </div>
                <div class="col-3">
                    <input autocomplete="off" type="date" class="form-control form-control-sm" id="fecha_desde"
                        value="{{ date('Y-m-d') }}" name="fecha_desde">
                </div>
                <div class="col-2">
                    <x-jet-label value="Fecha Hasta:" />
                </div>
                <div class="col-3">
                    <input autocomplete="off" type="date" class="form-control form-control-sm " id="fecha_hasta"
                        value="{{ date('Y-m-d') }}" name="fecha_hasta">
                </div>
            </div>
            <div class="form-row mb-2 mt-2" id="por_anho">
                <div class="col-2">
                    <x-jet-label value="Mes y año desde:" />
                </div>
                <div class="col-3">
                    <input type="month" id="anho_desde" class="form-control"/>
                </div>
                <div class="col-2">
                    <x-jet-label value="Mes y año hasta:" />
                </div>
                <div class="col-3">
                   
                    <input type="month" id="anho_hasta" class="form-control"/>
                </div>
            </div>
            <hr>
            <style>
                .loader {
                    border: 16px solid #f3f3f3;
                    border-radius: 50%;
                    border-top: 16px solid blue;
                    border-right: 16px solid green;
                    border-bottom: 16px solid red;
                    border-left: 16px solid pink;
                    width: 80px;
                    height: 80px;
                    -webkit-animation: spin 2s linear infinite;
                    animation: spin 2s linear infinite;
                    position: relative;
                
                  }
                  @-webkit-keyframes spin {
                      0% { -webkit-transform: rotate(0deg); }
                      100% { -webkit-transform: rotate(360deg); }
                  }
                  @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                  }
                
                  </style>
            <div class="form-row mb-1">
                <div class="col-sm-1"  float: right;" id="esperando">
                    <div class="loader"></div>
                </div>
            </div>
            <div class="form-row mb-1">
                <div class="col-7">
                    <button class="btn btn-primary" onclick="tablesRecarge()" type="button"> Filtrar</button>
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-primary" id="descargar" onclick="descargarExcel()">Ver Reporte</button>
                </div>
            </div>
        </form>
    </div>
</div>
