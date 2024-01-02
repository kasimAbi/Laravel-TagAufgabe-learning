<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Tag;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $searchbar = "";

    public $selectedUser;

    public $selectedTagId;

    public $showAddTagModal = false;

    public $message = [];

    public function mount() {

    }

    public function getTagsProperty()
    {
        return Tag::all();
    }


    public function addTag($user_id): void
    {
        $this->showAddTagModal = true;
        $this->selectedUser = User::findOrFail($user_id);
    }
    
    public function confirmAddTag()
    {
        $this->selectedUser->tags()->attach(
            $this->selectedTagId
        );
        $this->message["success"] = "Tag wurde dem User erfolgreich hinzugefügt.";

        $this->selectedUser = null;
        $this->selectedTagId = null;
        $this->showAddTagModal = false;
    }

    public function cancel(){
        $this->showAddTagModal = false;
    }

    public function render()
    {

        $users = User::query()
            ->when($this->searchbar, function($query){
                return $query->where("name", "like", '%' . $this->searchbar . '%');
            });

        #dd($this->users);
        return view('livewire.table',
            [
                'users' => $users->paginate(10),
            ]
        );
    }

}
