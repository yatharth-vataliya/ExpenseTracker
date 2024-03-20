<?php

namespace App\Livewire\Pages\Transactions;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Transactions')]
#[Layout('layouts.app')]
class TransactionsIndex extends Component
{

    public array $columns = [];
    public string $moduleName = 'Transactions';

    public function render()
    {
        return view('livewire.pages.transactions.transactions-index', [
            'collections' => []
        ]);
    }
}
