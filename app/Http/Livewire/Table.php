<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $searchbar = "";

    public $showAddTagModal = false;

    public function render()
    {
        return view('livewire.table', [
            //'users' => User::paginate(10),
            //"users" => User::where("name", $this->searchbar)->paginate(10),
            "users" => User::where('name', 'like', "%" . $this->searchbar . "%")->paginate(10),
        ]);
    }

    public function addTag(){
        $this->showAddTagModal = true;
    }
}
