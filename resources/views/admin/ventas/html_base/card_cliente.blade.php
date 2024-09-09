<div class="card">
    <div class="card-header">
        Cliente
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal_persona"
        @if (isset($id_venta) && ($cerrada->concluido == true) )
        disabled
        @endif
        @if (isset($gifDe))   disabled @endif
        ><i class="fa fa-plus"></i></button>
    </div>
    <div  id="form-cliente">
        <div class="card-body">
            <div class="form-row mb-1">
                <div class="col-4">
                    <x-jet-label value="Clientes:" />
                    
                </div>
                <div class="col-8">
                    <select name="cliente_id" id="cliente_id" class="form-control select2" style="width: 100%" required  
                    @if (isset($id_venta) && ($cerrada->concluido == true) )
                        disabled
                    @endif
                    @if (isset($gifDe))   disabled @endif

                    >
                        <option value="null" selected disabled>Ingrese el Nombre o el Ruc</option>
                        <optgroup label="Clientes">
                            @foreach ($clientes as $cli)
                            <option value="{{ $cli->id }}">{{ $cli->ruc }}-{{
                                $cli->name }}</option>
                            @endforeach
                        </optgroup>
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
            @if (isset($gifDe))
            <div class="form-row mb-1">
                <div class="col-4">
                    <x-jet-label value="Persona a quen regalo:" />
                </div>
                <div class="col-8">
                    <x-jet-input type='text' class="form-control" type='text' id="persona_regalada" readonly />
                </div>
            </div>
            <div class="form-row mb-1">
                <div class="col-4">
                    <x-jet-label value="Numero Giftcard:" />
                </div>
                <div class="col-8">
                    <x-jet-input type='text' class="form-control" type='text' id="numero_giftcard" readonly />
                </div>
            </div>
            <div class="form-row mb-1">
                <div class="col-4">
                    <x-jet-label value="Importe del Giftcard:" />
                </div>
                <div class="col-8">
                    <x-jet-input type='text' class="form-control formatogs text-right" style="background: #90e6b5" type='text' id="importe_gif" readonly />
                </div>
            </div>
            <div class="form-row mb-1">
                <div class="col-4">
                    <x-jet-label value="Saldo del Giftcard:" />
                </div>
                <div class="col-8">
                   
                    <x-jet-input type='text' class="form-control formatogs text-right" style="background: #90e6b5" type='text' id="saldo_gif" readonly />
                </div>
            </div>
            @endif

        </div>
    </div>
    <div class="row container" id="gentileza" style="visibility: hidden;">
        <div class="form-row" >
            <div class="col-6 border">
                  <img  src="{{ asset('img/detalles/gentileza.png') }}" class="img-fluid">
            </div>
        </div>
    </div>
</div>