<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventarios_detalle extends Model
{
    use HasFactory;
    protected $table = 'inventarios_detalles';
    protected $fillable=
    [
    'inventario_id',
    'articulo_id',
    'cantidad',
    'created_by',
    'creted_at',
    'updated_by',
    'updated_at',
];
public function inventario()
{
    return $this->belongsTo(Inventario::class,'inventario_id');
}
public function articulo()
{
    return $this->belongsTo(Articulo::class);
}
}
