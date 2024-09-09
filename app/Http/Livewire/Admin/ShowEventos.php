<?php

namespace App\Http\Livewire\Admin;

use App\Models\Articulo;
use App\Models\Evento;
use App\Models\Servicio;
use App\Models\Sucursal;
use App\Models\User;
use GuzzleHttp\Psr7\Request;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use PhpParser\Node\Stmt\TryCatch;
use SebastianBergmann\Environment\Console;

class ShowEventos extends Component
{
    public $colaboradoresActivos,$even;
    public $excluidos=array();
    public $fecha;
    public $fecha_anterior;
    public $readyToload=false;
    public $open_edit=true;
    // events:"{{ url('admin/calendario/colaboradores/datos') }}"+`/${colaborador}`+`/${fecha}`,
    protected $listeners=
    [
        'rendercolaborador' => 'render',
        'abriModal' => 'edit',
        'sucursal_change' => 'CambiarSucursal',
        'desIncluir' => 'excluidos',
        'incluir' => 'incluidos',
        'recarge' => 'recargar',
    ];  
    protected $rules=[
        'fecha'=>'required|date',
    ];  
    public function mount()
    {
        $this->fill(
            [
                'fecha' => date("Y-m-d"),
                'fecha_anterior' => date("Y-m-d"),
            ]
        );
    }
    public function render()
    {
        try {
            if ($this->readyToload) {
                $colaboradores= User::where('es_colaborador',true)->get(); //todos los colaboradores
                $sucursales= Sucursal::all(); //todas las sucursales
                $colaboradoresEventos= Evento::Colaboradores($this->fecha,$this->excluidos);//sola mente los usuarios que tengan una tarea en el dia
                $colaeve = Evento::Colaboradores($this->fecha,array());
                if (!empty($colaboradoresEventos)) {
                    $this->cargarCalendarios(); 
                }
            }else{
                //primero enviamos vacios hasta que cargue el html
                $eventos=[];$colaboradoresEventos=[];$colaboradores=[];$sucursales=[];$colaeve=[];
            }
            return view('livewire.admin.show-eventos',compact(['colaboradores','sucursales','colaboradoresEventos','colaeve']));
        } catch (\Throwable $th) {
            Log::info("error".$th->getMessage());
        }
    }
    public function LoatCalendar(){
        $this->readyToload=true;
        $this->emit('cargarCol',"");
    }
    public function cargarCalendarios(){
        $activos=Evento::Colaboradores($this->fecha,$this->excluidos);
        foreach ($activos as $key ) {
            $this->emit('renderCalendar',[$key->id,$this->fecha]);
        }
        $this->emit('recargarmarcados',"");
    }
    public function edit(Evento $even){
        //obsoleto 
        $this->editEven = $even;
    }
    public function excluidos($id){
       //solo colocamos el excluido aqui para reiniciar la carga
       $this->excluidos[]= $id;

    }
    public function incluidos($id){
        //incluimos un colaborador
        foreach ($this->excluidos as $key => $value) {
            if ($value == $id) {
                unset($this->excluidos[$key]);
            }
        }
     }
    public function CambiarSucursal($id){
        Log::info($id);
        $this->cargarCalendarios();
    }
    public function recargar(){
        $fecha_anterior=$this->fecha;
        $this->fecha=$fecha_anterior;
    }
}
