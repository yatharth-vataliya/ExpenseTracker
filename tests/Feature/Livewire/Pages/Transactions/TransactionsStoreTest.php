<?php

use App\Livewire\Pages\Transactions\TransactionsStore;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(TransactionsStore::class)
        ->assertStatus(200);
});

test('full test case implementation is pending')->todo();
