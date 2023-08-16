<?php

namespace App\Http\Livewire;

use App\Models\Tag;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;


class Tags extends Component
{
    //use WithPagination;
    public function render()
    {
        $tags = Tag::all();

        //dd($tags->first()->users->toArray());

        return view('livewire.tags', [
            'tags' => $tags,
        ]);
    }
}
