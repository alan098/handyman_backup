<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Giftcard extends Model
{
    use HasFactory;
    protected $table = 'giftcard';
    protected $fillable = [
    'name',
    'cliente_id',
    'venta_detalle_origen_id',
    'importe', 
    'saldo', 
    'numero_gifcard',
    'created_by',
    'updated_by',
    'deleted_by',
    'created_by',
    'created_at',
    ];
    static $rules =
     [
        'cliente_id' => 'required',
        'venta_detalle_origen_id' => 'required',
        'importe' => 'required', 
    ];
    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }
    public function venta_detalle(){
        return $this->belongsTo(VentasDetalles::class,'venta_detalle_origen_id');
    }
}
