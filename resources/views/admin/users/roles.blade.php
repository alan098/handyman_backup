@extends('adminlte::page')

@section('title', 'Usuarios')


@section('content_header')
    <h1>Asignar un Rol</h1>
@stop

@section('content')


    @if(session('info'))
        <script>
            toastr.options = { "closeButton": true, };
            toastr.success(session('info'), 'Buen Trabajo!');
        </script>
    @endif


    <div class='card'>
        <div class='card-body'>
            <p class="h5">Nombre</p>
            <p class="form-control">{{ $user->name }}</p>

            <h2 class="h5">Listado de Roles</h2>
            {!! Form::model($user, [ 'method' => 'put', 'route' => ['admin.users.syncroles', $user]]) !!}
            <div class="col-3">
                <ul class="list-group">
                    @foreach ($roles as $rol)
                        <div>
                                <li class="list-group-item">
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="getAccesos( {{ $rol->id }} )"><i class="fa fa-search"></i></button>
                                    &nbsp;
                                    {!! Form::checkbox('roles[]', $rol->id, null, ['class' => 'mr1']) !!}
                                    &nbsp;
                                    {{ ucwords($rol->name) }}
                                    &nbsp;
                                </li>
                        </div>
                    @endforeach
                </ul>
            </div>
            {!! Form::submit('Asignar', ['class' => 'btn btn-primary mt-2']) !!}
            {!! Form::close() !!}

        </div>
    </div>


<!-- Button trigger modal -->


  <!-- Modal -->
  <div class="modal fade" id="permisosModal"   role="dialog" aria-labelledby="permisosModalTitle" aria-hidden="true">
    <div class="modal-dialog agrandar" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="permisosModalTitle"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="permisosModalBody">
            <div class="col-12">
                <ul class="list-group" id="permisosModalList">
                </ul>
            </div>
        </div>
      </div>
    </div>
  </div>



@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        @if(session('info'))
            toastr.options = { "closeButton": true, };
            toastr.success( '{{ session('info') }}', 'Buen Trabajo!');
        @endif

        function getAccesos( id ){
            var ruta = '/admin/roles/' + id ;
            getData(ruta).then(function(rta){
                console.log('getData OK'); console.log(rta);


                var html = '';
                var permisos = rta.permissions;
                $.each(permisos, function(i, val){
                    html += '<li class="list-group-item">' + val.description + '</i>';
                });



                var cadenaNombre = rta.name;
                $('#permisosModalTitle').html( cadenaNombre.toUpperCase() );
                $('#permisosModalList').html( html );
                $('#permisosModal').modal('show');
            }).catch(function(error){
                console.log('getData dio error'); console.log(error);
                Swal.fire('Ocurrio un Error', error.message, 'error');
            });
        }


    </script>

@stop
