<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class ShowReservas extends Component
{

    public $colaboradores;
    public $sucursales;
    public function render()
    {
        return view('livewire.admin.show-reservas');
    }



    // public function render(){ return view('livewire.admin.show-reservas')->layout('layouts.index'); }
}
