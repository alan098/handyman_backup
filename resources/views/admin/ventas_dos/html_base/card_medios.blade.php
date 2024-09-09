<div class="card">
    <div class="card-header">
        Datos de la venta Factura
    </div>
    <div class="card-body">
        <div class="form-row mb-1">
            <div class="col-4">
                <x-jet-label value="Fecha:" />
            </div>
            <div class="col-8">
                <x-jet-input type='text' id="fecha" name="fecha_venta"  value="{{date('Y-m-d')}}" class="form-control" type='date' />
            </div>
        </div>
        <div class="form-row mb-1">
            <div class="col-4">
                <x-jet-label value="Condicion de Venta:" />
            </div>
            <div class="col-8">
                <select class="form-control" style="width: 100%; font-size: 20px !important;" required name="condicion_venta">
                    @foreach($condiciones as $cond)
                    <option value="{{$cond->id}}">{{$cond->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row mb-1">
            <div class="col-4">
                <x-jet-label value="Forma de Cobro:" />
            </div>
            <div class="col-8">
                <button id="medios_pagos" class="btn btn-secondary float-right" type="button" data-toggle="modal" data-target="#modal_medios_pagos"> Agregar metodos de pagos <i class="fas fa-plus"></i></button>
            </div>
        </div>
        <div class="form-row mb-1">
            <div class="col-12">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th colspan="1"></th>
                            <th scope="col">Total Medios</th>
                            <th scope="col"><input class="form-control" type="text" id="input-total-fuera" readonly ></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        @if (!$factura)
            <div class="form-row mb-1">
                <div class="col-4">
                    <x-jet-label value="Timbrado:" />
                </div>
                <div class="col-8">
                    @if (count($timbrados))
                        <select class="form-control" style="width: 100%; font-size: 20px !important;" required id="timbrado_id" name="timbrado_id">
                            @foreach($timbrados as $tim)
                                <option value="{{$tim->timbrado_id}}">{{$tim->numero_timbrado}}</option>
                            @endforeach
                        </select>
                    @else
                        <x-jet-input type='text' value="NO EXISTEN TIMBRADOS ACTIVOS"  class="form-control"  readonly />
                    @endif   
                </div>
            </div>
            <div class="form-row mb-1">
                <div class="col-4">
                    <x-jet-label value="Numero de Factura:"/>
                </div>
                <div class="col-8">
                    <x-jet-input type='text' id="numero_timbrado" name="numero_timbrado"  class="form-control"  />
                    <x-jet-input type='hidden' id="numero_timbrado_real" name="numero_timbrado_real"  class="form-control"   />
                </div>
            </div> 
        @endif 
    </div>
</div>