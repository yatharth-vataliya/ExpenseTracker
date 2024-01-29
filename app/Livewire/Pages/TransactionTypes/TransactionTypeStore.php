<?php

namespace App\Livewire\Pages\TransactionTypes;

use App\Livewire\Forms\TransactionTypes\TransactionTypeForm;
use App\Models\TransactionType;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Transaction Types Store')]
class TransactionTypeStore extends Component
{
    public TransactionTypeForm $form;

    public function storeTransactionType(): void
    {
        $this->form->validate();

        //$data = array_merge($this->form->all(), ['user_id' => auth()->id()]);
        $data = $this->form->all() + ['user_id' => auth()->id()];

        TransactionType::create($data);

        $this->form->reset();

        $this->js("showToaster('success', 'Transaction type successfully created');");
    }

    public function render()
    {
        return view('livewire.pages.transaction-types.transaction-type-store');
    }
}
