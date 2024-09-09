<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Invoice;
use App\Models\Articulo;
use App\Models\Venta;
use GuzzleHttp\Psr7\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromView;

class ResumenExport implements FromView
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
        $comi=$this->dataExtraComision();
        $resu = DB::table('ventas as v')
           ->selectRaw('sum(importe) as importe')
           ->selectRaw('sum(total) as total')
           ->selectRaw('sum(descuento) as descuento')
           ->selectRaw("'0' as comi")
           ->selectRaw("TO_CHAR(v.fecha,'MONTH') as mes")
           ->where('v.concluido',true)
           ->where('v.anulado',false)
           ->when($suc, function($query, $suc){ return $query->where('v.sucursal_id', $suc); })
           ->when($fe, function($query, $fe){ 
              return $query->whereBetween('v.fecha', [$fe['desde'], $fe['hasta']]);
            })
            ->when($col, function($query, $col){ 
              return $query->whereRaw('v.id in(select venta_id from ventas_detalles where colaborador_id = '.$col.')'); 
           })
           ->groupBy('mes')
           ->orderBy('mes','asc')
           ->get(); 
           foreach ($resu as  $value) {
              foreach ($comi as $valuedos) {
                 if ( trim($value->mes) == trim($valuedos['mes'])) {
                   $value->comi=json_encode( $valuedos['real']);
                 }
              }
           }
         
        return view('admin.reporte.excel.reporte',['datos' => $resu,'fe'=>$fe]);
    }
    public function dataExtraComision(){
         try { 
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
           $comisiones = DB::table('ventas as v')
                 ->join('ventas_detalles as vd', 'vd.venta_id', '=', 'v.id')
                 ->orderBy('v.id', 'desc')
                 ->select('vd.*')
                 ->selectRaw("TO_CHAR(v.fecha,'MONTH') as mes")
                 ->where('v.concluido',true)
                 ->where('v.anulado',false)
                 ->where('porcenta_socio', '>' , 0)
                 ->get(); 
              $comision=array();
              foreach ($comisiones as  $value) {
                 $mes=trim($value->mes);
                 if (isset($comision[$mes])) {
                    $comision[$mes]['bruto']= $comision[$mes]['bruto'] + (($value->gravada10 * $value->porcenta_socio ) / 100);
                    $comision[$mes]['real']= $comision[$mes]['real'] + (($value->precio_total * $value->porcenta_socio ) / 100);
                 }else{
                    $comision[$mes]= array(
                       'mes'=>$mes,
                       'bruto'=> (($value->gravada10 * $value->porcenta_socio ) / 100),
                       'real'=>(($value->precio_total * $value->porcenta_socio ) / 100),
                    );
                 }
              }
              $re=array();
              foreach ($comision as  $value) {
                $re[]=$value;
              }
           } catch (\Throwable $th) {
         Log::error('Error'.$th->getMessage());
         }
         return $re;
        }
}
