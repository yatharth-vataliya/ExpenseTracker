<?php

namespace App\Livewire\Pages\TransactionTypes;

use App\Models\TransactionType;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class TransactionTypesIndex extends Component
{
    use WithoutUrlPagination, WithPagination;

    public string $moduleName = 'Trasanction Type';

    public array $columns = [
        'no' => [
            'header' => 'No',
        ],
        'transaction_type_name' => 'Transaction Type Name',
        'description' => 'Description of Transaction Type',
        'action' => [
            'header' => 'Action',
            //"view" => true,
            'edit' => true,
            'delete' => [
                'isDelete' => true,
                'deleteFunction' => 'deleteTransactionType',
                'deleteFunctionParameters' => ['id'],
            ],
        ],
    ];

    public function deleteTransactionType(int $id)
    {
        $transactionType = TransactionType::findOrFail($id);
        $this->authorize('delete', $transactionType);
        $transactionType->delete();
    }

    public function render()
    {
        return view('livewire.pages.transaction-types.transaction-types-index', [
            'collections' => TransactionType::where('user_id', auth()->id())->latest()->paginate(5),
            'pagination' => true,
        ]);
    }
}
