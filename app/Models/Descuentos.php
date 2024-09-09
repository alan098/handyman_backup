<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Descuentos extends Model
{
    use HasFactory;
    protected $table = 'descuentos_conceptos';
    protected $fillable = ['id', 'name', 'descripcion', 'es_activo', 'created_at', 'created_by'];

    static $rules = [
        'name' => 'required|string|max:255',
        'descripcion' => 'required',
        'activo' => 'required',
    ];
}
