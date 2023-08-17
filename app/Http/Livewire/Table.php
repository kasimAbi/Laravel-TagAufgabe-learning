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

    public $selectedTag;

    public $selectedUser;

    public $showAddTagModal = false;

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
        /*
        $this->selectedUser->tags()->create([
            "taggable_id" => $this->selectedTag,
        ]);
        */

        //$this->selectedUser->tags();

        if(isset($this->selectedTag)){
            $this->selectedUser->tags()->attach(
                $this->selectedTag
            );
        }
    }

    public function updateSelectedTag($tagId){
        $tag = Tag::findOrFail($tagId);
        $this->selectedTag = $tag;

    }

    // refresh lädt die Produkte aus der Datenbank neu herunter
    public function refresh(){
        $this->users = User::all();
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
