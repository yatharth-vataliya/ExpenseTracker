<?php

namespace App\Livewire\Pages\Transactions;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Transactions Store')]
class TransactionsStore extends Component
{
    public function render()
    {
        return view('livewire.pages.transactions.transactions-store');
    }
}
