<?php

namespace App\Http\Controllers;

use App\Models\User;
use DateInterval;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Throwable;

class ComunesController extends Controller
{
    public static function Ex_Ca_De($tabla,$id,$forein=""){
        #esta funcion sirve para saber si existe detalles o si existe 
        #si existe retorna true o false si no existe
        if ($forein != "") {
            $exis=DB::table($tabla)->where($forein,$id)->first();
            if (empty($exis)) {
                return false;
            }else{
                return true;
            }
        }else{
            $exis=DB::table($tabla)->where('id',$id)->first();
            if (empty($exis)) {
                return false;
            }else{
                return true;
            }
        }
    }
    public static function arr2str($foo){ //convierte array a cadena con saltos de linea HTML de ser requerido

        $array = (is_array($foo))? $foo : json_decode(json_encode($foo), true) ; // si es un objeto convertimos a array

        $str = '';
        foreach($array as $key=>$val){
            if(is_array($val)){
                $str .= '\n'.self::arr2str($val);
            }else{
                if(is_numeric($key)){
                    $str .= (empty($str))? ucwords(strtolower($val)).' ' : '\n'.ucwords(strtolower($val)).' ';
                }else{
                    $str .= (empty($str))? ucwords(strtolower($key)).': '.ucwords(strtolower($val)).' ' : '\n'.ucwords(strtolower($key)).': '.ucwords(strtolower($val)).' ';
                }
            }
        }
        return $str;
    }
    public static function iva10($total= 0){
        $iva = $total - ($total /1.1);
        return $iva;
    }
    public static function iva5($total= 0){
        $iva = $total - ($total / 1.05);
        return $iva; 
    }
    public static function verificarDisponibilidad($r){
        Log::info(__FUNCTION__);
        $rta=true;
        try {
        $existe= DB::table('eventos_articulos')
        ->select('*')
        ->whereRaw("
                colaborador_id in
                (select c.colaborador_id
                from (
                select colaborador_id,start::timestamp  + '1 min'::INTERVAL as rn from eventos_articulos c   
                ) c
                where c.rn BETWEEN  '".$r->fecha . ' '.$r->desde.':00'."' AND '".$r->fecha . ' '.$r->hasta.':00'."'
                and c.colaborador_id =".$r->colaborador.")
         ")
            ->orWhere(function ($query) use ($r) {
                $query->whereRaw("
                colaborador_id in
                (select c.colaborador_id
                from (
                select colaborador_id,c.end::timestamp  - '1 min'::INTERVAL as rn from eventos_articulos c   
                ) c
                where c.rn BETWEEN  '".$r->fecha . ' '.$r->desde.':00'."' AND '".$r->fecha . ' '.$r->hasta.':00'."'
                and c.colaborador_id =".$r->colaborador.")
            ");
            })
        ->first();
        Log::info([$r->fecha . ' '.$r->desde.':00', $r->fecha . ' '.$r->hasta.':00']);
            if (empty($existe)) {
                $rta=false;
            }else{
                $rta=true;
            }
        } catch (\Throwable $th) {
           Log::error("Error".$th->getMessage());
        }
        return $rta;
    }
    public static  function horasOcupadas(){
        Log::info(__FUNCTION__);
        $fecha=date('Y-m-d');
        try {
        $eventos=
            DB::table('eventos as e')
            ->leftJoin('eventos_articulos as ev', 'ev.evento_id', '=', 'e.id')
            ->select('ev.*')
            ->where('e.fecha',$fecha)
            ->orderBy('start')
            ->get();
        } catch (\Throwable $th) {
           Log::error("Error".$th->getMessage());
        }
    }

    public static function artSucEnt(){
        //sirve para saber que articulos de combos y promos pueden venderse estan permitidos venderse();
        try {
            $art="";
            //eset si o si
            $producto=DB::table('articulos')->where('activo', true)->where('tipo','<>','combo')->get();
            $combos=DB::table('entidad_sucursal_articulo as ena')
            ->Join('articulos as a', 'a.id', '=', 'ena.articulo_id')
            ->where('ena.sucursal_id',Auth()->user()->sucursal_id)//filtra entidad sucursal
            ->where('a.tipo','combo')
            ->get();  
            //una vez tenmos los combos mescalamos los articulos
            $productos="";
            foreach($producto  as $key => $sucursal ){
                $productos.=''.$producto[$key]->id.",";
            }
            if(count($combos) > 0) {
                $combo="";
                foreach($combos  as $key => $sucursal ){
                    $combo.=''.$combos[$key]->id.",";
                }

                $combo= substr($combo,0,-1);
                $productos.=$combo;
                $art= $productos;
            }else{
                $art= substr($productos,0,-1);
            }

        } catch (\Throwable $th) {
           Log::error("error".$th->getMessage());
        }
        return $art;
    }
    public static  function diasDeSemana($dia){
        $array_lunes = array("Mon"); $array_martes = array("Tue");
        $array_miercoles = array("wed"); $array_jueves = array("Thu");
        $array_viernes = array("Fri"); $array_sabado = array('Sat');
        $str1 = str_replace($array_lunes, 'lunes', $dia);
        $str2 = str_replace($array_martes, 'martes', $str1);
        $str3 = str_replace($array_miercoles, 'miercoles', $str2);
        $str4 = str_replace($array_jueves, 'jueves', $str3);
        $str5 = str_replace($array_viernes, 'viernes', $str4);
        $str6 = str_replace($array_sabado, 'sabado', $str5);
        $str7 = str_replace(" ", '', $str6);
        return $str7;
    }
    public static function getTimbradoActivo($tipo){
        Log::info(__FUNCTION__);
        try{
            $data = DB::table('timbrados_sucursal_pv')
            ->join('timbrados', 'timbrados.id', '=', 'timbrados_sucursal_pv.timbrado_id')
            ->where('timbrados_sucursal_pv.entidad_id', '=', auth()->user()->entidad_id)
            ->where('timbrados_sucursal_pv.sucursal_id', '=', auth()->user()->sucursal_id)
            ->where('timbrados_sucursal_pv.punto_de_venta_id', '=', auth()->user()->puntos_de_venta_id)
            ->where('timbrados.tipo_factura', '=', $tipo)
            ->where('timbrados.es_activo', '=', 'true')
            ->whereRaw('timbrados_sucursal_pv.factura_actual < timbrados_sucursal_pv.factura_hasta')
            ->whereDate('timbrados.fecha_fin_vigencia', '>', 'now()')
            ->orderBy('timbrados.fecha_fin_vigencia','desc')
            ->get();
            if (!$data->isEmpty()) {
                Log::info(DB::getQueryLog());
                $rta['cod'] = 200;
                $rta['msg'] = 'ok';
                $rta['reg'] = count($data);
                $rta['dat'] = $data;
            }else{
                $rta['cod'] = 500;
                $rta['msg'] = 'No Existe nigun timbrabo activo por favor verifique la tabla de timbrados';
                $rta['reg']=0;
            }
        } catch(\Illuminate\Database\QueryException $ex){
            $rta['error'] = (object) array('error' => $ex->getMessage());
            $rta['cod'] = 500;
            $rta['msg'] = 'Error en el proceso';
        }
        return $rta;
    }
    public static function getTimbradoActivoId($tipo,$id){
        Log::info(__FUNCTION__);
        try{
            $data = DB::table('timbrados_sucursal_pv')
            ->join('timbrados', 'timbrados.id', '=', 'timbrados_sucursal_pv.timbrado_id')
            ->where('timbrados_sucursal_pv.entidad_id', '=', auth()->user()->entidad_id)
            ->where('timbrados_sucursal_pv.sucursal_id', '=', auth()->user()->sucursal_id)
            ->where('timbrados_sucursal_pv.punto_de_venta_id', '=', auth()->user()->puntos_de_venta_id)
            ->where('timbrados.tipo_factura', '=', $tipo)
            ->where('timbrados.es_activo', '=', 'true')
            ->whereRaw('timbrados_sucursal_pv.factura_actual < timbrados_sucursal_pv.factura_hasta')
            ->whereDate('timbrados.fecha_fin_vigencia', '>', 'now()')
            ->where('id',$id)
            ->get();
            if (!$data->isEmpty()) {
                Log::info(DB::getQueryLog());
                $rta['cod'] = 200;
                $rta['msg'] = 'ok';
                $rta['reg'] = count($data);
                $rta['dat'] = $data;
            }else{
                $rta['cod'] = 500;
                $rta['msg'] = 'No Existe nigun timbrabo activo por favor verifique la tabla de timbrados';
                $rta['reg']=0;
            }
        } catch(\Illuminate\Database\QueryException $ex){
            $rta['error'] = (object) array('error' => $ex->getMessage());
            $rta['cod'] = 500;
            $rta['msg'] = 'Error en el proceso';
        }
        return $rta;
    }
    public static function update($query, $data){
        //esta funcion actualiza registros y retorna el numero de registros actualizados
        DB::enableQueryLog(); Log::info(__FILE__.'/'.__FUNCTION__); $rta = 0;
        try{
            $rta = DB::update($query, $data);
            Log::info(DB::getQueryLog());
        }catch(\Illuminate\Database\QueryException $e){
            Log::error('QueryException => '.$e->getMessage());
        }catch(Throwable $e){
            Log::error('Throwable => '.$e->getMessage());
        }catch (Exception $e) {
            Log::error('Exception => '.$e->getMessage());
        }
        return $rta;
    }


    //seccion de permisos comunes y administrativos
    public function permisosSimple(Request $r){
        Log::info(__FUNCTION__); Log::info($r); $rta['cod'] = 500;  $rta['msg'] = 'Error inesperado';
         try {
            
             $users = DB::table('users')
                 ->select("password",'id')
                 ->where('email',$r->email)
                 ->first();
             if (!empty($users)) {
                 if (Hash::check($r->pass,$users->password)) {
                         $rta['id'] = $users->id; $rta['cod'] = 200; $rta['msg'] = 'Confirmado!';
                 }else{
                     $rta['cod'] = 500; $rta['msg'] = 'Contraseña incorrecta';  return $rta;
                 }
             }else{
                 $rta['cod'] = 500; $rta['msg'] = 'No se encontro el usuario verifique los datos'; return $rta;
             }
         } catch (\Throwable $th) {
             Log::info('El query dio error =>'.$th->getMessage());
             return $rta;
         }
         return $rta;
     }
     public function permisosAdmin(Request $r){
        Log::info(__FUNCTION__); Log::info($r); $rta['cod'] = 500;  $rta['msg'] = 'Error inesperado';
         try {
             $users = User::role('admin')
                 ->select("password",'id')
                 ->where('email',$r->email)
                 ->first();
             if (!empty($users)) {
                 if (Hash::check($r->pass,$users->password)) {
                         $rta['id'] = $users->id; $rta['cod'] = 200; $rta['msg'] = 'Confirmado!';
                 }else{
                     $rta['cod'] = 500; $rta['msg'] = 'Contraseña incorrecta';  return $rta;
                 }
             }else{
                 $rta['cod'] = 500; $rta['msg'] = 'No se encontro el usuario Administrador'; return $rta;
             }
         } catch (\Throwable $th) {
             Log::info('El query dio error =>'.$th->getMessage());
             return $rta;
         }
         return $rta;
     }
}
