<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ShowPosts extends Component
{

    public $count;
 
    protected $listeners = ['addCart' => 'increment'];
 
    public function incrementPostCount()
    {
        $this->count = Post::count();
    }


    public function render()
    {
        return view('livewire.show-posts');
    }

}