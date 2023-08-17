<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Tag;
use Livewire\Component;
use Livewire\WithPagination;


class Tags extends Component
{
    use WithPagination;

    public $selectedUser;

    public $selectedTag;

    public $selectedUserId;

    public $showAddUserModal = false;

    public function mount() {

    }

    public function getUsersProperty()
    {
        return User::all();
    }

    public function addUserToTag($tagId): void{
        $this->showAddUserModal = true;
        $this->selectedTag = Tag::findOrFail($tagId);
    }

    public function confirmAddUser()
    {
        if(isset($this->selectedUser)){
            $this->selectedUser->tags()->attach(
                $this->selectedTag
            );
        }
        $this->showAddUserModal = false;
    }

    /* public function updateSelectedUser($userId){
        $user = User::findOrFail($userId);
        $this->selectedUser = $user;
    } */

    public function updateSelectedUser(){
        if($this->selectedUserId != ""){
            $user = User::findOrFail($this->selectedUserId);
            $this->selectedUser = $user;
        }else{
            $this->selectedUser = null;
        }
    }

    public function cancel(){
        $this->showAddUserModal = false;
    }

    public function render()
    {
        //$tags = Tag::all();

        //dd($tags->first()->users->toArray());

        return view('livewire.tags', [
            'tags' => Tag::paginate(5),
        ]);
    }
}
