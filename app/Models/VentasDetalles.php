<?php

namespace App\Models;

use App\Exports\UsersExport;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentasDetalles extends Model
{
    use HasFactory;
    protected $table = 'ventas_detalles';
    protected $fillable = [
        'venta_id'
        ,'articulo_id'	
        ,'cantidad'	
        ,'precio_unitario'	
        ,'precio_total'		
        ,'excenta'		
        ,'gravada5'		
        ,'gravada10'
        ,'promo_id'
        ,'combo_id'
        ,'combinacion'	
        ,'importe_porcentaje'		
        ,'importe_descuento'	
        ,'start'
        ,'end'
        ,'afiliado_id'
        ,'porcentaje_afiliado'
        ,'porcenta_socio'
        ,'precio_original'
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
    public function Articulo()
    {
        return $this->belongsTo(Articulo::class);
    }
    public function Colaora()
    {
        return $this->belongsTo(User::class,'colaborador_id');
    }
}
