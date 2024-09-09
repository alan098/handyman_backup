<?php

namespace App\Models;

use App\Models\Sucursal as ModelsSucursal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sucursal;

class Entidad extends Model
{
    use HasFactory;
    protected $table = 'entidades';
    static $rules = [ 'name' => 'required|string|max:255|unique:entidades,name'];
    protected $fillable = ['name'];

    public function sucursale(){
        return $this->hasMany( ModelsSucursal::class,'entidad_id');
    }


}
