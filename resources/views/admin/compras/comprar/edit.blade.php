@extends('adminlte::page')




@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('content_header')
   <div class="mt-n1"></div>
@stop

@section('content')

    <div class="container">
        <div class="card">
            <form action="{{ route('admin.compras.update') }}" id="comprasForm" method="POST">
                <input type="hidden" id="id" name="id" value="{{ $compra->id }}">
                <input type="hidden" id="concluido" name="concluido" value="false">
                <div class="card-header">
                    <h3 class="card-title">Comprar</h3>
                    <div class="card-tools">
                        <!-- Collapse Button -->
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @include('admin.compras.comprar.form')
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-secondary">
                        <i class="fa fa-ban"></i>
                        Cancelar
                    </button>
                @if (!$compra->concluido)
                    <div class="float-right">
                        <button type="submit" class="btn btn-primary" id="sumbitButton">
                            <span id="submitSpinner" class="spinner-border-sm" role="status" aria-hidden="true"></span>
                            <i class="fa fa-save" aria-hidden="true"></i>
                            Guardar
                        </button>
                        <button type="button" class="btn btn-primary" id="cerr_gua">
                            <span  class="spinner-border-sm" role="status" aria-hidden="true"></span>
                            <i class="fa fa-save" aria-hidden="true"></i>
                            Guardar y Cerrar
                        </button>
                    </div> 
                @endif
                </div>
            </form>
        </div>
    </div>

@stop





