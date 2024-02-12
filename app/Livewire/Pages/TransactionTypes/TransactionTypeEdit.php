<?php

namespace App\Livewire\Pages\TransactionTypes;

use App\Livewire\Forms\TransactionTypes\TransactionTypeForm;
use App\Models\TransactionType;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Transaction Type Edit')]
class TransactionTypeEdit extends Component
{
    public TransactionTypeForm $form;

    public function mount(TransactionType $transactionType)
    {

        $this->authorize('view', $transactionType);
        $this->form->setTransactionType($transactionType);
    }

    public function updateTransactionType(): void
    {
        $this->authorize('update', $this->form->transactionType);
        $this->form->updateTransactionType();

        $this->toaster('success', 'Transaction type successfully Updated');
    }

    public function render()
    {
        return view('livewire.pages.transaction-types.transaction-type-edit');
    }
}
