<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MarcaTarjeta extends Model
{
    use HasFactory;
    protected $table = 'marcas_tarjetas';


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
}
