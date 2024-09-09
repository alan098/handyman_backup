<div class="card shadow mb-3 col-md-12 text-black bg-info">
    <div class="card-header">
        <h3>Historial de insumos</h3>
        Seleccione un Cliente para comenzar
    </div>
    <div class="card-body">
        <form>
            <div class="form-row mb-1">
                <div class="col-sm-1" style="display: none; float: right;" id="esperando">
                    <div class="loader"></div>
                </div>
            </div>
            <div class="form-row mb-1 mt-1">
                <div class="col-2">
                    <x-jet-label value="Insumos:" />
                </div>
                <div class="col-4">
                    <select class="form-control select2"  name="insumo" id="insumo">
                        @foreach ($insumo as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
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
            <hr>
            <div class="form-row mb-2 mt-2">
                <div class="col-2">
                    <x-jet-label value="Comprarar entre fechas"/>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" id="activo" name="activo" onclick="activos(this)">
                        <label for="activo" class="custom-control-label">Activar Filtro</label>
                    </div>
                </div>
            </div>
            <div class="form-row mb-2 mt-2" id="fecha_dos" style="display: none">
                <div class="col-2">
                    <x-jet-label value="Fecha Desde:" />
                </div>
                <div class="col-3">
                    <input autocomplete="off" type="date" class="form-control form-control-sm" id="desde_c"
                        value="{{ date('Y-m-d') }}" name="fecha_desde_c">
                </div>
                <div class="col-2">
                    <x-jet-label value="Fecha Hasta:" />
                </div>
                <div class="col-3">
                    <input autocomplete="off" type="date" class="form-control form-control-sm " id="hasta_c"
                        value="{{ date('Y-m-d') }}" name="fecha_hasta_c">
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
            </div>
            <div class="col-1" float: right;" id="esperando">
                <div class="loader"></div>
            </div>
            <div class="col-2">
                <button class="btn btn-success text-dark" onclick="filtar()" type="button"> Filtrar</button>
            </div>
        </div>
        
    </div>
    </form>
</div>
