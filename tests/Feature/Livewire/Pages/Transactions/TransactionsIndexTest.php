<?php

use App\Livewire\Pages\Transactions\TransactionsIndex;
use Livewire\Livewire;

it('TransactionsIndex renders successfully', function () {
    Livewire::test(TransactionsIndex::class)
        ->assertStatus(200);
});
