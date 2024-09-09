<div class="card  mt-2">
    <div class="card-header  bg-info">
        <x-cabecera>
            <x-slot name='title'>
                Calendario
            </x-slot>
            <x-slot name='subtitle'>
                Seleccione un Colaborador para iniciar
            </x-slot>
        </x-cabecera>
        <button class="btn btn-secondary" id="combo_promo" data-toggle="modal" data-target="#promo_combo_edit">Combos Y Promos</button>
    </div>
    <div class="card-body " style="background: #bf6b99;">
        <div id="id_calendar">
            <div class="row">
                <div class="col-12">
                    <div class="wrapper1">
                        <div class="div1">
                        </div>
                    </div>
                    <div class="container testimonial-group col-12">
                        <div class="row scroll wrapper2" id="calendar_map" style="background: #ffffff;">
                            @foreach ($colaboradores as $col)
                                <div class="col-4 columna_colaborador_{{ $col->id }} columna_colaborador"
                                    {{-- @if ($cole->seleccionado == true) mostrado="si"  @else mostrado="no" @endif --}}
                                     
                                     >
                                    <div class="form-row container-fluid">
                                        <div class="col-"></div>
                                        <div class="col-4">
                                            <h4>
                                                <strong>{{ $col->name }}</strong>
                                            </h4>
                                            <div class="col-4"></div>
                                        </div>
                                        <div id="agenda_numero_{{ $col->id }}" colaborador="{{ $col->id }}"
                                            cliente=""></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
