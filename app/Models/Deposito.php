<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Deposito extends Model
{
    use HasFactory;
    protected $table = 'depositos';
    static $rules = ['name' => 'required|string|max:255', 'entidad_id' => 'required', 'sucursal_id' => 'required'];
    protected $fillable = ['name', 'entidad_id'];


    public static function conEntidadSucursal(){
        return DB::table('depositos as d')
                ->join('entidades as e', 'e.id', '=', 'd.entidad_id')
                ->join('sucursales as s', 's.id', '=', 'd.entidad_id')
                ->select('d.id', 'd.name', 'd.entidad_id', 'd.sucursal_id')
                ->selectRaw('e.name as entidad_name')
                ->selectRaw('s.name as sucursal_name')
                ->whereNull('d.deleted_at')
                ->whereNull('s.deleted_at')
                ->whereNull('e.deleted_at')
                ->get();
    }



}
