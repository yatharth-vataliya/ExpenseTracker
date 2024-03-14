<?php

use App\Livewire\Pages\TransactionTypes\TransactionTypesIndex;
use App\Models\TransactionType;
use App\Models\User;
use Livewire\Livewire;

it('TransactionTypesIndex renders successfully', function () {
    Livewire::test(TransactionTypesIndex::class)
        ->assertStatus(200);
});

it('can delete transaction type from TransactionTypesIndex component', function () {

    $user = User::factory()->create();
    Livewire::actingAs($user);
    $transactionTypes = TransactionType::factory(5)->create();

    $component = Livewire::test(TransactionTypesIndex::class)->assertViewHas('collections', function ($collections) use ($transactionTypes) {
        return count($collections) === count($transactionTypes);
    });

    $component->call('deleteTransactionType', $transactionTypes[0]->id);

    $this->assertSoftDeleted($transactionTypes[0]);
});

it('can not delete transaction type created by other users', function () {

    $user = User::factory()->create();
    Livewire::actingAs($user);
    $transactionTypes = TransactionType::factory(5)->create();

    $component = Livewire::test(TransactionTypesIndex::class)->assertViewHas('collections', function ($collections) use ($transactionTypes) {
        return count($collections) === count($transactionTypes);
    });

    Livewire::actingAs(User::factory()->create());

    $component->call('deleteTransactionType', $transactionTypes[0]->id)->assertForbidden();
});
