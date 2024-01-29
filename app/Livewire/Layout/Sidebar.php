<?php

namespace App\Livewire\Layout;

use Livewire\Component;

class Sidebar extends Component
{
    public string $name = 'yatharth';

    public function render()
    {
        return view('livewire.layout.sidebar');
    }
}
