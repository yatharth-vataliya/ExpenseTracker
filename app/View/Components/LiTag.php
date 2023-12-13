<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LiTag extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $routeName,
        public string $routeLabel
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.li-tag');
    }
}
