<div class="card shadow mb-3 col-md-12">
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
            {{-- <  div class="form-row mb-1">
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
            <div class="form-row mt-2 mb-2">
                <div class="col-2 ">
                    <x-jet-label value="Tipo de Transferencias:" />
                </div>
                <div class="col-4">
                    <select name="filtro" id="filtro" class="form-control">
                        <option value="1" selected>Enviadas</option>
                        <option value="2">En Transito</option>
                        <option value="3">Recibidas</option>
                    </select>
                </div>
            </div>
            <hr>
            <div class="form-row mb-1">
                <div class="col-7"></div>
                <div class="col">
                    <button class="btn btn-primary" onclick="buscar()" type="button">Buscar</button>
                </div>
            </div>

        </form>
    </div>
</div>
