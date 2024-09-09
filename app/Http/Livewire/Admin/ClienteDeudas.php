<?php

namespace App\Http\Livewire\Admin;

use App\Models\Venta;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ClienteDeudas extends Component
{
    public $venta;
    public $readyToload=false;
    protected $listeners=
    [
        'recarge' => 'render',
    ];
    public function render()
    {
        try {
            if ($this->readyToload) {
            $ventasR=Venta::select('importe','total','saldo','iva')
            ->where('id',$this->venta)
            ->get();
            }else{
                $ventasR=[];
            }
            return view('livewire.admin.cliente-deudas',compact(['ventasR']));
        } catch (\Throwable $th) {
            Log::info("error".$th->getMessage());
        }
    }
    public function LoatDetalles(){
        $this->readyToload=true;
    }
}
