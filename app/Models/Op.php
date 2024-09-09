<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Op extends Model
{
    use HasFactory;
    protected $table = 'ops';
    protected $fillable = ['fecha', 'entidad_id', 'proveedor_id', 'total', 'es_cerrado', 'es_anulado', 'comentario', 'created_at', 'updated_at', 'created_by', 'updated_by', 'gasto_id', 'compra_id'];
    protected $rules = ['fecha' => 'required', 'proveedor_id' => 'required', 'entidad_id' => 'required', 'total' => 'required'];
    protected $casts = ['fecha' => 'datetime:d/m/Y'];

    public static function boot()
    {
       parent::boot();
       static::creating(function($model)
       {
           $user = Auth::user();
           if(!empty($user->id)){
            $model->created_by = $user->id;
            $model->updated_at = null;
            $model->updated_by = null;
            $model->entidad_id = auth()->user()->entidad_id;
            $model->sucursal_id = auth()->user()->sucursal_id;
           }

       });
       static::updating(function($model)
       {
           $user = Auth::user();
           if(!empty($user->id)){
            $model->updated_by = $user->id;
            $model->updated_at = Carbon::now();
            // $model->created_by = null;
            // $model->created_at = null;
           }

       });
    }

    public function compronantes(){
        return $this->hasMany(OpComprobante::class);
    }

    public function medios(){
        return $this->hasMany(OpMediosPago::class);
    }

}
