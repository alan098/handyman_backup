<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftcarDetalle extends Model
{
    use HasFactory;
    protected $table = 'giftcard_detalles';
    protected $fillable = [
    'gifcard_id',
    'articulo_id',
    'importe',
    'updated_by',
    'deleted_by',
    'created_by',
    'created_at',
    'updated_at',
    ];
}
