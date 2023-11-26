<?php

namespace App\Livewire\Partials;

use Livewire\Component;

class Litag extends Component
{
    public string $routeName = '';
    public string $routeLabel = '';

    public function mount(string $routeName = '', string $routeLabel = '')
    {
        $this->routeName = $routeName;
        $this->routeLabel = $routeLabel;
    }

    public function render()
    {
        return view('livewire.partials.litag');
    }
}
