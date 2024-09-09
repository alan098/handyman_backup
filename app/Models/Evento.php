<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Evento extends Model
{
    use HasFactory;

    protected $table = 'eventos';

    static $rules =
     [
    'title' => 'required',  
    'start' => 'required', 'end' => 'required',
    'cliente_id' => 'required',
    'sucursal_id' => 'required',
    'articulos' => 'required',
    ];
    protected $fillable = [
        'title','venta_id', 'descripcion','fecha','start', 'end',
        'cliente_id','sucursal_id','entidad_id','created_at','sin_prefe','created_by',

    ];
   
    public function sucursal(){
        return  $this->belongsTo( Sucursal::class);
    }
    public function persona(){
        return $this->belongsTo(Persona::class);
    }
    public function estado(){
        return $this->belongsTo(estados::class);
    }
    public function eve_art(){
        return $this->belongsToMany(Articulo::class, 'eventos_articulos', 'evento_id', 'articulo_id');
    }
    public function eventos_detalles()
    {
        return $this->hasMany(EventoArticulos::class);
    }
    public function venta()
    {
        return $this->belongsTo(venta::class);
    }
    public static function Colaboradores($fecha,$excluidos){
        return DB::table('eventos_articulos as ev')
                ->leftJoin('eventos as e', 'e.id', '=', 'ev.evento_id')
                ->leftJoin('users as u', 'u.id', '=', 'ev.colaborador_id')
                ->select('u.id','u.name')
                ->where('u.es_colaborador',true)
                ->where('e.fecha',$fecha)
                ->whereNotIn('ev.colaborador_id',$excluidos)
                ->whereRaw("ev.id in(
                    select c.id
                    from (select c.*, row_number() over
                    (partition by c.colaborador_id order by c.id desc) as rn from eventos_articulos c 
                    where c.start BETWEEN  '".$fecha .' 00:00:01'."' AND '".$fecha .' 23:59:59'."'
                    ) c
                    where c.rn = 1)"
                 )
                // ->where('e.sucursal_id',Auth()->user()->sucursal_id)
                ->orderBy('ev.colaborador_id')
                ->whereNull('ev.deleted_at')
                ->get();
        Log::info(DB::enableQueryLog());

    }
    public static function colaboradorEvento($fecha,$colaborador){
        return DB::table('eventos_articulos as ev')
                ->leftJoin('eventos as e', 'e.id', '=', 'ev.evento_id')
                ->leftJoin('articulos as ar', 'ar.id', '=', 'ev.articulo_id')
                ->leftJoin('users as u', 'u.id', '=', 'ev.colaborador_id')
                ->leftJoin('estados as est', 'est.id', '=', 'e.estado_id')
                ->leftJoin('personas as cli', 'cli.id', '=', 'e.cliente_id')
                ->select('ev.evento_id','ev.colaborador_id','ev.start','ev.end')
                ->selectRaw(" 'Cli.: '|| cli.name || ' Imp.: '|| ar.precio ||' '|| ar.name  as title")
                ->selectRaw('ev.id as id')
                ->selectRaw("coalesce(est.color, '#0000FF') as color")
                ->selectRaw("'black' as textColor")
                ->where('u.es_colaborador',true)
                ->where('e.fecha',$fecha)
                ->where('ev.colaborador_id',$colaborador)
                // ->where('e.sucursal_id',Auth()->user()->sucursal_id)
                ->orderBy('ev.colaborador_id')
                ->whereNull('ev.deleted_at')
                ->get();

    }
    


}
