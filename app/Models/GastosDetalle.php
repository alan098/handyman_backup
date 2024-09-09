<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class GastosDetalle extends Model
{
    use HasFactory;
    protected $table = 'gastos_detalles';

    protected $fillable = [
        'gasto_id',
        'centrocosto_id',
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
            // $model->created_by = null;
            // $model->created_at = null;
           }

       });



    }


    public function gasto()
    {
        return $this->belongsTo(Gasto::class);
    }

    public function centrocosto(){
        // return $this->belongsTo(CentroCosto::class, 'centrocosto_id', 'id', 'centro_costos');
        return $this->belongsTo(CentroCosto::class);


    }

}
