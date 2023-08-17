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

    public $showAddUserModal = false;

    public function mount() {

    }

    public function getUsersProperty()
    {
        return User::all();
    }

    public function addUserToTag($tagName): void{
        $this->showAddUserModal = true;
        $this->selectedTag = Tag::findOrFail($tagName);
    }

    public function confirmAddUser()
    {
        if(isset($this->selectedUser)){
            $this->selectedTag->tags()->attach(
                $this->selectedUser
            );
        }
    }

    public function updateSelectedUser($userId){
        $user = User::findOrFail($userId);
        $this->selectedUser = $user;
    }

    public function render()
    {
        //$tags = Tag::all();

        //dd($tags->first()->users->toArray());

        return view('livewire.tags', [
            'tags' => Tag::paginate(5),
            "users" => User::all(),
        ]);
    }
}
