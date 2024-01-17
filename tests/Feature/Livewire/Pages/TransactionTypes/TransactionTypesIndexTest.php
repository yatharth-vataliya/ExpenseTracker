<?php

use App\Livewire\Pages\TransactionTypes\TransactionTypesIndex;
use Livewire\Livewire;

it('TransactionTypesIndex renders successfully', function () {
    Livewire::test(TransactionTypesIndex::class)
        ->assertStatus(200);
});
