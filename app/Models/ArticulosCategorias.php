<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticulosCategorias extends Model
{
    use HasFactory;

    protected $table = 'articulos_categorias';
    protected $fillable = ['id', 'name', 'created_at', 'created_by'];
    static $rules = ['name' => 'required|string|max:255'];

    //ArticulosCategorias es la entidad fuerte con relacion a Articulos ya que primero debe exisitir la categoria para que pueda existir el articulo
    //Cuando la entiad es fuerte se usa hasMany => TieneMuchos, donde ArticulosCategorias tiene muchos articulos
    public function articulos(){
        return $this->hasMany(Articulo::class, 'categoria_id');
    }


}
