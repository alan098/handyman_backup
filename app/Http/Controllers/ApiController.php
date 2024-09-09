<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Evento;
use App\Models\EventoArticulos;
use App\Models\Sucursal;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;



class ApiController extends Controller
{
    public function loginUser(Request $r){
    Log::info(__FUNCTION__.'/'.__FILE__); Log::info($r); $rta['cod']=500; $rta['msg']='Error'; 
     try { 
        $validator = Validator::make($r->all() , [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
        ])->validate();
       
    $user = User::where('email',$r->email)->first();
       
    if (!empty($user)) {
        if (Hash::check($r->password,$user->password)) {
                $rta['id'] = $user->id; $rta['cod'] = 200; $rta['msg'] = 'Confirmado!';
                $token= $user->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'cod'=>200,
                    'msg'=>'Usuario logueado',
                    'access_token'=>$token
                ]);
        }else{
            Log::info($user);
            $rta['cod'] = 500; $rta['msg'] = 'Contraseña incorrecta';  return $rta;
        }
    }else{
        $rta['cod'] = 500; $rta['msg'] = 'No se encontro el usuario '; return $rta;
    }

     } catch (\Throwable $th) {
        Log::error('Error'.$th->getMessage());
     }
     return $rta;
    }
    public function getWorkers(Request $r){
        Log::info(__FUNCTION__.__FILE__); 
            $parametros='';
            if(isset($r->id)){
                $parametros=' where u.id ='.$r->id;
            }
            $query = " 
            select 
            u.id,
            u.name,
            u.email,
            u.short_description,
            u.qualification,
            u.profession,
            u.price,
            u.profile_photo_path
            from handyman_users_app u  
            ".$parametros."
            order by u.name
            ";
            $data = $this->consulta($query);
            return response()->json($data);
    }
    public function getClientes(Request $r){
        Log::info(__FUNCTION__.__FILE__); 
            $parametros='';
            if(isset($r->id)){
                $parametros=' and p.ruc ='.$r->documento;
            }
            $query = " 
            select 
            p.id,
            p.ruc,
            p.name,
            p.nombre_fantasia,
            p.direccion,
            p.telefono,
            p.email,
            p.es_cliente,
            p.cumple
            from personas p
            where p.deleted_at is null 
            ".$parametros."
            order by p.name
            ";
            $data = $this->consulta($query);
            return response()->json($data);
    }
    public function getCategorias(Request $r){
        Log::info(__FUNCTION__.__FILE__); 
            $parametros='';
            if(isset($r->id)){
                $parametros=' and a.id ='.$r->id;
            }
            $query = " 
            select 
            a.id,
            a.name,
            a.tipo
            from articulos_categorias a
            where a.deleted_at is null 
            ".$parametros."
            and a.tipo = 'servicio'
            order by a.name
            ";
            $data = $this->consulta($query);
            return response()->json($data);
    }
    public function getServicios(Request $r){
        Log::info(__FUNCTION__.__FILE__); 
            $parametros='';
            if(isset($r->id)){
                $parametros=' and a.id ='.$r->id;
            }
            $query = " 
            select 
            a.id,
            a.categoria_id,
            a.name,
            a.precio,
            a.activo,
            a.tipo,
            a.end as duracion
            from articulos a
            where a.deleted_at is null 
            ".$parametros."
            and a.tipo = 'servicio'
            order by a.name
            ";
            $data = $this->consulta($query);
            return response()->json($data);
    }
    public function getReservas(Request $r){
        Log::info(__FUNCTION__.__FILE__); 
            $query = " 
            select 
            a.name,
            ea.start as fecha_hora,
            ea.importe,
            u.name as profesional,
            (case when v.concluido is true then 'si' else 'no' end ) as concluido
            from eventos_articulos as ea
            join users as u on u.id = ea.colaborador_id
            join articulos as a on a.id = ea.articulo_id
            join eventos as e on e.id = ea.evento_id
            left join ventas as v on v.id = e.venta_id
            join personas as p on p.id = e.cliente_id
            where p.ruc = '".$r->documento."'
            order by e.fecha desc
            ";
            $data = $this->consulta($query);
            return response()->json($data);
    }
    public function getSucursales(Request $r){
        Log::info(__FUNCTION__.__FILE__); 
            $parametros='';
            if(isset($r->id)){
                $parametros=' and s.id ='.$r->id;
            }
            $query = " 
            select 
            s.id,
            s.direccion,
            s.name,
            s.telefono
            from sucursales s
            where s.deleted_at is null 
            ".$parametros."
            order by s.name
            ";
            $data = $this->consulta($query);
            return response()->json($data);
    }
    public function horariosLibres(Request $r){
    Log::info(__FUNCTION__.'/'.__FILE__); Log::info($r); $rta['cod']=500; $rta['msg']='Error inesperado'; 
     try { 
        $fecha=$r->fecha;
        $colaborador=$r->colaborador;
        $query="
            select u.id, u.name,ea.start , ea.end
            from eventos_articulos as ea
            join eventos as e on e.id = ea.evento_id
            join users as u on u.id = ea.colaborador_id
            where e.fecha= '".$fecha."'
            and ea.colaborador_id = ".$colaborador."
            order by ea.start
        ";
        $fecha_apertura=$fecha.' 08:00:00';
        $fecha_cierre =$fecha.' 21:00:00';
        $fecha_base = $fecha.' 08:00:00'; $horas='08:00:00'; $hora_libre = [];$falta=false;
        $data = $this->consulta($query);
        Log::info($data);
        if ($data['cod'] == 200) {

            foreach ($data['dat'] as $key => $value) {
                if (($value->start >= $fecha_apertura) && ($value->start <= $fecha_cierre)){
                    $h1 = new DateTime($fecha_base);
                    $h2 = new DateTime($value->start);
                    $interval = $h1->diff($h2);
                    if (($interval->format('%H') > 0) || $interval->format('%i') > 0) {
                       // hay que sumar a la fecha base
                       $suma=ApiController::sumar($horas,$interval->format('%H:%i:00'));
                       $hora_libre[]=['desde'=>$h1->format('H:i:s'),'hasta'=>$suma];
                       $fecha_base = $value->end;
                       $horas= new DateTime($value->end);
                       $horas= $horas->format('H:i:s');
                       if((($key+1) == $data['reg']) && ($value->end < $fecha_cierre)){
                        $hora_libre[]=['desde'=>$horas,'hasta'=>'21:00:00'];
                       }
                       
                    }else{
                        //hay que igualar an end
                        $fecha_base = $value->end;
                        $horas= new DateTime($value->end);
                        $horas= $horas->format('H:i:s');
                        if((($key+1) == $data['reg']) && ($value->end < $fecha_cierre)){
                            $hora_libre[]=['desde'=>$horas,'hasta'=>'21:00:00'];
                        }
                    }
                }
            }
            if($data['reg'] == 0 ){
                $hora_libre[]= ['desde'=> $fecha_base,'hasta'=>$fecha_cierre];
            }
        
        }else{ return $data; }
        $rta['cod'] = 200;
        $rta['msg'] = 'Horarios Libres (Muy Variable)';
        $rta['reg'] = count($hora_libre);
        $rta['dat'] = $hora_libre;
        
     } catch (\Throwable $th) {
     Log::error('Error'.$th->getMessage());
     }
     return $rta;
    }
    public function sumar($hora1, $hora2)
    {
        list($h, $m, $s) = explode(':', $hora2); //Separo los elementos de la segunda hora
        $a = new DateTime($hora1); //Creo un DateTime
        $b = new DateInterval(sprintf('PT%sH%sM%sS', $h, $m, $s)); //Creo un DateInterval
        $a->add($b); //SUMO las horas
        return $a->format('H:i:s'); //Retorno la Suma
    }
    public function consultarDisponibilidad(Request $r){
    Log::info(__FUNCTION__.'/'.__FILE__); Log::info($r); $rta['cod']=500; $rta['msg']='Error'; 
     try { 
        $validator = Validator::make($r->all(), 
        [
            'fecha'=>'required',
            'desde' => 'required',
            'hasta' => 'required',
            'colaborador' => 'required',
        ]);
        if ($validator->fails()) {
            $rta['cod'] = 422;
            $rta['msg'] = 'Por favor complete envie todos los datos ';
            $rta['dat'] = $validator->errors();
            return $rta;
        }else{
            return self::Disponibilidad($r->fecha,$r->desde,$r->hasta,$r->colaborador);
        }
     } catch (\Throwable $th) {
     Log::error('Error'.$th->getMessage());
     }
     return $rta;
    }
    public function Disponibilidad($fecha,$desde,$hasta,$colaborador){
        try {
            Log::info(__FILE__."/".__FUNCTION__);
            Log::info(DB::enableQueryLog());
            $existe= DB::table('eventos_articulos')
                    ->select('*')
                    ->whereRaw("
                            colaborador_id in
                            (select c.colaborador_id
                            from (
                            select colaborador_id,start::timestamp  + '1 min'::INTERVAL as rn from eventos_articulos c   
                            ) c
                            where c.rn BETWEEN  '".$fecha . ' '.$desde.':00'."' AND '".$fecha . ' '.$hasta.':00'."'
                            and c.colaborador_id =".$colaborador.")
                     ")
                        ->orWhere(function ($query) use ($fecha,$desde,$hasta,$colaborador) {
                            $query->whereRaw("
                            colaborador_id in
                            (select c.colaborador_id
                            from (
                            select colaborador_id,c.end::timestamp  - '1 min'::INTERVAL as rn from eventos_articulos c   
                            ) c
                            where c.rn BETWEEN  '".$fecha . ' '.$desde.':00'."' AND '".$fecha . ' '.$hasta.':00'."'
                            and c.colaborador_id =".$colaborador.")
                        ");
                        })
                    ->first();
                    Log::info([$fecha . ' '.$desde.':00', $fecha . ' '.$hasta.':00']);
                    if(!empty($existe)){
                        $rta['cod']=500;
                        $rta['data']='Horario No disponible';
                    }else{
                        $rta['cod']=200;
                        $rta['rta']='Horario Disponible';
                    }
                     $rta['data']=$existe;
        } catch (\Throwable $th) {
            Log::error("error".$th->getMessage());
            $rta['msg']='Error inesperado';
        }
        return $rta;
    }
    public function registrarActualizarCliente(){
    Log::info(__FUNCTION__.'/'.__FILE__); $rta['cod']=500; $rta['msg']='Error'; 
     try { 
     } catch (\Throwable $th) {
     Log::error('Error'.$th->getMessage());
     }
     return $rta;
    }
    public function reservar(Request $r){
    Log::info(__FUNCTION__.'/'.__FILE__); Log::info($r); $rta['cod']=500; $rta['msg']='Error'; 
     try { 
        $validator = Validator::make($r->all(), 
        [
            'title' => 'required',  
            'fecha'=>'required',
            'start' => 'required',
            'end' => 'required',
            'cliente' => 'required',
            'sucursal_id' => 'required',
            'articulos' => 'required',
        ]);

        if ($validator->fails()) {
            $rta['cod'] = 422;
            $rta['msg'] = 'Por favor complete todos los campos';
            $rta['dat'] = $validator->errors();
        }else{
            $cliente_create= $this->updateOrCreation($r->cliente);
           if($cliente_create['cod'] == 200){
             $dis=array();
            //consultamos la disponibilidad del servicio bonica tiene prioridad
            if(!empty($r->articulos)){
                foreach($r->articulos  as $key=> $art){
                    $dis[$key]= self::Disponibilidad($r->fecha,$art['start'],$art['end'],$art['colaborador_id'])['cod'];
                    Log::info($dis);
                }
            }else{
                $rta['cod'] = 422;
                $rta['msg'] = 'Por favor necesita registrar por lo menos un servicio';
                return $rta;
            }
            if (in_array("500", $dis)) {
                $rta['cod'] = 500;
                $rta['msg'] = 'Horario no disponible';
                return $rta;
            }
                
            $entidad=Sucursal::select('entidad_id')->where('id',$r->sucursal_id)->first();
            $start=$r->fecha . ' '.$r->start.':00';
            $end=$r->fecha . ' '.$r->end.':00';

            $data = new Evento();
            $data->title=$r->title;
            $data->sin_prefe=$r->sin_prefe;
            $data->descripcion=$r->descripcion;
            $data->fecha=$r->fecha;
            $data->start=$start; 
            $data->end=$end;
            $data->estado_id=1;
            $data->cliente_id=$cliente_create['id'];
            $data->entidad_id=$entidad->entidad_id; //por defecto bonica
            $data->sucursal_id=$r->sucursal_id;
            $data->created_by=1; //definir un usuario de creacion por el momento usuario 1
            $data->created_at=now();
            $data->save();
            if(!empty($r->articulos)){
                self::gestionarArticulos($r, $data->id);
            }
            $rta['cod'] = 200; $rta['msg'] = 'Registro exitoso!'; $rta['dat'] = $data;
            }else{
                $rta['cod'] = 500; $rta['msg'] = $cliente_create['msg']; 
            }
        }
        return $rta;
     } catch (\Throwable $th) {
     Log::error('Error'.$th->getMessage());
     }
     return $rta;
    }
    public function updateOrCreation( $r )
    {
        Log::info(__FILE__.'/'.__FUNCTION__); Log::info( $r ); $rta['cod'] = 500; $rta['msg'] = 'Error de proceso'; $rta['dat'] = null;
        try{
            Log::info($r['ruc']);
            if (($r['ruc'] == null) || ($r['name']  == null) ) {
                $rta['cod'] = 422;
                $rta['msg'] = 'Por favor complete todos los campos El Nombre y el Ruc son necesarios';
            }else{
           $id= DB::table('personas')
            ->updateOrInsert(
                ['ruc' => $r['ruc']],
                [
                'name' =>  $r['name'],
                'ruc' => $r['ruc'],
                'nombre_fantasia' => $r['nombre_fantasia'] ?? null,
                'direccion' =>$r['direccion'] ?? null,
                'telefono' =>  $r['telefono'] ?? null,
                'cumple' =>  $r['cumple'] ?? null,
                'email' => $r['email'] ?? null,
                'es_cliente' => true ,
                'es_proveedor'=>false ,
                'created_by' => 1,
                'created_at'=>now(), 
                'updated_at'=>now()
                ]
            );
            $persona=DB::table('personas')->where('ruc',$r['ruc'])->first();
            $id=$persona->id;
            $c = Cliente::firstOrCreate( ['id' => $id], ['created_at' => now(), 'created_by' => 1] );
            $rta['cod'] = 200; $rta['msg'] = 'Registro Actualizado Exitosamente'; 
            $rta['id']=$id;
            $rta['dat'] ="" ;
            // $data;
            }
        }catch(\Exception $e){
            Log::error( $e->getMessage() );   // insert query
        }


        return $rta;
    }
    private static function gestionarArticulos(Request $r, $id)
    {
        $entidad=Sucursal::select('entidad_id')->where('id',$r->sucursal_id)->first();
        foreach($r->articulos as $art){
            $art['start']=$r->fecha . ' '.$art['start'].':00';
            $art['end']=$r->fecha . ' '.$art['end'].':00';
            $ca = EventoArticulos::updateOrCreate([
                'evento_id' => $id,
                'articulo_id' => $art['id'],
                ],
                [
                'colaborador_id' => $art['colaborador_id'],
                'importe' => $art['precio_actual'],
                'entidad_id' => $entidad->entidad_id,
                'sucursal_id' => $r->sucursal_id,
                'start' => $art['start'],
                'end' => $art['end'],
                'created_by' => 1, //por el momento solo sera uno hasta que veamos el usuario correspondiente
                'updated_by' => 1  //debemos veriicar por un token la validacion del usuario
                ]
            );
        }
        return true;
    }
    public function EliminarReserva(Request $r){
        Log::info(__FUNCTION__."/".__FILE__);Log::info($r);$rta['cod'] = 500; $rta['msg'] = 'Ocurrio un error inesperado!';
        try {
            $ven=DB::table('eventos')->where('id',$r->reserva)->whereNull('venta_id')->first();
            if(!empty($ven)){
                DB::table('eventos_articulos')->where('evento_id',$r->reserva)->delete();
                DB::table('eventos')->where('id',$r->reserva)->delete();
                $rta['cod'] = 200; 
                $rta['msg'] = 'Registro Eliminado!';
            }else{
                $rta['cod'] = 500; 
                $rta['msg'] = 'La reserva ya no puede ser eliminada!';
            }
            
        } catch (\Throwable $th) {
           Log::error("Error ".$th->getMessage());
           $rta['cod'] = 500; 
        }
        return $rta;
    }
    public function consulta($query, $parametros = null){
        //retorna un array de objetos
        DB::enableQueryLog(); Log::info(__FILE__.'/'.__FUNCTION__);

        try{
            if(empty($parametros)){
                $data = DB::select( DB::raw($query));
                if(!env('APP_DEBUG')) { Log::info($query); }
            }else{
                if(!env('APP_DEBUG')) { Log::info($query); foreach($parametros as $key=>$val){ Log::info($key.'=>'.$val); }}
                $data = DB::select( DB::raw($query));
                $data = DB::select( DB::raw($query), $parametros );
            }
            $rta['cod'] = 200;
            $rta['msg'] = 'OK';
            $rta['reg'] = count($data);
            $rta['dat'] = $data;
        } catch(\Illuminate\Database\QueryException $e){
            $rta['cod'] = 500;
            $rta['msg'] = 'Ocurrio un error al realizar la consulta';
            $rta['reg'] = 0;
            $rta['dat'] = NULL;
            Log::error($rta['msg'].' => '.$e->getMessage());
        }catch(Throwable $e){
            $rta['cod'] = 500;
            $rta['msg'] = 'Ocurrio un error fatal al conectar a la base de datos';
            $rta['reg'] = 0;
            $rta['dat'] = NULL;
            Log::error($rta['msg'].' => '.$e->getMessage());
        }catch (Exception $e) {
            $rta['cod'] = 500;
            $rta['msg'] = 'Ocurrio un error al conectar a la base de datos';
            $rta['reg'] = 0;
            $rta['dat'] = NULL;
            Log::error($rta['msg'].' => '.$e->getMessage());
        }

        return $rta;
    }
    // return bcrypt('integracionBonica&BeatyCenter2024');

}
