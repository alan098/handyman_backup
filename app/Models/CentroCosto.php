<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CentroCosto extends Model
{
    protected $table = 'centro_costos';
    use HasFactory;

    public function costodetalle(){
        return $this->belongsTo(GastosDetalle::class, 'id', 'centrocosto_id', 'gastos_detalles');

    }

}
