<?php

namespace App\Http\Controllers\Admin;

use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Gasto;
use App\Models\GastosDetalle;
use App\Models\Proveedor;
use App\Models\Sucursal;
use App\Models\VentasDetalles;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        Log::info(__FILE__.'/'.__FUNCTION__);

        $ent = auth()->user()->entidad_id;
        $suc=1;
        if (auth()->user()->todas) {
            Log::info("Todas");
           $suc=null;
        }else{
            Log::info("especifico");
            $suc = auth()->user()->sucursal_id;
        }
        
        $fecha = date('Y-m-01');


        $ventasMes =  Venta::where('concluido', '=', true)
        ->where('fecha', '>=', $fecha)
        ->when($ent, function($query, $ent){ return $query->where('entidad_id', $ent); })
        ->when($suc, function($query, $suc){ return $query->where('sucursal_id', $suc); })
        ->sum('total');



        $clientesMes =  Cliente::where('created_at' , '>=', $fecha)->count();

        // Log::info('HomeController@index: ventasMes: '.$ventasMes);
        // Log::info('HomeController@index: clientesMes: '.$clientesMes);


        $tipoMes = Venta::select('articulos.tipo')
        ->selectRaw('sum(ventas_detalles.precio_total) as importe')
        ->join('ventas_detalles', 'ventas_detalles.venta_id', '=', 'ventas.id')
        ->join('articulos', 'articulos.id', '=', 'ventas_detalles.articulo_id')
        ->where('ventas.fecha', '>=', $fecha)
            ->when($ent, function($query, $ent){ return $query->where('ventas.entidad_id', $ent); })
            ->when($suc, function($query, $suc){ return $query->where('ventas.sucursal_id', $suc); })
        ->groupBy('articulos.tipo')
        ->get();

        $combosMes = 0 ; $serviciosMes  = 0; $productosMes = 0;

        foreach($tipoMes as $tipo){
            if($tipo->tipo == 'combo'){
                $combosMes = $tipo->importe;
            }else if($tipo->tipo == 'servicio'){
                $serviciosMes = $tipo->importe;
            }else if($tipo->tipo == 'producto'){
                $productosMes = $tipo->importe;
            }
        }


        $ventasPorFecha = Venta::select('fecha')
        ->selectRaw('sum(total) as total')
        ->where('fecha', '>=', $fecha)
        ->when($ent, function($query, $ent){ return $query->where('entidad_id', $ent); })
        ->when($suc, function($query, $suc){ return $query->where('sucursal_id', $suc); })
        ->groupBy('fecha')
        ->orderBy('fecha')
        ->get();



        $ventasPorColaborador = VentasDetalles::select('ventas_detalles.colaborador_id', 'users.name')
            ->selectRaw('sum(ventas_detalles.precio_total) as total')
            ->join('users', 'users.id', '=', 'ventas_detalles.colaborador_id')
            ->join('ventas', 'ventas.id', '=', 'ventas_detalles.venta_id')
            ->where('ventas.fecha', '>=', $fecha)
            ->when($ent, function($query, $ent){ return $query->where('ventas.entidad_id', $ent); })
            ->when($suc, function($query, $suc){ return $query->where('ventas.sucursal_id', $suc); })
        ->groupBy('ventas_detalles.colaborador_id', 'users.name')
        ->get();


        $ventasTop10 = VentasDetalles::select('articulos.id', 'articulos.name')
        ->selectRaw('sum(ventas_detalles.precio_total) as total')
        ->join('articulos', 'articulos.id', '=', 'ventas_detalles.articulo_id')
        ->join('ventas', 'ventas.id', '=', 'ventas_detalles.venta_id')
        ->where('ventas.fecha', '>=', $fecha)
        ->when($ent, function($query, $ent){ return $query->where('ventas.entidad_id', $ent); })
        ->when($suc, function($query, $suc){ return $query->where('ventas.sucursal_id', $suc); })
        ->groupBy('articulos.id', 'articulos.name')
        ->orderBy('total', 'desc')
        ->limit(10)
        ->get();


        $gastosTotal = Gasto::where('concluido', '=', true)
            ->where('fecha', '>=', $fecha)
            ->when($ent, function($query, $ent){ return $query->where('entidad_id', $ent); })
            ->when($suc, function($query, $suc){ return $query->where('sucursal_id', $suc); })
        ->sum('total');

        $gastosPorCta = Gasto::select('gastos.cuenta_id', 'plan_cuentas.name')
            ->selectRaw('sum(gastos.total) as total')
            ->join('plan_cuentas', 'plan_cuentas.id', '=', 'gastos.cuenta_id')
            ->where('concluido', '=', true)
            ->where('fecha', '>=', $fecha)
            ->when($ent, function($query, $ent){ return $query->where('entidad_id', $ent); })
            ->when($suc, function($query, $suc){ return $query->where('sucursal_id', $suc); })
            ->groupBy('gastos.cuenta_id', 'plan_cuentas.name')
        ->get();

        $gastosPorCC =  GastosDetalle::select('centro_costos.id', 'centro_costos.name')
        ->selectRaw('sum(gastos.total) as total')
        ->join('gastos', 'gastos.id', '=', 'gastos_detalles.gasto_id')
        ->join('centro_costos', 'centro_costos.id', '=', 'gastos_detalles.centrocosto_id')
        ->where('gastos.concluido', '=', true)
        ->where('gastos.fecha', '>=', $fecha)
        ->when($ent, function($query, $ent){ return $query->where('entidad_id', $ent); })
        ->when($suc, function($query, $suc){ return $query->where('sucursal_id', $suc); })
        ->groupBy('centro_costos.id', 'centro_costos.name')
        ->get();

        $sucursales=Sucursal::get();

        return view('admin.index', compact('ventasMes', 'clientesMes',
         'tipoMes', 'ventasPorFecha',  'productosMes' , 'serviciosMes' , 
         'combosMes', 'ventasPorColaborador', 'gastosTotal',
          'gastosPorCta', 'gastosPorCC', 'ventasTop10','sucursales'
         ));
    }
}
