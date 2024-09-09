<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OpComprobante extends Model
{
    use HasFactory;
    protected $table = 'ops_comprobantes';
    protected $fillable = ['op_id', 'gasto_id', 'compra_id', 'importe', 'created_at', 'updated_at', 'created_by', 'updated_by'];
    protected $rules = ['op_id' => 'required', 'importe' => 'required'];

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
            // $model->created_by = null;
            // $model->created_at = null;
           }

       });
    }

    public function op()
    {
        return $this->belongsTo(Op::class);
    }


}
