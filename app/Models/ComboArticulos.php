<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ComboArticulos extends Model
{
    use HasFactory;


    protected $table = 'combo_articulos';
    protected $fillable = ['combo_id', 'articulo_id', 'cantidad','precio_actual','precio_combo', 'created_by', 'updated_by'];


    public static function getProductos( $combo ){
        return DB::table('combo_articulos as c')
                ->join('articulos as a', 'a.id', '=', 'c.articulo_id')
                ->select( 'c.cantidad', 'a.name', 'a.costo', 'a.precio','precio_actual','precio_combo')
                ->selectRaw('c.articulo_id as id')
                ->where('c.combo_id', '=', $combo)
                ->get();
    }
    public function comboos()
    {
        return $this->belongsTo(Combo::class);
    }
    public function Articulo()
    {
        return $this->belongsTo(Articulo::class);
    }


}
