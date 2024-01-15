<?php

use App\Livewire\Pages\Transactions\TransactionsIndex;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(TransactionsIndex::class)
        ->assertStatus(200);
});
