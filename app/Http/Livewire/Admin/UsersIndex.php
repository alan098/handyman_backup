<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UsersIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;


    public function render()
    {
        $users = User::where( 'name', 'ILIKE', '%'.$this->search.'%' )
                    ->orWhere( 'email', 'ILIKE', '%'.$this->search.'%' )
                    ->paginate(5);

        return view('livewire.admin.users-index', ['users' => $users]);
    }

    public function updatingSearch(){
        $this->resetPage();
    }


}
