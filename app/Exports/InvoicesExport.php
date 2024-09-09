<?php

namespace App\Exports;


use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromView;

class InvoicesExport implements FromView
{
    public $tipo;
    public function __construct( $tipo = 'todos' ) {
        $this->tipo = $tipo;
    }
    public function view(): View
    {
        $tipo= ['producto','insumo'];

        if ($this->tipo == 'todos') { $tipo= ['producto','insumo']; } 
        else if($this->tipo == 'producto'){$tipo= ['producto'];}
        else if($this->tipo == 'insumo'){$tipo= ['insumo'];}
        Log::info('tipo'.$this->tipo);
        log::info($tipo);
        return view('arinventarios', [
            'invoices' => 
            DB::table('articulos')
            ->whereIn('tipo',$tipo)
            ->whereNull('deleted_at')
            ->whereNull('deleted_by')
            ->where('name','<>','Gitfcard')->get()
        ]);
    }
}
