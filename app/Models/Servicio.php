<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use ProductoInsumo;

class Servicio extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'articulos';
    protected $fillable = ['id', 'codigo', 'categoria_id', 'name', 'costo', 'precio', 'created_at', 'created_by', 'tipo'];
    protected $attributes = ['tipo' => 'servicio'];  //default value 4 tipo

    static $rules = [
        'categoria_id' => 'required|integer',
        'name' => 'required|string|max:255',
        'precio' => 'required|numeric',
        'precio' => 'required|numeric|gt:0',
    ];
    public function insumos(){
        return $this->hasMany(ProductoInsumos::class,'articulo_id');
    }
    public static function conCategoria(){
        return DB::table('articulos as a')
                ->join('articulos_categorias as c', 'c.id', '=', 'a.categoria_id')
                ->leftJoin('entidades as e', 'e.id', '=', 'a.entidad_id')
                ->select('a.id', 'a.codigo', 'a.name', 'a.precio', 'a.costo', 'a.categoria_id', 'a.iva')
                ->selectRaw('c.name as categoria_name')
                ->selectRaw(" ( case when a.activo then 'SI' else 'NO' end) as activo  ")
                ->selectRaw('e.name as entidad_name')
                ->whereNull('a.deleted_at')
                ->where('a.tipo', '=', 'servicio')
                ->get();
    }



}
