<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagosConceptos extends Model
{
    use HasFactory;
    protected $table = 'pagos_conceptos';
    protected $fillable = ['id', 'name', 'descripcion', 'es_activo', 'created_at', 'created_by'];

    static $rules = [
        'name' => 'required|string|max:255',
        'descripcion' => 'required',
        'activo' => 'required',
    ];
}
