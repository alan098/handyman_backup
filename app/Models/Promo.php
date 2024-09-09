<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Promo extends Model
{
    use HasFactory;
    protected $table = 'promos';
    protected $fillable = ['id', 'name', 'costo', 'precio', 'created_at', 'created_by', 'desde', 'hasta', 'dias'];
    protected $casts = [ 'dias' => 'array' ];


    static $rules = [
        'name' => 'required|string|max:255',
        'desde' => 'required',
        'hasta' => 'required',
        'dias' => 'required',
    ];

    public static function conEntidad(){
        return DB::table('promos as p')
                ->select('p.id', 'p.name', 'p.desde', 'p.hasta', 'p.dias')
                ->selectRaw(" ( case when p.activo then 'SI' else 'NO' end) as activo  ")
                ->get();
    }
    public function sucursales(){
        return $this->belongsToMany(Sucursal::class, 'promos_entidades_sucursales', 'promo_id','sucursal_id');
    }
    public static function PromosEntidadesSucursales($promo){
        return DB::table('promos_entidades_sucursales as pes')
                ->select('pes.promo_id', 'pes.sucursal_id')
                ->where('pes.promo_id', '=', $promo)
                ->get();
    }
    public function promoArticulos()
    {
        return $this->hasMany(PromoArticulos::class);
    }

}
