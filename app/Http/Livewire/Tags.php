<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Tag;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;


class Tags extends Component
{
    use WithPagination;

    public $selectedUser;

    public $selectedTag;

    public $selectedUserId;

    public $showAddUserModal = false;

    public $message = [];

    public function mount() {

    }

    public function getUsersProperty(): Collection
    {
        return User::all();
    }

    public function addUserToTag($tagId): void {
        $this->showAddUserModal = true;
        $this->selectedTag = Tag::findOrFail($tagId);
    }

    public function confirmAddUser(): void {
        if(isset($this->selectedUser)){
            $this->selectedUser->tags()->attach(
                $this->selectedTag
            );
            $this->message["success"] = "User wurde dem Tag erfolgreich hinzugefügt.";
        }
        $this->selectedUser = null;
        $this->selectedTag = null;
        $this->showAddUserModal = false;
    }

    public function updateSelectedUser(): void {
        // Hier unsicher ob man das so macht
        if($this->selectedUserId != ""){
            $user = User::findOrFail($this->selectedUserId);
            $this->selectedUser = $user;
        }else{
            $this->selectedUser = null;
        }
    }

    public function cancel(): void {
        $this->showAddUserModal = false;
    }

    public function render(): View
    {
        //$tags = Tag::all();

        //dd($tags->first()->users->toArray());

        return view('livewire.tags', [
            'tags' => Tag::paginate(5),
        ]);
    }
}
