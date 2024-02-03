<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CustomTable extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public $collections, public array $columns, public bool $pagination = false)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.custom-table');
    }
}
