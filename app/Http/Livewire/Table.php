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

    public $showAddTagModal = false;

    public $selectedTagName = "Show Tags...";

    public $selectedTag;

    public $selectedUser;

    public function mount() {

    }

    public function getTagsProperty()
    {
        return Tag::all();
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

    public function addTag(){
        $this->showAddTagModal = true;
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
        $tag = Tag::find($tagId);
        if ($tag) {
            $this->selectedTag = $tag;
            $this->selectedTagName = $tag->name;
        }
    }

    // refresh lädt die Produkte aus der Datenbank neu herunter
    public function refresh(){
        $this->users = User::all();
    }
}
