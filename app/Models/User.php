<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasPermissions;


    //reglas de validacion
    static $rules = ['name' => 'required', 'email' => 'required', 'password' => 'required'];


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'es_colaborador',
        'es_activo',
        'puntos_de_venta_id',
        'salario',
        'tipo',
        'ips'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function adminlte_image(){
        return 'https://picsum.photos/300/300';
    }


    public function adminlte_desc()
    {
        return 'Administrador';
    }

    public function adminlte_profile_url()
    {
        // return 'user/profile';
        return 'admin/navbar/change/perfil';
    }

    public function hasPermission(User $user, $permiso, $guardName = 'web')
    {
        $rta = false;
        $permisos = $user->getAllPermissions();
        foreach($permisos as $p){
            if( $permiso == $p->name ){
                $rta = true;
            }
        }
        return $rta;
    }
    public function persona()
    {
        return $this->belongsTo(Persona::class,'persona_id');
    }
    // public static function boot()
    // {
    // //    parent::boot();
    // //    static::creating(function($model)
    // //    {
    // //        $user = Auth::user();
    // //        if(!empty($user->sucursal_id)){
    // //         $depo=DB::table('depositos')->where('sucursal_id',$user->sucursal_id)->first();
    // //         $punto=DB::table('puntos_de_ventas')->where('sucursal_id',$user->sucursal_id)->first();
    // //         $model->deposito_id = $depo->id;
    // //         $model->puntos_de_venta_id = $punto->id;
            
    // //        }

    // //    });
    // //    static::updating(function($model)
    // //    {
    // //        $user = Auth::user();
    // //        if(!empty($user->sucursal_id)){
    // //         $depo=DB::table('depositos')->where('sucursal_id',$user->sucursal_id)->first();
    // //         $punto=DB::table('puntos_de_ventas')->where('sucursal_id',$user->sucursal_id)->first();
    // //         $model->deposito_id = $depo->id;
    // //         $model->puntos_de_venta_id = $punto->id;
    // //        }

    // //    });
    // }

}
