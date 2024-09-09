{{-- @dd($ventasTop10); --}}

@php

$total = 0;
$total = $productosMes + $serviciosMes + $combosMes;
$porcentajeProductos = ($productosMes > 0) ? round((($productosMes * 100) / $total), 2) : 0;
$porcentajeServicios = ($serviciosMes > 0) ? round((($serviciosMes * 100) / $total), 2) : 0;
$porcentajeCombos = ($combosMes > 0) ? round((($combosMes * 100) / $total), 2) : 0;

@endphp



@extends('adminlte::page')

@section('title', 'Bienvenido')



@section('content_header')
{{-- <h1>Bienvenido</h1> --}}
@stop

@section('content')
{{-- @dd($ventasPorFecha) --}}
<br>
<div class="container">
    <!-- /.indicadores -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Indicadores</h3>
            <div class="card-tools">
                <!-- Collapse Button -->
                {{-- <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                        class="fas fa-minus"></i></button> --}}
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="form-row mb-3">
                <div class="col">
                    <label for="">Cambiar de Sucursal</label>
                </div>
                <div class="col">
                    <select class="form-control" name="sucursal_change" id="sucursal_change">
                       
                        @if (Auth()->user()->todas)
                            <option value="0" selected>TODAS</option>
                            @foreach ($sucursales as $item)
                            @if ($item->id == Auth()->user()->sucursal_id)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @else
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endif  
                            @endforeach
                        @else
                            <option value="0" >TODAS</option>
                            @foreach ($sucursales as $item)
                            @if ($item->id == Auth()->user()->sucursal_id)
                                <option value="{{$item->id}}" selected>{{$item->name}}</option>
                            @else
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endif  
                            @endforeach
                            
                        @endif
                        
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h4>{{ number_format($ventasMes, 0, ',', '.') }}</h4>
                            <p>Ventas del mes</p>
                        </div>
                        <div class="icon"><i class="fas fa-shopping-cart"></i></div>
                        <a href="{{route('admin.ingresos.index')}}" class="small-box-footer"> Mas info <i class="fas fa-arrow-circle-right"></i> </a>
                    </div>
                </div>

                <div class="col-md-3 col-sm-12">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h4>{{ number_format($serviciosMes, 0, ',', '.') }}</h4>
                            <p>Servicios {{ $porcentajeServicios }}%</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-concierge-bell"></i>
                        </div>
                        <a href="{{route('admin.ingresos.index')}}" class="small-box-footer">
                            Mas info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>

                </div>
                <div class="col-md-3 col-sm-12">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h4>{{ number_format($productosMes, 0, ',', '.') }}</h4>
                            <p>Productos {{ $porcentajeProductos }}%</p>
                        </div>
                        <div class="icon"><i class="fas fa-box"></i></div>
                        <a href="{{route('admin.ingresos.index')}}" class="small-box-footer">Mas info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-12">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h4>{{ number_format($combosMes, 0, ',', '.') }}</h4>
                            <p>Combos {{ $porcentajeCombos }}%</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <a href="{{route('admin.ingresos.index')}}" class="small-box-footer">Mas info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.indicadores -->

    <!-- graficos Ventas -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Ingresos</h3>
            <div class="card-tools">
                <!-- Collapse Button -->
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                        class="fas fa-minus"></i></button>
            </div>
            <!-- /.card-tools -->
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="chart">
                        <canvas id="ventasPorColaborador"></canvas>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="chart">
                        <canvas id="ventasPorFechaBar"></canvas>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="chart">
                        <canvas id="ventasTop10"></canvas>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="chart">
                        <canvas id="ventasPorTipo"></canvas>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <!-- graficos Ventas -->

    <!-- graficos Ventas -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Egresos</h3>
            <div class="card-tools">
                <!-- Collapse Button -->
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                        class="fas fa-minus"></i></button>
            </div>
            <!-- /.card-tools -->
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="chart">
                        <canvas id="gastosPorCta"></canvas>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="chart">
                        <canvas id="gastosPorCC"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- graficos Ventas -->
</div>


@stop

{{-- @section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop --}}

@section('js')
<script src=" {{ asset('js/comunes.js') }} "></script>
<script>
    $(document).ready(function(){
        var _labelsPie = ["Productos", "Servicios", "Combos"];
        var _dataPie = [{{ $porcentajeProductos }}, {{ $porcentajeServicios }}, {{ $porcentajeCombos }}];
        grapPieTipos('ventasPorTipo', _labelsPie, _dataPie);

        var _labelsFecha = [];
        var _dataFecha = [];
        @php
            foreach($ventasPorFecha as $fecha){
                $arr = explode('-', $fecha->fecha);
                $f = $arr[2];
                echo '_labelsFecha.push("'.$f.'");';
                echo '_dataFecha.push('.$fecha->total.');';
            }
        @endphp
        grapPorFecha('ventasPorFechaBar', _labelsFecha, _dataFecha);

        var _labelColaborador = [];
        var _dataColaborador = [];


        @php
            foreach($ventasPorColaborador as $datos){
                echo '_labelColaborador.push("'.$datos->name.'");';
                echo '_dataColaborador.push('.$datos->total.');';
            }
        @endphp

        grapPorColaborador('ventasPorColaborador', _labelColaborador, _dataColaborador);

        var _labelTop10 = [];
        var _dataTop10 = [];


        @php
            foreach($ventasTop10 as $datos){
                echo '_labelTop10.push("'.$datos->name.'");';
                echo '_dataTop10.push('.$datos->total.');';
            }
        @endphp

        grapVentasTop10('ventasTop10', _labelTop10, _dataTop10);


        var _labelGastosPorCta = [];
        var _dataGastosPorCta= [];


        @php
            foreach($gastosPorCta as $datos){
                echo '_labelGastosPorCta.push("'.$datos->nombre_cuenta.'");';
                echo '_dataGastosPorCta.push('.$datos->total.');';
            }
        @endphp

        gastosPorCta('gastosPorCta', _labelGastosPorCta, _dataGastosPorCta);

        var _labelGastosPorCC = [];
        var _dataGastosPorCC = [];


        @php
            foreach($gastosPorCC as $datos){
                echo '_labelGastosPorCC.push("'.$datos->name.'");';
                echo '_dataGastosPorCC.push('.$datos->total.');';
            }
        @endphp

        gastosPorCC('gastosPorCC', _labelGastosPorCC, _dataGastosPorCC);


    });


    function grapPorFecha(_id, _labelsBar, _dataBar){

        var canvas = document.getElementById(_id);
        var ventasPorFechaCtx = canvas.getContext("2d");

        const data = {
            labels: _labelsBar,
            datasets: [{
                fill: false,
            label: 'Por Fecha {{ date('m-Y') }}',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data:_dataBar,
            }]
        };

        const config = {
            type: 'line',
            data: data,
            options: {}
        };

        const myChart = new Chart(
            ventasPorFechaCtx,
            config
        );

        // usar para agregar eventos al tocar
        // canvas.onclick = function(evt) {
        //     // alert('click');
        //     var activePoints = myChart.getElementsAtEvent(evt);
        //     if (activePoints[0]) {
        //         var chartData = activePoints[0]['_chart'].config.data;
        //         var idx = activePoints[0]['_index'];
        //         var label = chartData.labels[idx];
        //         var value = chartData.datasets[0].data[idx];
        //         alert(label + ": " + value);

        //     }
        // };

    }


    function grapPorColaborador(_id, _labelsBar, _dataBar){

        var canvas = document.getElementById(_id);
        var ventasPorFechaCtx = canvas.getContext("2d");

        const data = {
            labels: _labelsBar,
            datasets: [{
            label: 'Por Colaborador {{ date('m-Y') }}',
            backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)'
            ],
            borderColor: 'rgb(255, 99, 132)',
            data:_dataBar,
            }]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {}
        };

        const myChart = new Chart(
            ventasPorFechaCtx,
            config
        );

        // usar para agregar eventos al tocar
        // canvas.onclick = function(evt) {
        //     // alert('click');
        //     var activePoints = myChart.getElementsAtEvent(evt);
        //     if (activePoints[0]) {
        //         var chartData = activePoints[0]['_chart'].config.data;
        //         var idx = activePoints[0]['_index'];
        //         var label = chartData.labels[idx];
        //         var value = chartData.datasets[0].data[idx];
        //         alert(label + ": " + value);

        //     }
        // };

    }


    function grapPieTipos(_id, _labels, _data){
        var canvas = document.getElementById(_id);
        var ventasPorFechaCtx = canvas.getContext("2d");
        var myNewChart = new Chart(ventasPorFechaCtx, {
            type: 'pie',
            // type: 'doughnut',
            data: {
                labels: _labels,
                datasets: [{
                    backgroundColor: ["#FF5A5E", "#46BFBD","#FDB45C"],
                    data: _data,
                }],
            },

            options: {
                legend:{
                        display: true,
                        position: 'bottom',
                        // fontsize:10
                    },
                tooltips: {

                    callbacks: {
                        label: (tooltipItems, data) => {
                            // console.log(data.labels[tooltipItems.index]);
                            var descripcion = data.labels[tooltipItems.index];
                            descripcion += ' ' + data.datasets[tooltipItems.datasetIndex].data[tooltipItems.index] + ' %';
                            return descripcion;
                        }
                    },
                }
            }
        });
        canvas.onclick = function(evt) {
            // alert('click');
            var activePoints = myNewChart.getElementsAtEvent(evt);
            if (activePoints[0]) {
            var chartData = activePoints[0]['_chart'].config.data;
            var idx = activePoints[0]['_index'];
            var label = chartData.labels[idx];
            var value = chartData.datasets[0].data[idx];
            console.log(label,value);
            // alert(url);
            }
        };
    }

    function gastosPorCta(_id, _labelsBar, _dataBar){


        var canvas = document.getElementById(_id);
        var ventasPorFechaCtx = canvas.getContext("2d");

        const data = {
            labels: _labelsBar,
            datasets: [{
            label: 'Por Cuenta {{ date('m-Y') }}',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data:_dataBar,
            }]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {
                scales: {
            xAxes: [{
                ticks: {
                    display: false
                }
            }]
        },
                legend:{
                    display: true,
                        // fontsize:10
                    },
                // tooltips: {
                //     callbacks: {
                //         label: (tooltipItems, data) => {
                //             // console.log(data.labels[tooltipItems.index]);
                //             var descripcion = data.labels[tooltipItems.index];
                //             descripcion += ' ' + data.datasets[tooltipItems.datasetIndex].data[tooltipItems.index] ;
                //             return descripcion;
                //         }
                //     },
                // }
            }
        };

        const myChart = new Chart(
            ventasPorFechaCtx,
            config
        );

    }

    function gastosPorCC(_id, _labelsBar, _dataBar){

        var canvas = document.getElementById(_id);
        var ctx = canvas.getContext("2d");

        const data = {
            labels: _labelsBar,
            datasets: [{
            label: 'Por CC {{ date('m-Y') }}',
            backgroundColor:  'rgba(75, 192, 192)',
            // borderColor: 'rgb(255, 99, 132)',
            data:_dataBar,
            }]
        };

        const config = {
            type: 'line',
            data: data,
            options: {

            }
        };

        const myChart = new Chart(
            ctx,
            config
        );


    }

    function grapVentasTop10(_id, _labelsBar, _dataBar){
        var canvas = document.getElementById(_id);
        var ventasPorFechaCtx = canvas.getContext("2d");

        const data = {
            labels: _labelsBar,
            datasets: [{
            label: 'Top 10 {{ date('m-Y') }}',
            fill: true,
            data:_dataBar,
            }]
        };

        const config = {
            type: 'line',
            data: data,
            options: {}
        };

        const myChart = new Chart(
            ventasPorFechaCtx,
            config
        );
    }
$('#sucursal_change').on('change', function() {
    update()
})

function update(){
    $('#sucursal_change').attr('disabled',true)
   var ruta='admin/navbar/change/'+1+'/'+$('#sucursal_change').val()+"/"+0;
   getData(ruta).then(function(rta){
        console.log(rta);
        location.reload()
    }).catch(function(error){
        console.log('getData dio error'); console.log(error);
        Swal.fire('Ocurrio un Error', error.message, 'error');
    });
}

</script>

@stop
