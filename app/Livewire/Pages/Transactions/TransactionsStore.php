<?php

namespace App\Livewire\Pages\Transactions;

use App\Models\Transaction;
use App\Models\TransactionType;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Transactions Store')]
class TransactionsStore extends Component
{
    public array $formFields = [];

    public $initialFields = [
        'transaction_type_id' => '',
        'description' => '',
        'item_unit' => '',
        'item_count' => '',
        'item_price' => '',
        'transaction_date' => '',
    ];

    public function mount()
    {
        $this->addFields();
    }

    public function addFields(): void
    {
        // array_push($this->formFields, array_merge($this->initialFields, [
        //     'transaction_date' => now()
        // ]));
        $this->formFields = [
            ...$this->formFields,
            [...$this->initialFields, 'transaction_date' => now()->format('Y-m-d')],
        ];
    }

    public function submit()
    {
        $this->validate([
            'formFields.*.transaction_type_id' => 'required|integer',
            'formFields.*.description' => 'nullable|string',
            'formFields.*.item_unit' => 'nullable|string',
            'formFields.*.item_count' => 'required|numeric',
            'formFields.*.item_price' => 'required|numeric',
            'formFields.*.transaction_date' => 'required|date',
        ], [], [
            'formFields.*.transaction_type_id' => 'Transaction Type',
            'formFields.*.description' => 'Description',
            'formFields.*.item_unit' => 'Item Unit',
            'formFields.*.item_count' => 'Item Count',
            'formFields.*.item_price' => 'Item Price',
            'formFields.*.transaction_date' => 'Transaction Date',
        ]);

        $this->authorize('create', Transaction::class);

        $userId = Auth::id();
        $formFields = Arr::map($this->formFields, function ($field) use ($userId) {
            $field['user_id'] = $userId;
            $field['item_count'] *= 100;
            $field['item_price'] *= 100;

            return $field;
        });

        DB::transaction(function () use ($formFields) {
            Transaction::insert($formFields);
        }, 3);

        $this->reset();
        $this->addFields();

        $this->toaster('success', 'Transaction entry successfully created');
    }

    public function removeRow(int $index): void
    {
        array_splice($this->formFields, $index, 1);
    }

    public function render()
    {
        $transactionTypes = TransactionType::currentUserTransactionType()->get();

        return view('livewire.pages.transactions.transactions-store', [
            'transactionTypes' => $transactionTypes,
        ]);
    }
}
