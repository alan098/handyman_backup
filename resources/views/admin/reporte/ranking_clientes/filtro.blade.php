<div class="card shadow mb-3 col-md-12 text-black bg-info">
    <div class="card-header">
        <h3>RANKING DE CLIENTES</h3>
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
                                <option value="{{ $suc->id }}">
                                    {{ $suc->name }}</option>
                            @else
                                <option value="{{ $suc->id }}">
                                    {{ $suc->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    <x-jet-input-error for="titulo" />
                </div>
            </div>
            <div class="form-row mb-1 mt-1">
                <div class="col-2">
                    <x-jet-label value="Clientes:" />
                </div>
                <div class="col-4">
                    <select class="js-data-clientes-ajax" aria-placeholder="Hola" style="width: 100%" name="cliente_id" id="cliente_id">
                    </select>
                </div>
            </div>
            <div class="form-row mb-2 mt-2">
                <div class="col-2">
                    <x-jet-label value="Fecha Desde:" />
                </div>
                <div class="col-3">
                    <input autocomplete="off" type="date" class="form-control form-control-sm" id="desde"
                        value="{{ date('Y-m-d') }}" name="fecha_desde">
                </div>
                <div class="col-2">
                    <x-jet-label value="Fecha Hasta:" />
                </div>
                <div class="col-3">
                    <input autocomplete="off" type="date" class="form-control form-control-sm " id="hasta"
                        value="{{ date('Y-m-d') }}" name="fecha_hasta">
                </div>
            </div>
            <div class="form-row mb-1 mt-1">
                <div class="col-2">
                    <x-jet-label value="VISITAS MAYORES QUE:" />
                </div>
                <div class="col-2">
                   <input type="text" id="mayor_a_v" class="form-control siempreCero text-right" value="0">
                    <x-jet-input-error for="titulo" />
                </div>
                <div class="col-2">
                    <x-jet-label value="VISITAS MENORES QUE" />
                </div>
                <div class="col-2">
                    <input type="text" id="menor_que_v" class="form-control siempreCero text-right" value="0">
                     <x-jet-input-error for="titulo" />
                 </div>
                 <div class="col-2">
                    {{-- <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" id="activo_v" name="activo_v" >
                        <label for="activo_v" class="custom-control-label">Activar Filtro?</label>
                    </div> --}}
                 </div>
            </div>
          
            <div class="form-row mb-1 mt-1">
                <div class="col-2">
                    <x-jet-label value="MONTO MAYORES A:" />
                </div>
                <div class="col-2">
                   <input type="text" id="mayor_a_m" class="form-control siempreCero text-right" value="0">
                    <x-jet-input-error for="titulo" />
                </div>
                <div class="col-2">
                    <x-jet-label value="MONTO MENORES A" />
                </div>
                <div class="col-2">
                    <input type="text" id="menor_que_m" class="form-control siempreCero text-right" value="0">
                     <x-jet-input-error for="titulo" />
                 </div>
                 <div class="col-2">
                    {{-- <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" id="activo_m" name="activo_m" >
                        <label for="activo_m" class="custom-control-label">Activar Filtro?</label>
                    </div> --}}
                 </div>
            </div>
          

    </div>
    <div class="card-footer  bg-info">
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
                0% {
                    -webkit-transform: rotate(0deg);
                }

                100% {
                    -webkit-transform: rotate(360deg);
                }
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }
        </style>
        <div class="form-row mr-0 ml-0" style="padding: 0%">
            <div class="col-7">
                {{-- <button type="button" class="btn btn-light" id="descargar" onclick="descargarExcel()">Ver
                    Reporte</button> --}}
            </div>
            <div class="col-1" float: right;" id="esperando">
                <div class="loader"></div>
            </div>
            <div class="col-2">
                <button class="btn btn-success text-dark" onclick="filtrar()" type="button"> Filtrar</button>
            </div>
        </div>
        
    </div>
    </form>
</div>
