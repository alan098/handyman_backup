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

class ComisionesExport implements FromView
{
    public $r;

    public function __construct($a){
        $this->r = $a;
    }

    public function view(): View
    {
        $re=$this->ComisionSimple();
        $reDos=$this->ComisionCompleja();
         
        return view('admin.reporte.excel.comision',['datos' => $re,'datosDos'=>$reDos]);
    }
    public function ComisionCompleja(){
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
      ->select('vd.*')
      ->selectRaw("TO_CHAR(v.fecha,'MONTH') as mes")
      ->where('v.concluido',true)
      ->where('v.anulado',false)
      ->where('porcenta_socio', '>' , 0)
      ->orderBy('vd.colaborador_id', 'desc')
      ->when($suc, function($query, $suc){ return $query->where('v.sucursal_id', $suc); })
      ->when($fe, function($query, $fe){ 
         return $query->whereBetween('v.fecha', [$fe['desde'], $fe['hasta']]);
       })
       ->when($col, function($query, $col){ 
         return $query->where('vd.colaborador_id',$col); 
      })
      ->get(); 
   $detalles=DB::table('users')->where('es_colaborador',true)
   ->when($col, function($query, $col){ 
      return $query->where('id',$col); 
   })
   ->get();
   $comision=array();
   foreach ($comisiones as  $value) {
      $mes=trim($value->mes);
      $col=$value->colaborador_id;
     
      //preguntamos si exite o creamos
      if (isset($comision[$col]['bruto'])) {
         //sumado
         $comision[$col]['bruto']=$comision[$col]['bruto'] + (($value->gravada10 * $value->porcenta_socio ) / 100);
         $comision[$col]['real']=$comision[$col]['real'] + (($value->precio_total * $value->porcenta_socio ) / 100); 
      }else{
         //sumado
         $comision[$col]['bruto']= (($value->gravada10 * $value->porcenta_socio ) / 100);
         $comision[$col]['real']= (($value->precio_total * $value->porcenta_socio ) / 100); 
      }
      if (isset($comision[$col][$mes])) {
         //por mes
         $comision[$col][$mes]['bruto']= $comision[$col][$mes]['bruto'] + (($value->gravada10 * $value->porcenta_socio ) / 100);
         $comision[$col][$mes]['real']= $comision[$col][$mes]['real'] + (($value->precio_total * $value->porcenta_socio ) / 100);
      }else{
         //por mes
         $comision[$col][$mes]= array(
            'mes'=>$mes,
            'bruto'=> (($value->gravada10 * $value->porcenta_socio ) / 100),
            'real'=>(($value->precio_total * $value->porcenta_socio ) / 100),
         );
      }
   }
   foreach ($detalles as  $value) {
      if(isset($comision[$value->id])){
         $value->bruto=  $comision[$value->id]['bruto'];
         $value->real= $comision[$value->id]['real'];     
         unset($comision[$value->id]['real']);unset($comision[$value->id]['bruto']);
         $re=array();
         foreach ($comision[$value->id] as  $val) {
            $re[]=$val;
         }
         if (isset($re[0])) {
            $value->meses=($re);
         }
       }else{
         $value->bruto=  0;
         $value->real= 0; 
         $value->meses="";
       }
   }
     } catch (\Throwable $th) {
     Log::error('Error'.$th->getMessage());
     }
     return $detalles;
    }
    public function ComisionSimple(){
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
            $rta = DB::table('ventas as v')
            ->join('ventas_detalles as vd', 'vd.venta_id', '=', 'v.id')
            ->orderBy('v.id', 'desc')
            ->select('vd.*')
            ->selectRaw("TO_CHAR(v.fecha,'MONTH') as mes")
            ->where('v.concluido',true)
            ->where('v.anulado',false)
            ->where('porcenta_socio', '>' , 0)
            ->when($suc, function($query, $suc){ return $query->where('v.sucursal_id', $suc); })
            ->when($fe, function($query, $fe){ 
               return $query->whereBetween('v.fecha', [$fe['desde'], $fe['hasta']]);
            })
            ->when($col, function($query, $col){ 
               return $query->where('vd.colaborador_id',$col); 
            })
            ->get(); 
         $comision=array();
         foreach ($rta as  $value) {
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
