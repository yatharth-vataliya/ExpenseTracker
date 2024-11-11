<?php

namespace App\Livewire\Pages\Transactions;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;
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

    public $totalExpenses = 0;

    public function mount()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->latest('transaction_date')->get();
        $this->totalExpenses = $transactions->reduce(function ($combine, $next) {
            return $combine + $next->total;
        }, 0);

        $this->totalExpenses = Number::currency($this->totalExpenses);

        // $totalExpenses = Transaction::where('user_id', Auth::id())->sum('total'); // This calculating through database query but looks like it is taking longer than calculating in php os just making a comment here
    }

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
