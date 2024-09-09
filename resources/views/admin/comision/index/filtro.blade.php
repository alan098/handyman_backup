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
            <div class="form-row mb-1">
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
            </div>
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
                    <x-jet-label value="Ver Detalles:" />
                </div>
                <div class="col-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1"
                            value="" checked>
                        <label class="form-check-label" for="exampleRadios1">
                            Productos-Servicios
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2"
                            value="servicio">
                        <label class="form-check-label" for="exampleRadios2">
                            Productos
                        </label>
                    </div>


                    <div class="form-check disabled">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3"
                            value="producto">
                        <label class="form-check-label" for="exampleRadios3">
                            Servicios
                        </label>
                    </div>
                </div>
            </div>
            <hr>
            <div class="form-row mt-2 mb-2">
                <div class="col-2 ">
                    <x-jet-label value="Agrupar por:" />
                </div>
                <div class="col-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="exampleRadiostwo" id="example1"
                            value="" checked>
                        <label class="form-check-label" for="exampleRadios1">
                            Afiliados-Colaboradores
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="exampleRadiostwo" id="example2"
                            value="afiliado">
                        <label class="form-check-label" for="exampleRadios2">
                            Afiliados
                        </label>
                    </div>
                    <div class="form-check disabled">
                        <input class="form-check-input" type="radio" name="exampleRadiostwo" id="example3"
                            value="colaborador">
                        <label class="form-check-label" for="exampleRadios3">
                            Colaboradores
                        </label>
                    </div>
                </div>
            </div>
            <hr>
            {{-- <div class="form-row mb-1">
                <div class="col-2">
                    <x-jet-label value="Sucursal" />
                </div>
                <div class="col-4">
                    <select name="sucursales" id="sucursales" class="form-control select2 sucursales"
                        style="width: 100%">
                        <option value="">Todas</option>
                        @foreach ($sucursales as $suc)
                            @if ($suc->id == Auth()->user()->sucursal_id)
                                <option value="{{ $suc->id }}" selected>
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
            </div> --}}
            <div class="form-row mt-2 mb-2">
                <form>
                    <div class="col-2 ">
                        <x-jet-label value="Comision:" />
                    </div>
                    <div class="col-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="fijo" name="comision" value="fijo" checked>
                            <label class="form-check-label" for="fijo">
                                Monto Fijo
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="cobrado"  name="comision" value="cobrado">
                            <label class="form-check-label" for="cobrado">
                                Monto Cobrado
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div></div>
            <div class="form-row mb-1 mt-5">
                <div class="col-2">
                    
                    <button type="button" class="btn btn-secondary" id="descargar" onclick="ver()" >Ver Reporte</button>
                </div>
                <div class="col">
                    <form action="{{route('admin.comisiones.pdf.save')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-inline">
                            <label for="archivo" class="ml-5 mr-5">Agregar Contrato:</label>
                            <input class="form-control" type="file" id="archivo" name="archivo" >
                            
                            <button class="btn btn-success" type="submit" id="procesar">
                                <span id="procesar_spinner" class="spinner-border-sm" role="status"
                                    aria-hidden="true"></span>
                                guardar
                            </button>
                        </div>
                    </form>
                   
                    
                </div>
            </div>

        </form>
    </div>
</div>
