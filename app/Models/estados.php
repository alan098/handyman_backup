<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class estados extends Model
{
    use HasFactory;

    protected $table = 'estados';
    protected $fillable = [
        'name', 'color'
    ];

    // public function eve_art(){
    //     return $this->belongsToMany(Articulo::class, 'eventos_articulos', 'evento_id', 'articulo_id');
    // }
    // public function eventos_detalles()
    // {
    //     return $this->hasMany(EventoArticulos::class);
    // }
    
}
