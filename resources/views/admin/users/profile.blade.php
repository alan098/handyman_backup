@extends('adminlte::page')

@section('title', 'Usuarios')

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('content_header')
<h1>Usuarios</h1>
@stop
comunes
@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12 order-lg-1">

        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Mi Cuenta</h6>
            </div>

            <div class="card-body">

                <h6 class="heading-small text-muted mb-4">Informacion de Usuario</h6>

                <div class="pl-lg-4">
                    <form method="POST" action="{{ route('admin.configuracion.entidad') }}" autocomplete="off">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id_usuario" id="id_usuario" value="{{Auth::user()->id}}">

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="name">Nombre<span
                                            class="small text-danger">*</span></label>
                                    <input type="text" id="name" class="form-control" name="name" placeholder="Name"
                                        value="{{ old('name', Auth::user()->name) }}">
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="current_password">Entidades*</label>
                                    <select name="entidad_id" id="entidad_id" class="form-control" required>
                                        @foreach($entidades as $l)
                                        @if ($l->id == Auth::user()->entidad_id)
                                        <option value="{{ $l->id }}" selected>{{ $l->name }}</option>
                                        @else
                                        <option value="{{ $l->id }}">{{ $l->name }}</option>

                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="new_password">Sucursales*</label>
                                    <select name="sucursal_id" id="sucursal_id" class="form-control" required>
                                        @foreach($sucursal as $l)
                                        @if ($l->id == Auth::user()->sucursal_id)
                                        <option value="{{ $l->id }}" selected>{{ $l->name }}</option>
                                        @else
                                        <option value="{{ $l->id }}">{{ $l->name }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="confirm_password">Depositos*</label>
                                    <select name="deposito_id" id="deposito_id" class="form-control" required>
                                        @foreach($depositos as $l)
                                        @if ($l->sucursal_id == Auth::user()->sucursal_id)
                                        @if ($l->id == Auth::user()->deposito_id)
                                        <option value="{{ $l->id }}" selected>{{ $l->name }}</option>
                                        @else
                                        <option value="{{ $l->id }}">{{ $l->name }}</option>
                                        @endif
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col text-center">
                                    <button type="submit" class="btn btn-primary">Guardar Perfil</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    {{-- contraseñas --}}
                    <hr>
                    <p>Cambio Contraseña</p>
                    <hr>
                    <form method="POST" action="{{ route('admin.configuracion.pass') }}" autocomplete="off">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id_usuario" id="id_usuario" value="{{Auth::user()->id}}">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="current_password">Contraseña Actual</label>
                                    <input type="password" id="current_password" class="form-control"
                                        name="current_password" placeholder="Current password">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="new_password">Nueva Contraseña</label>
                                    <input type="password" id="new_password" class="form-control" name="new_password"
                                        placeholder="New password">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="confirm_password">Confirmar
                                        Contraseña</label>
                                    <input type="password" id="confirm_password" class="form-control"
                                        name="password_confirmation" placeholder="Confirm password">
                                </div>
                            </div>
                        </div>
                        <!-- Button -->
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col text-center">
                                    <button type="submit" class="btn btn-primary">Guardar Contraseña</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('js')
<script>
    $(document).ready(function (){
    @php
        echo ' var entidades = '.json_encode($entidades).'; ';
        echo ' var sucursales = '.json_encode($sucursal).'; ';
        echo ' var depositos = '.json_encode($depositos).'; ';
    @endphp
            $("#entidad_id").change(function() {
                var numero_entidad=$('#entidad_id').val();
                        $('#sucursal_id option').remove().promise().done(function(){
                        $.each(sucursales, function(i, item) {
                            if (numero_entidad == item.entidad_id) {
                                $("#sucursal_id").append("<option value="+item.id+">"+item.name+"</option>");
                            }
                            
                        });
                    });
                        $('#deposito_id option').remove().promise().done(function(){
                        $.each(depositos, function(i, item) {
                            if (numero_entidad == item.entidad_id) {
                                if ($("#sucursal_id").val() == item.sucursal_id) {
                                        $("#deposito_id").append("<option value="+item.id+">"+item.name+"</option>");
                                }
                            }
                        
                        });
                    });
            });
            $("#sucursal_id").change(function() {
                var numero_entidad = $('#entidad_id').val();
                    $('#deposito_id option').remove().promise().done(function(){
                        $.each(depositos, function(i, item) {
                            if (numero_entidad == item.entidad_id) {
                                if ($("#sucursal_id").val() == item.sucursal_id) {
                                        $("#deposito_id").append("<option value="+item.id+">"+item.name+"</option>");
                                }
                            }   
                        });
                });
            });
    });
</script>
@stop