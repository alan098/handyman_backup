<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Invoice;
use App\Models\Articulo;
use GuzzleHttp\Psr7\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class IndividualesExport implements FromView
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
    
           $rta = DB::table('ventas as v')
              ->join('ventas_detalles as vd', 'vd.venta_id', '=', 'v.id')
              ->join('articulos as a', 'a.id', '=', 'vd.articulo_id')
              ->leftJoin('users as uc', 'uc.id', '=', 'vd.colaborador_id')
              ->join('sucursales as su', 'su.id', '=', 'v.sucursal_id')
              ->leftJoin('eventos as e', 'e.venta_id', 'v.id')
              ->leftJoin('facturas as f', 'f.venta_id', 'v.id')
              ->leftJoin('personas as cs', 'cs.id', 'e.cliente_id')
              ->leftJoin('personas as cf', 'cf.id', 'v.cliente_id')
              ->select(
                 'v.id',
                 'v.fecha',
                 'su.name as sucursal',
                 'uc.name as prof',
                 'cs.name as cli_ser',
                 'cf.name as cli_fac',
                 'a.name as ar_name',
                 'vd.gravada10 as imp_bru',
                 'vd.precio_total as imp_real',
                 'vd.importe_porcentaje as des_por',
                 'vd.importe_descuento as des_impor',
                 'v.descuento as des_gen',
                 'vd.porcenta_socio as porc'
              )
              ->selectRaw("(case when a.tipo = 'servicio' then vd.gravada10 else 0 end ) as mon_ser_bru")
              ->selectRaw("(case when a.tipo <>'servicio' then vd.gravada10 else 0 end ) as mon_pro_bru ")
              ->selectRaw("(case when a.tipo = 'servicio' then vd.precio_total else 0 end ) as mon_pro")
              ->selectRaw("(case when a.tipo <>'servicio' then vd.precio_total else 0 end ) as mon_ser")
              ->selectRaw("(case when vd.porcenta_socio > 0 then
                 ROUND(vd.gravada10 - (vd.gravada10 / 1.1) ) else 0  end ) as comi_bruta")
              ->selectRaw("(case when vd.porcenta_socio > 0 then
                 ROUND(vd.precio_total - (vd.precio_total / 1.1) ) else 0  end ) as comi_rea")
              ->selectRaw('(case when f.numero_factura is not null then f.numero_factura else 0 end ) as num_fac')
              ->orderBy('v.id', 'desc')
              ->selectRaw("TO_CHAR(v.fecha,'MONTH') as mes")
              ->where('v.concluido',true)
              ->where('v.anulado',false)
              ->when($suc, function($query, $suc){ return $query->where('v.sucursal_id', $suc); })
              ->when($fe, function($query, $fe){ 
                 return $query->whereBetween('v.fecha', [$fe['desde'], $fe['hasta']]);
               })
               ->when($col, function($query, $col){ 
                 return $query->where('vd.colaborador_id',$col); 
              })
              ->get();
        return view('admin.reporte.excel.individual', ['datos'=>$rta]);
    }
}
