<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'personas';
    static $rules = [ 'name' => 'required|string|max:255', 'ruc' => 'required|string|max:255|unique:personas,ruc'];
    protected $fillable = ['name','ruc','cumple','nombre_fantasia','direccion','telefono','email','created_at','created_by'];

    public static function getAll(  ){
        return DB::table( 'personas' )
                ->select('id', 'ruc', 'name', 'nombre_fantasia', 'direccion', 'telefono', 'email')
                ->selectRaw(" (case when es_cliente then 'SI' else 'NO' end) as es_cliente ")
                ->selectRaw(" (case when es_proveedor then 'SI' else 'NO' end) as es_proveedor ")
                ->get();
    }

}
