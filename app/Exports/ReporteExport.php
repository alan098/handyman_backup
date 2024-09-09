<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Invoice;
use App\Models\Articulo;
use GuzzleHttp\Psr7\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReporteExport implements  WithMultipleSheets
{ 

    public $datos;

    public function __construct($r){
        $this->datos=$r;
    }
    public function sheets(): array 
    {   
        return [
            new IngresosExport($this->datos), //
            new IndividualesExport($this->datos),
            new ComisionesExport($this->datos),
            new LocalesExport($this->datos),
            new ResumenExport($this->datos),
        ];
    }
}

