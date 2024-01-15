<?php

namespace App\Livewire\Pages\TransactionTypes;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class TransactionTypesIndex extends Component
{
    public function render()
    {
        return view('livewire.pages.transaction-types.transaction-types-index');
    }
}
