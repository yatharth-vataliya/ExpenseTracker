<?php

namespace App\Livewire\Pages\TransactionTypes;

use App\Livewire\Forms\TransactionTypes\TransactionTypeForm;
use App\Models\TransactionType;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Transaction Types Store')]
class TransactionTypeStore extends Component
{
    public TransactionTypeForm $form;

    #[Locked]
    protected int $id;

    public function mount(?int $id = null)
    {
        if ($id !== null) {
            $this->id = $id;
            $model = TransactionType::find($id);
            if (!empty(($model))) {
                $this->form->fill([
                    "transaction_type_name" => $model->transaction_type_name,
                    "description" => $model->description,
                ]);
            }
        }
    }

    public function storeTransactionType(): void
    {
        $this->form->validate();

        //$data = array_merge($this->form->all(), ['user_id' => auth()->id()]);
        $data = $this->form->all() + ['user_id' => auth()->id()];

        TransactionType::create($data);

        $this->form->reset();

        //$this->js("showToaster('success', 'Transaction type successfully created');");
        $this->toaster("success", "Transaction type successfully created");
    }

    public function render()
    {
        return view('livewire.pages.transaction-types.transaction-type-store');
    }
}
