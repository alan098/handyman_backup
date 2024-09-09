<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    protected $table = 'proveedores';
    protected $fillable = ['id', 'created_at', 'created_by'];


    public function persona(){
        return $this->belongsTo(Persona::class, 'id', 'id');
    }


}
