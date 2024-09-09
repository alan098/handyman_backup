<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Combo extends Model
{
    use SoftDeletes;
    use HasFactory;


    protected $table = 'articulos';
    protected $fillable = ['id', 'codigo', 'name', 'costo', 'precio', 'created_at', 'created_by', 'tipo'];
    protected $attributes = ['tipo' => 'combo'];  //default value 4 tipo

    static $rules = [
        'name' => 'required|string|max:255',
        'costo' => 'required|numeric',
        'precio' => 'required|numeric',
    ];

    public static function conEntidad(){
        return DB::table('articulos as a')
                ->leftJoin('entidades as e', 'e.id', '=', 'a.entidad_id')
                ->select('a.id', 'a.codigo', 'a.name', 'a.precio', 'a.costo', 'a.categoria_id', 'a.iva')
                ->selectRaw(" ( case when a.activo then 'SI' else 'NO' end) as activo  ")
                ->where('a.tipo', '=', 'combo')
                ->whereNull('a.deleted_at')
                ->get();
    }
    public function comboArticulos()
    {
        return $this->hasMany(ComboArticulos::class);
    }


}
