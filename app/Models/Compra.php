<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class Compra extends Model
{
   
    use HasFactory;

    protected $fillable = [
        'fecha',
        'entidad_id',
        'sucursal_id',
        'deposito_id',
        'proveedor_id',
        'condicion_id',
        'timbrado',
        'comprobante',
        'concluido',
        'created_by',
        'creted_at',
        'updated_by',
        'updated_at',
        'total',
        'excentas',
        'gravadas_5',
        'gravadas_10',
        'saldo',
        'iva'

    ];

    static $rules = [
        'fecha' => 'required',
        'proveedor_id' => 'required',
        'condicion_id' => 'required',
        'comprobante' => 'required',
    ];

    protected $casts = [
        'fecha' => 'datetime:d/m/Y',
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
            $model->entidad_id = auth()->user()->entidad_id;
            $model->sucursal_id = auth()->user()->sucursal_id;
            $model->deposito_id = auth()->user()->deposito_id;
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
    public function detalles(){
        return $this->hasMany(CompraDetalles::class);
    }

    public function proveedor(){
        return $this->belongsTo(Proveedor::class);
    }

    public function entidad(){
        return $this->belongsTo(Entidad::class);
    }

    public function condicion(){
        return $this->belongsTo(Condicion::class);
    }

    public function ops(){
        return $this->hasMany(Op::class);

    }


}
