<?php

use App\Livewire\Pages\TransactionTypes\TransactionTypesIndex;
use App\Models\User;

it('has livewire/pages/transactiontypes/transactiontypesdelete page', function () {
    $this->actingAs(User::factory()->create());
    $response = $this->get('/transaction-types-index')->assertSeeLivewire(TransactionTypesIndex::class);

    $response->assertStatus(200);
});

// Test case for delete operation is in TransactionTypeIndexTest.php file
