<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adelantos extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'fecha',
        'importe',
        'para',
        'entregado_por',
        'recibido_por',
        'fecha_recibido',
        'medio_id',
        'cuenta_id',
        'tarjeta_id',
        'documento',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];
    static $rules = [
        'name'=>'required',
        'fecha' => 'required',
        'importe'=>'required',
        'para'=>'required',
        'medio_id'=>'required',
    ];
}
