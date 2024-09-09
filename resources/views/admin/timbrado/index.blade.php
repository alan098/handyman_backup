@extends('adminlte::page')

@section('title', 'Agendas')


@section('content_header')

@stop

@section('content')
<!-- Breadcrumb-->
@if(session('info'))
<div class="alert alert-success">
    {{ session('info') }}
</div>
@endif
<form action="{{route('admin.timbrados.store')}}" id="timbrados" method="POST">
  @csrf
<div class="breadcrumb-holder">
    <ul class="breadcrumb" style="background-color: transparent; padding-top: 0; padding-bottom: 0;">
      <li class="breadcrumb-item"><a href="/">Home</a></li>
      <li class="breadcrumb-item active">Timbrado</li>
    </ul>
</div>

<div class="col-sm-3" style="float: left;">
  <div class="card shadow mb-4" >
    <div class="card-header py-3" style="padding: 5px 10px 5px 10px !important;">
      Timbrado
    </div>

    <div class="card-body">
      <div class="form-group">
        <label style="margin-bottom: 0;">Número de timbrado</label>
        <input id="nro_timbrado" name="nro_timbrado" type="text" placeholder="Ej. 154322345" class="mr-3 form-control form-control-sm" required> 
      </div>

      <div class="form-group">
        <label style="margin-bottom: 0;">Fecha desde</label>
        <input id="fecha_desde_timbrado" name="fecha_desde_timbrado" type="date" class="mr-3 form-control form-control-sm" required>
      </div>

      <div class="form-group">
        <label style="margin-bottom: 0;">Fecha hasta</label>
        <input id="fecha_hasta_timbrado" name="fecha_hasta_timbrado" type="date" class="mr-3 form-control form-control-sm" required>
      </div>
    </div>
    <div class="card-footer">
      <button type="submit" class="mr-3 btn btn-primary">Agregar</button>
    </div>
  </div>
</div>
</form>

<div class="col-sm-9" style="float: left;">
  <div class="card shadow mb-4" >
    <div class="card-header py-3" style="padding: 5px 10px 5px 10px !important;">
      Timbrados
    </div>

    <div class="card-body">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Numero de Timbrado</th>
              <th>Esta Activo</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody class="table-timbrado">
            @if ($timbrados_existentes)
              @foreach ($timbrados_existentes as $ti)
                  <tr>
                    <td>{{$ti->numero_timbrado}}</td>
                      @if ($ti->es_activo == true)
                      <td>SI</td> 
                      @else
                      <td>No</td>
                      @endif
                   <td>
                     <a href="{{ route('admin.timbrados.get_data', ['timbrado' => $ti->id]) }}" class="btn btn-primary btn-2">Editar</a>
                   </td>
                  </tr>
              @endforeach 
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.css">
@stop
