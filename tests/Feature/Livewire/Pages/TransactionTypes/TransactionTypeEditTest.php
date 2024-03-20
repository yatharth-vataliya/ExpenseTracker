<?php

use App\Livewire\Pages\TransactionTypes\TransactionTypeEdit;
use App\Models\TransactionType;
use App\Models\User;
use Livewire\Livewire;

test('transactiontypeediturlgeneration', function () {
    $user = User::factory()->create();

    $transactionType = TransactionType::create(
        [
            'user_id' => $user->id,
            'transaction_type_name' => 'Nothing',
        ]
    );

    $route = route('transaction-types-edit', ['transactionType' => $transactionType->id]);

    expect($route === $transactionType->editUrl())->toBe(true);
});

it('renders successfully', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user);

    $transactionType = TransactionType::create(
        [
            'user_id' => $user->id,
            'transaction_type_name' => 'test 1',
            'description' => 'test description',
        ]
    );
    Livewire::test(TransactionTypeEdit::class, ['transactionType' => $transactionType->id])
        ->assertStatus(200);
});

it('can edit transaction type', function () {
    $user = User::factory()->create();
    Livewire::actingAs($user);

    $transactionType = TransactionType::create(
        [
            'user_id' => $user->id,
            'transaction_type_name' => 'test 1',
            'description' => 'test description',
        ]
    );

    $component = Livewire::test(TransactionTypeEdit::class, ['transactionType' => $transactionType->id]);

    $component->assertSet('form.transaction_type_name', $transactionType->transaction_type_name);
    $component->assertSet('form.description', $transactionType->description);

    $updatedType = [
        'transaction_type_name' => 'udpated transaction type name',
        'description' => 'updated description',
    ];

    $component->set('form.transaction_type_name', $updatedType['transaction_type_name']);
    $component->set('form.description', $updatedType['description']);

    $component->call('updateTransactionType');

    $this->assertDatabaseHas('transaction_types', [
        'transaction_type_name' => $updatedType['transaction_type_name'],
        'description' => $updatedType['description'],
    ]);
});

it('has valid error if we try to insert duplicate value which is not belong to current model in transaction_type_name while editing', function () {
    $user = User::factory()->create();
    Livewire::actingAs($user);

    $transactionType = TransactionType::factory()->create([
        'user_id' => $user->id,
    ]);

    $transactionType2 = TransactionType::factory()->create([
        'user_id' => $user->id,
    ]);

    $component = Livewire::test(TransactionTypeEdit::class, ['transactionType' => $transactionType->id]);

    $component->assertSet('form.transaction_type_name', $transactionType->transaction_type_name);
    $component->assertSet('form.description', $transactionType->description);

    $component->set('form.transaction_type_name', $transactionType2->transaction_type_name);
    $component->set('form.description', $transactionType2->description);

    $component->call('updateTransactionType')->assertHasErrors(['form.transaction_type_name' => ['unique']]);
});
