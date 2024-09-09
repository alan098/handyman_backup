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
            $parametros=''; $parms='';
            $page=1;
            $perPage = 10; // Número de resultados por página
            $offset = ($page - 1) * $perPage;
            if(isset($r->id)){
                $parametros=' where u.id ='.$r->id;
            }
            if(isset($r->page)){
                $page=$r->page;
                $offset = ($page - 1) * $perPage;
                $parms.=' LIMIT '.$perPage.' OFFSET '.$offset;
            }else{
                $parms.=' LIMIT '.$perPage.' OFFSET '.$offset;
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
            ".$parms."
            ";
            $data = $this->consulta($query);
            return response()->json($data);
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
