@extends('adminlte::page')

@section('title', 'Bienvenido')
@section('content')
<p>Bienvenido.</p>
<main>
    {{ $slot }}
</main>
@stop

@section('css')
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
<script>
    console.log('Hi!');

            // Swal.fire('Good job!','You clicked the button!','success');

</script>

@stop
