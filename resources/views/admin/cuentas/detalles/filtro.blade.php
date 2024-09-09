<div class="card shadow mb-3 col-md-12">
    <div class="card-header">
        <x-cabecera>
            <x-slot name='title'>
             <p> 
                <h4>
                       <i class="fa fa-users" aria-hidden="true"></i>
                    Cliente: {{$cli->name }}
                        <i class="fas fa-id-card"></i>
                    Ruc: {{$cli->ruc}}    
                    <i class="fas fa-calendar-alt"></i>
                    Fecha: {{$events->fecha}}
                </h4>
             </p>
            </x-slot>
            <x-slot name='subtitle'>
                
            </x-slot>
        </x-cabecera>
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-productos-tab" data-toggle="pill" href="#pills-productos"
                    role="tab" aria-controls="pills-productos" aria-selected="true">
                    <h3>Servicios</h3>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-datos-tab" data-toggle="pill" href="#pills-datos" role="tab"
                    aria-controls="pills-datos" aria-selected="false">
                    <h3>Productos</h3>
                </a>
            </li>
        </ul>
        <form id="formCrudModal">
            <div class="tab-content" id="pills-tabContent">
                {{-- servicios --}}
                <div class="tab-pane fade show active" id="pills-productos" role="tabpanel"
                    aria-labelledby="pills-productos-tab">
                    <div class="card shadow mb-3 col-md-12">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-7">
                                    <div class="form-row mb-1">
                                        <div class="col-4">
                                            <x-jet-label value="Tipo Servicio:" />
                                        </div>
                                        <div class="col-8">
                                            <select id="articulo" class=" form-control select2" style="width: 100%">
                                                <option value="null">Elija un Servicio</option>
                                                <optgroup label="Servicios">
                                                    @foreach ($servicios as $ser)
                                                    <option value="{{ $ser->id }}">{{ $ser->name
                                                        }}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row mb-1">
                                        <div class="col">
                                            <x-jet-label value="Colaborador:" />
                                        </div>
                                        <div class="col">
                                            <select id="colaborador" class="form-control select2" style="width: 100%">
                                                <option value="null">Elija un Colaborador
                                                    defecto</option>
                                                <optgroup label="Colaborador">
                                                    @foreach ($colaboradores as $col)
                                                    <option value="{{ $col->id }}">{{ $col->name
                                                        }}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row mb-1">
                                        <div class="col">
                                            <x-jet-label value="Importe:" />
                                        </div>
                                        <div class="col">
                                            <x-jet-input type='text' id="precio" class="form-control " readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-row mb-1">
                                        <div class="col">
                                            <x-jet-label value="Inicio:" />
                                        </div>
                                        <div class="col">
                                            <x-jet-input type='time' id="ini_show"
                                                class="form-control " />
                                        </div>
                                    </div>
                                    <div class="form-row mb-1">
                                        <div class="col">
                                            <x-jet-label value="Fin:" />
                                        </div>
                                        <div class="col">
                                            <x-jet-input type='time'  id="fin_show"
                                                class="form-control " readonly />
                                        </div>
                                    </div>
                                    <div class="form-row mb-1">
                                        <div class="col">
                                            <x-jet-label value="Duracion:" />
                                        </div>
                                        <div class="col">
                                            <x-jet-input type='text' id="duracion_show" class="form-control "
                                                readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <button id="add-detalle" type="button" class="btn btn-primary m-r-sm"
                                        onclick="agregraDetalle()"><i class="fa fa-check"></i>
                                        Agregar al
                                        detalle
                                    </button>
                                </div>
                            </div>
                            {{-- tablas --}}
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="tabla-lista">
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- productos --}}
                <div class="tab-pane fade" id="pills-datos" role="tabpanel" aria-labelledby="pills-datos-tab">
                    <div class="card shadow mb-3 col-md-12">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-7">
                                    <div class="form-row mb-1">
                                        <div class="col-4">
                                            <x-jet-label value="Producto:" />
                                        </div>
                                        <div class="col-8">
                                            <select id="producto_id" class="select2 form-control" style="width: 100%">
                                                <option value="null">Elija un producto o Servicio</option>
                                                <optgroup label="Productos">
                                                    @foreach ($articulos as $pro)
                                                    @if ( $pro->tipo == 'producto' )
                                                    <option value="{{ $pro->id }}"> {{ $pro->name }} </option>
                                                    @endif
                                                    @endforeach
                                                </optgroup>
                                                <optgroup label="Combos">
                                                    @foreach ($articulos as $com)
                                                    @if ( $com->tipo == 'combo' )
                                                    <option value="{{ $com->id }}">{{ $com->name }}</option>
                                                    @endif
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-row mb-1">
                                        <div class="col">
                                            <x-jet-label value="Cantidad Disponible:" />
                                        </div>
                                        <div class="col">
                                            <x-jet-input type='text' class="form-control "  value="0" disabled id="cantidad_dis" />
                                        </div>
                                    </div>
                                    <div class="form-row mb-1">
                                        <div class="col">
                                            <x-jet-label value="Deposito:" />
                                        </div>
                                        <div class="col">
                                            <select id="deposito_id" class="select2 form-control" style="width: 100%">
                                                    @foreach ($depositos as $dep)
                                                        <option value="{{ $dep->id }}"> {{ $dep->name }} </option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row mb-1">
                                        <div class="col">
                                            <x-jet-label value="Cantidad Deseada:" />
                                        </div>
                                        <div class="col">
                                            <x-jet-input type="number" class="form-control " value="1" id="cantidad_pro" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <button id="add-detalle" type="button" class="btn btn-primary m-r-sm" onclick="agregraDetalleProducto()"><i class="fa fa-check"></i>
                                        Agregar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>