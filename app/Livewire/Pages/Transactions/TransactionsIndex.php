<?php

namespace App\Livewire\Pages\Transactions;

use App\Models\Transaction;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

#[Title('Transactions')]
#[Layout('layouts.app')]
class TransactionsIndex extends Component
{
    use WithoutUrlPagination, WithPagination;

    public array $columns = [
        'no' => [
            'header' => 'No',
        ],
        'transactionType->transaction_type_name' => 'Transaction Type',
        'description' => 'Description of Transaction',
        'item_unit' => 'Item Unit',
        'item_count' => 'Item Count',
        'item_price' => 'Item Price',
        'total' => 'Total',
        'transaction_date' => 'Transaction Date',
        // 'action' => [
        //     'header' => 'Action',
        //     //"view" => true,
        //     'edit' => false,
        //     'delete' => [
        //         'isDelete' => true,
        //         'deleteFunction' => 'deleteTransactionType',
        //         'deleteFunctionParameters' => ['id'],
        //     ],
        // ],
    ];

    public string $moduleName = 'Transactions';

    public function render()
    {
        $transactions = Transaction::with('transactionType')->latest('transaction_date')->paginate(5);

        return view('livewire.pages.transactions.transactions-index', [
            'collections' => $transactions,
        ]);
    }
}
