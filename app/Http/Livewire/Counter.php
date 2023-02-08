<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Cart;

class Counter extends Component
{
    public $count;

    public function mount()
    {
        $this->count = Cart::count();
    }

    public function render()
    {
        return view('livewire.counter');
    }

    public function updateCount($count)
    {
        dd("test");
        $this->count = $count;
    }
}