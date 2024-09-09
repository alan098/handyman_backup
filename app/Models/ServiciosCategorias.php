<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiciosCategorias extends Model
{
    use HasFactory;

    protected $table = 'articulos_categorias';
    protected $fillable = ['id', 'name', 'created_at', 'created_by'];
    static $rules = ['name' => 'required|string|max:255'];

}
