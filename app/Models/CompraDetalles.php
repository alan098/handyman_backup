<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CompraDetalles extends Model
{
  
    use HasFactory;
    protected $table = 'compras_detalles';
    protected $fillable = [
        'compra_id',
        'articulo_id',
        'concepto',
        'cantidad',
        'unitario',
        'excentas',
        'gravadas_5',
        'gravadas_10',
        'created_by',
        'creted_at',
        'updated_by',
        'updated_at',
        'iva',
        'total',
        'tipoiva'
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
           }

       });
    }
    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }

}
