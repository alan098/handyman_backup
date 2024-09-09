<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ComisionServios extends Model
{
    use HasFactory;
    protected $table = 'comision_servicios';
    static $rules = ['colaborador_id' => 'required', 'servicio_id' => 'required', 'porcentaje' => 'required'];
    protected $fillable = [
        'colaborador_id', 
        'servicio_id',
        'porcentaje', 
        'created_by',
        'creted_at',
        'updated_by',
        'updated_at',
];
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
       }

   });
   static::updating(function($model)
   {
       $user = Auth::user();
       if(!empty($user->id)){
        $model->updated_by = $user->id;
        $model->updated_at = Carbon::now();
       }

   });
}
}
