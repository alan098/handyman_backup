<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductoInsumos extends Model
{
    use HasFactory;
    protected $table = 'producto_insumos';
    protected $fillable = ['id', 'servicio_id','articulo_id', 'cantidad', 'total', 'descontar', 'created_at', 'created_by'];

    public static function getProductos( $combo ){
        return DB::table('producto_insumos as c')
                ->join('articulos as a', 'a.id', '=', 'c.articulo_id')
                ->select( 'c.cantidad','c.total','c.descontar', 'a.name')
                ->selectRaw('c.articulo_id as id')
                ->where('c.servicio_id', '=', $combo)
                ->get();
    }
}
