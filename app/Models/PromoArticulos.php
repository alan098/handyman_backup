<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PromoArticulos extends Model
{
    use HasFactory;
    protected $table = 'promo_articulos';
    protected $fillable = ['promo_id', 'articulo_id','precio_actual','precio_promo', 'cantidad', 'created_by', 'updated_by'];


    public static function getProductos( $promo ){
        return DB::table('promo_articulos as p')
                ->join('articulos as a', 'a.id', '=', 'p.articulo_id')
                ->select('p.cantidad', 'a.name', 'a.costo', 'a.precio','p.precio_promo')
                ->selectRaw('p.articulo_id as id')
                ->where('p.promo_id', '=', $promo)
                ->get();
    }
    public function promociones()
    {
        return $this->belongsTo(Promo::class);
    }
    public function Articulo()
    {
        return $this->belongsTo(Articulo::class);
    }
}
