<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;
    protected $table = 'inventarios';
    protected $fillable = [
        'id',
        'fecha',
        'name',
        'entidad_id',
        'sucural_id',
        'deposito_id',
        'tipo_movimiento',
        'es_confirmado',
        'confirmado_por',
        'confirmado_at',
        'created_by',
        'creted_at',
        'updated_by',
        'updated_at',

    ];
    static $rules = [
        'name' => 'required|string|max:255',
        'fecha' => 'required',
        'tipo_movimiento' => 'required',
        'entidad' =>'required',
        'sucursal' =>'required',
        'deposito' =>'required',
    ];
    public function detalles(){
        return $this->hasMany(Inventarios_detalle::class);
    }
    public function entidad(){
        return $this->belongsTo(Entidad::class);
    }
    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }
    public function deposito(){
        return $this->belongsTo(Deposito::class);
    }

}
