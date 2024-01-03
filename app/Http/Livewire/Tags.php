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

    public $showAddTagModal = false;

    public $name = "";

    protected $rules = ["name" => "required"];

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

    public function cancel(): void {
        $this->showAddUserModal = false;
    }

    public function confirmAddUser(): void {
        if($this->selectedUserId != ""){
            $user = User::findOrFail($this->selectedUserId);
            $this->selectedUser = $user;
            $this->selectedUser->tags()->attach(
                $this->selectedTag
            );
            $this->message["success"] = "User wurde dem Tag erfolgreich hinzugefügt.";
        }else{
            $this->selectedUser = null;
        }
        $this->selectedUser = null;
        $this->selectedTag = null;
        $this->showAddUserModal = false;
    }

    public function addTag(): void {
        $this->showAddTagModal = true;
    }

    public function cancelAddTag(): void {
        $this->showAddTagModal = false;
    }

    public function confirmAddTag(): void {
        $validatedData = $this->validate();

        Tag::create($validatedData);

        $this->message["success"] = "Tag wurde der Datenbank hinzugefügt.";
        $this->name = "";
        $this->addTagName = null;
        $this->showAddTagModal = false;
    }

    public function render(): View
    {
        return view('livewire.tags', [
            'tags' => Tag::paginate(5),
        ]);
    }
}
