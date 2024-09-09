<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Invoice;
use App\Models\Articulo;
use App\Models\Venta;
use GuzzleHttp\Psr7\Request;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromView;

class IngresosExport implements FromView
{
    public $r;

    public function __construct($a){
        $this->r = $a;
    }

    public function view(): View
    {
        $suc=$this->r->sucursal;
        $fe=[];
        if ($this->r->af == 'a') {
           $fe['desde'] = ( empty($this->r->a_desde) ) ? date('Y-01-01') : $this->r->a_desde.strval('-01');
           $fe['hasta'] = ( empty($this->r->a_hasta) ) ? date('Y-m-d') : $this->r->a_hasta.strval('-30');
        }else{
           $fe['desde'] = ( empty($this->r->f_desde) ) ? date('Y-01-01') : $this->r->f_desde;
           $fe['hasta'] = ( empty($this->r->f_hasta) ) ? date('Y-m-d') : $this->r->f_hasta;
        }
        $col=$this->r->col_id;
        $rta = Venta::with('ventaDetalles.Articulo','ventaDetalles.Colaora','cobroDetalles.medios')
           ->join('sucursales as su', 'su.id', '=', 'ventas.sucursal_id')
           ->leftJoin('eventos as e', 'e.venta_id', 'ventas.id')
           ->leftJoin('facturas as f', 'f.venta_id', 'ventas.id')
           ->leftJoin('personas as cs', 'cs.id', 'e.cliente_id')
           ->leftJoin('personas as cf', 'cf.id', 'ventas.cliente_id')
           ->select(
              'ventas.id',
              'ventas.fecha',
              'su.name as sucursal',
              'cs.name as cli_ser',
              'cf.name as cli_fac',
              'ventas.iva as iva',
              'ventas.importe as imp_bru',
              'ventas.total as imp_real',
              'ventas.descuento as des_impor',
           )
           ->selectRaw('(case when f.numero_factura is not null then f.numero_factura else 0 end ) as num_fac')
           ->orderBy('ventas.id', 'desc')
           ->selectRaw("TO_CHAR(ventas.fecha,'MONTH') as mes")
           ->where('ventas.concluido',true)
           ->where('ventas.anulado',false)
           ->when($suc, function($query, $suc){ return $query->where('ventas.sucursal_id', $suc); })
           ->when($fe, function($query, $fe){ 
              return $query->whereBetween('ventas.fecha', [$fe['desde'], $fe['hasta']]);
            })
            ->when($col, function($query, $col){ 
              return $query->whereRaw('ventas.id in(select venta_id from ventas_detalles where colaborador_id = '.$col.')'); 
           })
           ->get(); 
        return view('admin.reporte.excel.re_uno',['datos' => $rta]);
    }
}
