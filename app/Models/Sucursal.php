<?php

namespace App\Models;

use App\Models\Entidad as ModelsEntidad;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Entidad;
use Articulo;

class Sucursal extends Model
{
    use HasFactory;
    protected $table = 'sucursales';
    static $rules = ['name' => 'required|string|max:255|unique:sucursales,name', 'entidad_id' => 'required'];
    protected $fillable = ['name', 'entidad_id'];

    public function entidade(){
        return  $this->belongsTo( ModelsEntidad::class,'id');
    }

    public static function conEntidad(){
        return DB::table('sucursales as s')
                ->join('entidades as e', 'e.id', '=', 's.entidad_id')
                ->select('s.id', 's.name', 's.direccion', 's.telefono', 's.entidad_id')
                ->selectRaw('e.name as entidad_name')
                ->whereNull('e.deleted_at')
                ->whereNull('s.deleted_at')
                ->get();
    }

    //relacion muchos a muchos
    public function articulos(){
        return $this->belongsToMany(Articulo::class, 'entidad_sucursal_articulo', 'sucursal_id', 'articulo_id');
    }


}
