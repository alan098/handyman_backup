<?php

namespace App\Models;

use App\Models\VentasDetalles as ModelsVentasDetalles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use VentasDetalles;

class Venta extends Model
{
    use HasFactory;
    protected $table = 'ventas';
    protected $fillable = [
        'fecha'
        ,'entidad_id'
        ,'deposito_id'
        ,'condicion_id'
        ,'sucursal_id'
        ,'evento_id'
        ,'importe'
        ,'total'
        ,'cliente_id'
        ,'saldo'
        ,'iva'
        ,'descuento'
        ,'punto_de_venta_id'
        ,'anticipo'
        ,'gift_card'
        ,'created_by'
        ,'created_at'
        ,'concluido'
    ];
    static $rules =
     [
        'fecha_venta' => 'required',  
        'condicion_venta' => 'required', 
        'cliente_id' => 'required',
    ];
    public function ventaDetalles()
    {
        return $this->hasMany(ModelsVentasDetalles::class);
    }
    public function cobroDetalles()
    {
        return $this->hasMany(ventaMedioPago::class);
    }
    public function event()
    {
        return $this->hasOne(Evento::class);
    }
    public function persona()
    {
        return $this->belongsTo(Persona::class,'cliente_id');
    }
    public function usuario(){
        return $this->belongsTo(User::class,'created_by');
    }
    public static function Vcuentas(){
        //seleccionamos solo las ventas que no estan cerradas
        return DB::table('ventas as v')
        ->leftJoin('personas as cli', 'cli.id', '=', 'v.cliente_id')
        ->leftJoin('eventos as eve', 'eve.id', '=', 'v.evento_id')
        ->leftJoin('estados as es', 'es.id', '=', 'eve.estado_id')
        ->select('v.*','eve.start','eve.end','es.name as estado','v.concluido','v.fecha','v.cliente_id')
        ->selectRaw('cli.name as cliente')
        ->selectRaw('cli.id as cliente_id')
        ->selectRaw(' \'l\' as numero_factura')
        ->get();
    }
    public static function ResumenCuentas(){
        return 
        DB::table('ventas as v')
        ->leftJoin('eventos as eve', 'eve.id', '=', 'v.evento_id')
        ->select('v.fecha','eve.estado_id')
        ->selectRaw(' \'0\' as cobrado')
        ->selectRaw(' \'0\' as descuentos')
        ->selectRaw(' \'0\' as facturados')
        ->selectRaw(' \'0\' as cerrados')
        ->selectRaw(' \'0\' as pendientes')
        ->selectRaw('sum(total) as cuentas')
        ->groupBy('v.fecha','eve.estado_id')
        ->get();
    }

}
