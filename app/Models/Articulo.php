<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Articulo extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'articulos';
    protected $fillable = ['id', 'codigo', 'categoria_id', 'name', 'costo', 'precio', 'created_at', 'created_by','cantidad_en_paquetes','es_vendible','tipo'];

    static $rules = [
        'categoria_id' => 'required|integer',
        'name' => 'required|string|max:255',
        'costo' => 'required|numeric',
        'precio' => 'required|numeric|gt:0',
    ];


    //insumos
    public  function insumos(){
        return $this->hasMany(ProductoInsumos::class,'articulo_id');
    }
    //relacion muchos a muchos
    public function sucursales(){
        return $this->belongsToMany(Sucursal::class, 'entidad_sucursal_articulo', 'articulo_id', 'sucursal_id');
    }

    //Articulo es la entidad debil con relacion a ArticulosCategorias ya que primero debe exisitir ArticulosCategorias para que pueda existir el Articulo
    //cuando la entidad es debil se usa belongsTo => PerteneceA, donde Articulo pertenece a un ArticulosCategorias
    public function categoria(){
        return $this->belongsTo(ArticulosCategorias::class, 'categoria_id');
    }

    public function scopeProducto( $query,  $id ){
        return $query->where('id', '=', $id)->with('categoria')->with('sucursales')->first();
    }

    public function scopeProductos($query){
        return $query->where('tipo', '=', 'producto')->with('categoria')->with('sucursales')->get();
    }
    public static function EntidadesSucursalesArticulos($articulo){
        return DB::table('entidad_sucursal_articulo as esa')
                ->select('esa.articulo_id', 'esa.sucursal_id')
                ->where('esa.articulo_id', '=', $articulo)
                ->get();
    }
    public function Existencia(){ 
        return $this->hasMany(St_existencia::class);
    }
}
