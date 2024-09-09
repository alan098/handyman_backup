<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recordatorios extends Model
{
    use HasFactory;
    protected $table = 'recordatorios';
    protected $fillable = [
        'id',
        'name',
        'mensaje',
        'articulo_id',
        'visto',
        'perioridad',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
    ];

    static $rules = [
        'name'=>'required',
        'perioridad'=>'required',
        'mensaje'=>'required',
        'articulo_id'=>'required',
    ];
}
