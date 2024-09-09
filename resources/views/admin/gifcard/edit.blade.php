@extends('adminlte::page')


{{-- @dd( $gasto->ops ) --}}


@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('content_header')
   <div class="mt-n1"></div>
@stop

@section('content')

@php

    $artoptions1 = '';$artoptions2 = '';$artoptions3 = ''; $mediosoptions = ''; $marcasoptions = ''; $cuentasoptions = '';
    foreach ($articulos as $pro){
    if ( $pro->tipo == 'producto' ){ $artoptions1.='<option value="'.$pro->id.'"> '.$pro->name.' </option>'; }}   
    foreach ($articulos as $pro){
    if ( $pro->tipo == 'combo' ){  $artoptions2.='<option value="'.$pro->id.'">  '.$pro->name.' </option>'; } }
    foreach ($articulos as $pro){
    if ( $pro->tipo == 'servicio' ){  $artoptions3.='<option value="'.$pro->id.'">  '.$pro->name.'  </option>'; }}
    foreach($medios as $me){ $mediosoptions .= '<option value="'. $me->id .'">'. $me->name .'</option>';
    }
    foreach ($marcasTC as $marca) {
        $marcasoptions .= '<option value="'. $marca->id .'">'. $marca->name .'</option>';
    }
    foreach ($cuentasBancos as $cuenta) {
        $name = $cuenta->name ;
        $name .= (!empty($cuenta->banco)) ? ' - ' .$cuenta->banco->name : '';
        $cuentasoptions .= '<option value="'. $cuenta->id .'">'. $name .'</option>';
    }

    
@endphp

    <div class="">
        <div class="card">
            <form action="{{ route('admin.giftcard.update') }}" id="gastosForm" method="POST">
                <input type="hidden" id="venta_id" name="venta_id" value="{{ $venta->id }}">
                <input type="hidden" id="giftcard_id" name="giftcard_id" value="{{ $gif->id }}">
                @csrf
                <div class="card-header">
                    <h3 class="card-title">Giftcard</h3>
                    <div class="card-tools">
                        <!-- Collapse Button -->
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @include('admin.gifcard.form')
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-secondary">
                        <i class="fa fa-ban"></i>
                        Cancelar
                    </button>

                    @if (isset($venta))
                        @if ($factura)
                            <button type="button" class="btn btn-primary ml-2" id="btn-factura-imprimir">Imprimir Factura</button> 
                        @else
                            <button type="button" class="btn btn-primary ml-2"  onclick="Factura()">Generar Factura</button>
                                {{-- <input type="checkbox"  id="factura_detallada">
                            <small>Factura Detallada</small> --}}
                        @endif
                    @endif
                    @if (!$factura)
                    <div class="float-right">
                        <button type="submit" class="btn btn-primary" id="sumbitButton">
                            <span id="submitSpinner" class="spinner-border-sm" role="status" aria-hidden="true"></span>
                            <i class="fa fa-save" aria-hidden="true"></i>
                            Guardar
                        </button>
                    </div>
                    @endif
                </div>
            </form>
        </div>
    </div>

@stop





