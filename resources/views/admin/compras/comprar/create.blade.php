@extends('adminlte::page')


{{-- @dd($cuentasBancos[0]->banco->name ) --}}


@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('content_header')
   <div class="mt-n1"></div>
@stop

@section('content')

    <div class="container">
        <div class="card">
            <form action="{{ route('admin.compras.store') }}" id="comprasForm" method="POST">

                <div class="card-header">
                    <h3 class="card-title">Compras</h3>
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



