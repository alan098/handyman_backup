<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Invoice;
use App\Models\Articulo;
use App\Models\Sucursal;
use GuzzleHttp\Psr7\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromView;

class LocalesExport implements FromView
{
    public $r;

    public function __construct($a){
        $this->r = $a;
    }

    public function view(): View
    {
        $fe=[];
        if ($this->r->af == 'a') {
           $fe['desde'] = ( empty($this->r->a_desde) ) ? date('Y-01-01') : $this->r->a_desde.strval('-01');
           $fe['hasta'] = ( empty($this->r->a_hasta) ) ? date('Y-m-d') : $this->r->a_hasta.strval('-30');
        }else{
           $fe['desde'] = ( empty($this->r->f_desde) ) ? date('Y-01-01') : $this->r->f_desde;
           $fe['hasta'] = ( empty($this->r->f_hasta) ) ? date('Y-m-d') : $this->r->f_hasta;
        }
        $sucur=Sucursal::get();
        foreach ($sucur as  $value) {
           $suc= DB::table('ventas as v')
           ->selectRaw('sum(importe) as importe')
           ->selectRaw('sum(total) as total')
           ->selectRaw('sum(descuento) as descuento')
           ->where('v.concluido',true)
           ->where('v.anulado',false)
           ->where('v.sucursal_id',$value->id)
           ->when($fe, function($query, $fe){
            return $query->whereBetween('v.fecha', [$fe['desde'], $fe['hasta']]);
            })
           ->first();  
           $value->detalles=$suc;
        }
        return view('admin.reporte.excel.locales', ['datos'=>$sucur,'fe'=>$fe]);
    }
}
