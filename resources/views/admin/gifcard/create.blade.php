@extends('adminlte::page')
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
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

    <div >
        <div class="card">
            <form action="{{ route('admin.giftcard.store') }}" id="gastosForm" method="POST">
                @csrf
                <input type="hidden" name="id_gif" value="null">
                <div class="card-header">
                    <h3 class="card-title">Gifcard</h3>
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
                    <a href="javascript:history.back()" type="button" class="btn btn-secondary">
                        <i class="fa fa-ban"></i>
                        Cancelar
                    </a>

                    <div class="float-right">
                        <button type="submit" class="btn btn-primary" id="sumbitButton">
                            <span id="submitSpinner" class="spinner-border-sm" role="status" aria-hidden="true"></span>
                            <i class="fa fa-save" aria-hidden="true"></i>
                            Guardar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop



