<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ventaMedioPago extends Model
{
    use HasFactory;
    protected $table = 'venta_medio_pago';
    protected $fillable = [
        'venta_id'
        ,'medio_cobro_id'	
        ,'documento'	
        ,'importe'	
        ,'fecha_ini_vigencia'		
        ,'fecha_fin_vigencia'		
        ,'cuenta_id'
        ,'banco_id'
        ,'tarjeta_id'		
        ,'created_at'		
        ,'updated_at'		
        ,'deleted_at'			
        ,'created_by'	
        ,'updated_by'	
        ,'deleted_by'
    ];
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
    public function medios()
    {
        return $this->belongsTo(MediosDePago::class,'medio_cobro_id');
    }
}
