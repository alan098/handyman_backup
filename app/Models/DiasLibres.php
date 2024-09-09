<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiasLibres extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = 'dias_libres';
    protected $fillable = [
        'user_id',
        'sucursal_id',
        'hora_inicio',
        'hora_fin',
        'dias',
    ];

    static $rules = [
        'user_id' => 'required',
        'sucursal_id' => 'required',
        'hora_inicio' => 'required',
        'hora_fin' => 'required',
        'dias' => 'required',
    ];
}
