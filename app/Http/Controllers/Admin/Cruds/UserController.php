<?php

namespace App\Http\Controllers\Admin\Cruds;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Entidad;
use App\Models\Persona;
use App\Models\Proveedor;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{

    public function __construct(){
        $this->middleware('can:admin.users.index')->only('index');
        $this->middleware('can:admin.users.edit')->only('edit', 'update');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = User::all();
        $entidades = Entidad::all();
        $sucursales = Sucursal::all();
        return view('admin.users.index', ['users' => $users, 'entidades' => $entidades, 'sucursales' => $sucursales]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        Log::info(__FILE__.'/'.__FUNCTION__); Log::info($user);
        try {
            $comi=User::with('persona')->where('id',$user->id)->first();
            return json_encode($comi);
        } catch (\Throwable $th) {
           Log::error("errror".$th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( Request $r )
    {
        Log::info(__FILE__.'/'.__FUNCTION__); Log::info( $r ); $rta['cod'] = 500; $rta['msg'] = 'Error de proceso'; $rta['dat'] = null;
        try{

            $creamos=null;
            $creamos['cod']=200;
            $user=$r->id;
            $creamos= $this->updateOrCreation($r);
            if($creamos['cod'] != 200){
                $rta['msg']="ocurrio un error al generar la persona comuniquese con soporte y mantenimiento";
                return $rta;
            }
            $data = User::find($user);
          
            $data->name = $r->name;
            $data->email = $r->email;
            if( ! empty( $r->password ) ){ $data->password = bcrypt($r->password); }
            $data->es_colaborador = (empty($r->es_colaborador)) ? false : true;
            $data->es_activo = (empty($r->es_activo)) ? false : true;
            $data->entidad_id = $r->entidad_id;
            $data->sucursal_id = $r->sucursal_id;
            
            $data->salario=$r->salario;
            $data->tipo=$r->tipo;
            $data->ips = (empty($r->ips)) ? false : true;
           
            $pers=DB::table('personas')->select('*')->where('ruc',$r->ruc_persona)->first();
            if (isset($pers->id)) {
                $data->persona_id = $pers->id;
            }

            #campos añadido
            $data->barrio=$r->barrio;
            $data->telefono_emergencia=$r->telefono_emergencia;
            $data->sexo=$r->sexo;
            $data->clasificacion_sangre=$r->clasificacion_sangre;
            $data->tipo_sangre=$r->tipo_sangre;
            $data->color_favorito=$r->color_favorito;
            $data->comida_favorita=$r->comida_favorita;
            $data->estacion_favorita=$r->estacion_favorita;
            $data->fecha_ingreso=$r->fecha_ingreso;

            $depo=DB::table('depositos')->where('sucursal_id',$r->sucursal_id)->where('es_real',true)->first();
            $punto=DB::table('puntos_de_ventas')->where('sucursal_id',$r->sucursal_id)->first();
            $data->deposito_id = $depo->id;
            $data->puntos_de_venta_id = $punto->id;
            $data->save();
            $rta['cod'] = 200; $rta['msg'] = 'Registro Actualizado Exitosamente'; $rta['dat'] = $data;
        }catch(\Exception $e){
            Log::error( $e->getMessage() );   // insert query
        }


        return $rta;
    }

    public function datatable(){

        Log::info(__FILE__.'/'.__FUNCTION__);

        $rs = DB::table('users as u')
                ->select('u.id', 'u.name', 'u.email', 'u.es_colaborador', 'u.es_activo')
                ->selectRaw('e.id as entidad_id')
                ->selectRaw('e.name as entidad_name')
                ->selectRaw('s.id as sucursal_id')
                ->selectRaw('s.name as sucursal_name')
                ->leftJoin('entidades as e', 'e.id', '=', 'u.entidad_id')
                ->leftJoin('sucursales as s', 's.id', '=', 'u.sucursal_id');

        return datatables()->of($rs)
                ->addColumn('acciones', function ($rs) {
                    $botones = '';
                    $botones .= '<button onclick="editarListar(\''.route('admin.users.edit', ['user' => $rs->id]).'\')" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Editar"><i class="far fa-edit"></i></button>';
                    $botones .= '&nbsp;';
                    $botones .= '<a href="'.route('admin.users.showroles', ['user'=>$rs->id]).'" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Permisos"><i class="fas fa-unlock-alt"></i></a>';
                    $botones .= '&nbsp;';
                    $botones .= '<button onclick="eliminar('.$rs->id.', \' '.csrf_token().' \', \''.route('admin.users.edit', ['user' => $rs->id]).'\',  \''.route('admin.users.destroy').'\'   )" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fas fa-trash-alt"></i></button>';
                    return $botones;
                })
                ->editColumn('id', '{!!$id!!}')
                ->rawColumns(['attachment', 'acciones'])
                ->make(true);

               // ->toJson();
    }

    public function store( Request $r ){
        Log::info(__FILE__.'/'.__FUNCTION__); Log::info( $r ); $rta['cod'] = 500; $rta['msg'] = 'Error de proceso'; $rta['dat'] = null;
        // validamos los que llega        
        try{
            request()->validate( User::$rules );
            #creamos una persona para poder asignar comprobantes
            $creamos['cod']=200;
            $creamos= $this->updateOrCreation($r);
           if($creamos['cod'] != 200){
            $rta['msg']="ocurrio un error al generar la persona comuniquese con soporte y mantenimiento";
            return $rta;
           }
            $pers=DB::table('personas')->where('ruc',$r->ruc_persona)->first();

            $data = new User();
            $data->name = $r->name;
            $data->email = $r->email;
            if (isset($pers->id)) {
                $data->persona_id = $pers->id;
            }
            $data->password = bcrypt($r->password);
            $data->es_colaborador = (empty($r->es_colaborador)) ? false : true;
            $data->es_activo = (empty($r->es_activo)) ? false : true;
            $data->entidad_id = $r->entidad_id;
            $data->sucursal_id = $r->sucursal_id;
            $data->salario=$r->salario;
            $data->tipo=$r->tipo;
            $data->ips = (empty($r->ips)) ? false : true;
            #campos añadido
            $data->barrio=$r->barrio;
            $data->telefono_emergencia=$r->telefono_emergencia;
            $data->sexo=$r->sexo;
            $data->clasificacion_sangre=$r->clasificacion_sangre;
            $data->tipo_sangre=$r->tipo_sangre;
            $data->color_favorito=$r->color_favorito;
            $data->comida_favorita=$r->comida_favorita;
            $data->estacion_favorita=$r->estacion_favorita;
            $data->fecha_ingreso=$r->fecha_ingreso;

            $depo=DB::table('depositos')->where('sucursal_id',$r->sucursal_id)->where('es_real',true)->first();
            $punto=DB::table('puntos_de_ventas')->where('sucursal_id',$r->sucursal_id)->first();

            $data->deposito_id = $depo->id;
            $data->puntos_de_venta_id = $punto->id;

            $data->save();
            $rta['cod'] = 200; $rta['msg'] = 'Usuario registrado exitosamente'; $rta['dat'] = $data;
        }catch(\Exception $e){
           if( strpos($e->getMessage(),'users_email_unique')){
            $rta['cod'] = 401; $rta['msg'] = 'El Email ya existe';
           }
            Log::error( $e->getMessage() );   // insert query
        }

        return $rta;
    }
    public function updateOrCreation(  $r )
    {
        Log::info(__FILE__.'/'.__FUNCTION__); Log::info( $r ); $rta['cod'] = 500; $rta['msg'] = 'Error de proceso'; $rta['dat'] = null;
        try{
            
           $id= DB::table('personas')
            ->updateOrInsert(
                ['ruc' => $r->ruc_persona],
                [
                'name' =>  $r->name_persona,
                'ruc' => $r->ruc_persona,
                'nombre_fantasia' => $r->nombre_fantasia_persona,
                'direccion' =>$r->direccion_persona,
                'telefono' =>  $r->telefono_persona,
                'cumple' =>  $r->cumple_persona,
                'email' => $r->email_persona,
                'es_cliente' =>( empty( $r->es_cliente_persona ) ) ? false : true ,
                'es_proveedor'=>( empty( $r->es_proveedor_persona ) ) ? false : true ,
                'created_by' => auth()->user()->id,
                'created_at'=>now(), 
                'updated_at'=>now()
                ]
            );
            $persona= DB::table('personas')->select('*')->where('ruc',$r->ruc_persona)->first();
            $r->id=$persona->id;
            if( empty( $r->es_cliente_persona ) ){
                Cliente::destroy($r->id);
            }else{
                $c = Cliente::firstOrCreate( ['id' => $r->id], ['created_at' => now(), 'created_by' => auth()->user()->id] );
            }

            if( empty( $r->es_proveedor_persona ) ){
                Proveedor::destroy($r->id);
            }else{
                $p = Proveedor::firstOrCreate( ['id' => $r->id], ['created_at' => now(), 'created_by' => auth()->user()->id] );
            }

            $rta['cod'] = 200; $rta['msg'] = 'Registro Actualizado Exitosamente'; 
            $rta['id']=$r->id;
            $rta['dat'] ="" ;
            // $data;
        }catch(\Exception $e){
            Log::error( $e->getMessage() );   // insert query
        }


        return $rta;
    }


    public function destroy(Request $r){
        Log::info(__FILE__.'/'.__FUNCTION__); Log::info( $r ); $rta['cod'] = 500; $rta['msg'] = 'Error de proceso'; $rta['dat'] = null;

        try{
            User::destroy($r->id);
            $rta['cod'] = 200; $rta['msg'] = 'Registro Eliminado Exitosamente';
        }catch(\Exception $e){
            Log::error( $e->getMessage() );   // insert query
        }
        return $rta;
    }

    public function showRoles( User $user ){
        Log::info(__FILE__.'/'.__FUNCTION__); Log::info( $user );
        $roles = Role::all();
        return view('admin.users.roles', ['user' => $user, 'roles' => $roles]);
    }

    public function syncRoles(  Request $r, User $user ){
        Log::info(__FILE__.'/'.__FUNCTION__); Log::info( $r ); Log::info( $user );
        $user->roles()->sync($r->roles);
        return redirect()->route('admin.users.showroles', $user)->with('info', 'Permisos modificados correctamente');
    }



}
