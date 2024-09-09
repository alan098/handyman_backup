<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Invoice;
use App\Models\Articulo;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PreferencesExport implements FromView,ShouldAutoSize
{
    public $datos;

    public function __construct($r){
        $this->datos=$r;
    }
    public function view(): View
    {
        $data=DB::table('eventos')
            ->leftJoin('ventas', 'ventas.id', '=', 'eventos.venta_id') 
            ->leftJoin('personas as pe_re','pe_re.id','=','eventos.cliente_id')
            ->leftJoin('personas', 'personas.id', '=', 'ventas.cliente_id')
            ->leftJoin('users as cajero', 'cajero.id', '=', 'ventas.created_by')   
            ->select('ventas.id', 'ventas.fecha','eventos.start','eventos.end','ventas.concluido','ventas.saldo','sin_prefe')
            ->selectRaw("ventas.id as numero_venta")
            ->selectRaw("coalesce(cajero.name, 'NINGUNO') as cajeroname")
            ->selectRaw('personas.name as cliente')
            ->selectRaw('pe_re.name as cliente_reserva')
            ->selectRaw('ventas.cliente_id')
            ->whereBetween('ventas.fecha', [$this->datos->desde, $this->datos->hasta])
            ->where('ventas.anulado', '<>', true)
            ->where('ventas.concluido',true)
            ->orderBy('ventas.id')->get();
            Log::info(DB::getQueryLog());
            foreach($data as $venta){
                $venta->detalles = DB::table('ventas_detalles')
                ->join('articulos', 'articulos.id', '=', 'ventas_detalles.articulo_id')
                ->leftJoin('users as profe', 'profe.id', '=', 'ventas_detalles.colaborador_id')   
                ->select(
                    'articulos.precio',
                    'articulos.costo', 
                    'articulos.tipo', 
                    'ventas_detalles.cantidad',
                    'articulos.name'
                 )
                ->selectRaw('profe.name as profecional')
                ->where('ventas_detalles.venta_id', '=', $venta->id)
                ->get();
                  
            }
        return view('admin.reporte.preferencias.preferencias', ['invoices' => $data]);
    }
}
