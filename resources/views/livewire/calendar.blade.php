<div wire:init="LoatCalendar">
hola
    {{-- @if (count($sucursales))
    <br>
    <div>
        <div class="card shadow mb-3 col-12">
            <div class="card-header">
                <x-cabecera>
                    <x-slot name='title'>
                        Calendario
                    </x-slot>
                    <x-slot name='subtitle'>
                        @if (count($colaboradoresEventos))
                            Elija alguno de estos para poder editar la información
                        @else
                            Seleccione un Colaborador para iniciar
                        @endif
                    </x-slot>
                </x-cabecera>
            </div>
            <style>
                .fc-event-title-container{
                    color: black !important;
                }
                .columna_colaborador{
                    max-width: 18%;
                }
                .testimonial-group > .row {
                    display: block;
                    overflow-x: auto;
                    white-space: nowrap;
                }
                .testimonial-group > .row > .col-4 {
                display: inline-block;
                }
        
            </style>
            <div class="card-body">
                <div id="id_calendar">
                    <div class="row">
                        <div class="col-12">
                                <div class="container testimonial-group col-12">
                                    <div class="row scroll" id="calendar_map">
                                                @if (count($colaboradoresEventos))
                                                @foreach ($colaboradoresEventos as $col)
                                                <div class="col-4 columna_colaborador_{{$col->id}} columna_colaborador" >
                                                <div class="form-row container-fluid">
                                                <div class="col-"></div>
                                                <div class="col-4">
                                                <h4>
                                                <strong>{{$col->name}}</strong>
                                                </h4>
                                                <div class="col-4"></div>
                                                </div>
                                                <div id="agenda_numero_{{$col->id}}" colaborador="{{$col->id}}" cliente=""></div>
                                                </div>
                                                </div>
                                                @endforeach
                                                @else
                                                <div>
                                                Ahun no existen eventos
                                                </div>
                                                @endif   
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @else
    <h3>Cargando...</h3>
    @endif --}}
</div>