<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventoArticulos extends Model
{
    use HasFactory;

    protected $table = 'eventos_articulos';
    protected $fillable = ['promo_id','combo_id','evento_id', 'entidad_id', 'sucursal_id', 'articulo_id','colaborador_id','start','end','importe','created_at','created_by'];

    public function evento()
    {
        return $this->belongsTo(evento::class);
    }
}
