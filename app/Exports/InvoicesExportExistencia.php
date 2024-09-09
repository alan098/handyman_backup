<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Invoice;
use App\Models\Articulo;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class InvoicesExportExistencia implements FromView
{
    public function view(): View
    {
        return view('stock.existencia.export', [
            'invoices' => 
            DB::table('st_existencia as ex')
            ->join('articulos as a','a.id','=','ex.articulo_id')
            ->join('sucursales as su','su.id','=','ex.sucursal_id')
            ->join('depositos as de','de.id','=','ex.deposito_id')
            ->whereIn('a.tipo',['producto','insumo'])
            ->selectRaw('a.name as ar_name')
            ->selectRaw('su.name as su_name')
            ->selectRaw('de.name as de_name')
             ->selectRaw('a.id as ar_id')
            ->selectRaw('ex.cantidad')
            ->orderBy('de.name')
            ->get()
        ]);
    }
}
