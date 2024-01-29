<?php

use App\Livewire\Pages\TransactionTypes\TransactionTypeStore;
use App\Models\User;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(TransactionTypeStore::class)
        ->assertStatus(200);
});

test('should store data into database with valid input', function () {
    $component = Livewire::actingAs(User::factory()->create())->test(TransactionTypeStore::class);
    $transactionTypeName = 'Patrol';
    $description = 'no description';

    $component->set('form.transaction_type_name', $transactionTypeName);
    $component->set('form.description', $description);
    $component->call('storeTransactionType');

    $this->assertDatabaseHas('transaction_types', [
        'transaction_type_name' => $transactionTypeName,
        'description' => $description,
    ]);
});

it('should give error while storing same transaction_type_name', function () {

    $component = Livewire::actingAs(User::factory()->create())->test(TransactionTypeStore::class);
    $transactionTypeName = 'Patrol';
    $description = 'no description';

    $component->set('form.transaction_type_name', $transactionTypeName);
    $component->set('form.description', $description);
    $component->call('storeTransactionType');

    $this->assertDatabaseHas('transaction_types', [
        'transaction_type_name' => $transactionTypeName,
        'description' => $description,
    ]);

    $component->set('form.transaction_type_name', $transactionTypeName);
    $component->set('form.description', $description);
    $component->call('storeTransactionType');

    $component->assertHasErrors('form.transaction_type_name');
    $component->assertHasErrors(['transaction_type_name' => ['unique']]);
});

it('should give error while storing empty transaction_type_name', function () {

    $component = Livewire::actingAs(User::factory()->create())->test(TransactionTypeStore::class);
    $description = 'no description';

    $component->set('form.description', $description);
    $component->call('storeTransactionType');

    $component->assertHasErrors('form.transaction_type_name');
    $component->assertHasErrors(['transaction_type_name' => ['required']]);
});
