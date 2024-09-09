<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    use HasFactory;
    protected $table = 'bancos';
    static $rules = [
         'name' => 'required|string',
         'siglas' => 'required|string',
         'activo' => 'required|string',
        ];

    public function cuentas(){
        return $this->hasMany(CuentaBancaria::class);
    }


}
