<div class="card">
    <div class="card-header">
        <div class="form-row">
            <div class="col">Cliente
                <button type="button" class="btn btn-secondary" data-toggle="modal"
                    data-target="#modal_persona"><i class="fa fa-plus"></i>
                </button>
            </div>
            <div class="col">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" onclick="facCon(this)">
                    <label class="form-check-label" for="flexCheckDefault">
                      Factura Contacto
                    </label>
                  </div>
            </div>
        </div>
    </div>
    <div id="form-cliente">
        <div class="card-body">
            <div class="form-row mb-1">
                <div class="col-4">
                    <x-jet-label value="Clientes:" />
                </div>
                <div class="col-8">
                    <select class="js-data-clientes-ajax" style="width: 100%" name="cliente_id" id="cliente_id"
                        required>
                    </select>
                </div>
            </div>
            <div class="form-row mb-1">
                <div class="col-4">
                    <x-jet-label value="Nombre:" />
                </div>
                <div class="col-8">
                    <x-jet-input type='text' class="form-control" id="persona_name" type='text' readonly />
                </div>
            </div>
            <div class="form-row mb-1">
                <div class="col-4">
                    <x-jet-label value="Direccion:" />
                </div>
                <div class="col-8">
                    <x-jet-input type='text' class="form-control" type='text' id="persona_direcion" readonly />
                </div>
            </div>
            <div class="form-row mb-1">
                <div class="col-4">
                    <x-jet-label value="Telefono:" />
                </div>
                <div class="col-8">
                    <x-jet-input type='text' class="form-control" type='text' id="persona_telefono" readonly />
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer" style="display: none" id="factura_contacto" >
        <div class="form-row mb-1">
            <div class="col-4">
                <x-jet-label value="Clientes:" />
            </div>
            <div class="col-8">
                <select name="cliente_contacto" id="cliente_contacto" class="form-control select2" style="width: 100%">
                    {{-- @if (isset($cerrada))
                        <option value="{{$cerrada->persona->id}}"> {{$cerrada->persona->ruc}}-{{$cerrada->persona->name}}</option>
                    @endif --}}
                </select>
                <input type="hidden" id="es_contacto" name="es_contacto" value="no">
            </div>
        </div>
        <div class="form-row mb-1">
            <div class="col-4">
                <x-jet-label value="Telefono:" />
            </div>
            <div class="col-8">
                <x-jet-input type='text' class="form-control" type='text'  readonly />
            </div>
        </div>
      
    </div>
    {{-- <div class="row container" id="gentileza" style="visibility: hidden;">
        <div class="form-row" >
            <div class="col-6 border">
                  <img  src="{{ asset('img/detalles/gentileza.png') }}" class="img-fluid">
            </div>
        </div>
    </div> --}}
</div>
