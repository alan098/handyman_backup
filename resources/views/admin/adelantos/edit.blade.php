@extends('adminlte::page')


{{-- @dd( $gasto->ops ) --}}


{{-- @section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop --}}

@section('content_header')
   <div class="mt-n1"></div>
@stop

@section('content')

    <div class="container">
        <div class="card">
            <form action="{{ route('admin.adelantos.update') }}" id="gastosForm" method="POST">
                <input type="hidden" id="id" name="id" value="{{ $adelanto->id }}">
                <div class="card-header">
                    <h3 class="card-title">Adelanto</h3>
                    <div class="card-tools">
                        <!-- Collapse Button -->
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @include('admin.adelantos.form')
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-secondary">
                        <i class="fa fa-ban"></i>
                        Cancelar
                    </button>

                    <div class="float-right">
                        @if (Auth()->user()->id == $adelanto->para)
                            <button type="submit" class="btn btn-primary" id="sumbitButton">
                                <span id="submitSpinner" class="spinner-border-sm" role="status" aria-hidden="true"></span>
                                <i class="fa fa-save" aria-hidden="true"></i>
                                Recibir de adelanto
                            </button>
                        @else
                            <b>Solo a quien va destinado el adelanto puede aceptar</b>
                        @endif
                       
                    </div>
                </div>
            </form>
        </div>
    </div>

@stop





