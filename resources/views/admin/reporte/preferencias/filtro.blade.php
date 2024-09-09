<div class="card shadow mb-3 col-md-12">
    <div class="card-header">
        <x-cabecera>
            <x-slot name='title'>
                Filtros
            </x-slot>
            <x-slot name='subtitle'>
                Elija las fechas desde y hasta para generar el reporte

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
            {{-- <div class="form-row mb-1">
                <div class="col-2">
                    <x-jet-label value="Colaborador:" />
                </div>
                <div class="col-4">
                    <select name="colaborador_id" id="colaborador_id" class="form-control select2" style="width: 100%"
                        required>
                        <option value="">Ingrese el Nombre</option>
                        <optgroup label="Clientes">
                            @foreach ($colaborador as $cli)
                                <option value="{{ $cli->id }}">{{ $cli->ruc }}-{{ $cli->name }}</option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>
            </div> --}}
            <div class="form-row mb-2 mt-2">
                <div class="col-2">
                    <x-jet-label value="Fecha Desde:" />
                </div>
                <div class="col-3">
                    <input autocomplete="off" type="date" class="form-control form-control-sm " id="fecha_desde"
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
            <hr>
            <div></div>
            <div class="form-row mb-1 mt-5">
                <div class="col-2">
                    <button type="button" class="btn btn-secondary" id="descargar" onclick="ver()" >Ver Reporte</button>
                </div>
            </div>
        </form>
    </div>
</div>
