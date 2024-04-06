<?php

use App\Livewire\Pages\Transactions\TransactionsStore;
use App\Models\TransactionType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(TransactionsStore::class)
        ->assertStatus(200);
});

test('Transaction store test with valid data', function () {
    $user = User::factory()->create();
    Livewire::actingAs($user);

    $component = Livewire::test(TransactionsStore::class);

    $component->assertViewHas('formFields', function ($fields) {
        return count($fields) === 1;
    });

    $component->call('addFields');
    $component->call('addFields');

    $component->assertViewHas('formFields', function ($fields) {
        return count($fields) === 3;
    });

    $transactionTypes = TransactionType::factory(3)->state(new Sequence(
        ['transaction_type_name' => 'Milk'],
        ['transaction_type_name' => 'Patrol'],
        ['transaction_type_name' => 'Grocery'],
    ))->create();

    $itemUnits = ['litre', 'Pack', 'kg'];

    foreach ($transactionTypes as $key => $type) {
        $itemCount = random_int(1, 10);
        $itemPrice = random_int(50, 200);
        $component->set("formFields.{$key}.transaction_type_id", $type->id);
        $component->set("formFields.{$key}.description", 'Demo description');
        $component->set("formFields.{$key}.item_unit", $itemUnits[$key]);
        $component->set("formFields.{$key}.item_count", $itemCount);
        $component->set("formFields.{$key}.item_price", $itemPrice);
        $component->set("formFields.{$key}.transaction_date", now()->format('Y-m-d'));

        $component->assertSet("formFields.{$key}.transaction_type_id", $type->id);
        $component->assertSet("formFields.{$key}.description", 'Demo description');
        $component->assertSet("formFields.{$key}.item_unit", $itemUnits[$key]);
        $component->assertSet("formFields.{$key}.item_count", $itemCount);
        $component->assertSet("formFields.{$key}.item_price", $itemPrice);
        $component->assertSet("formFields.{$key}.transaction_date", now()->format('Y-m-d'));
    }

    $component->call('submit');

    $this->assertDatabaseCount('transaction_types', 3);

    $this->assertDatabaseCount('transactions', 3);
});

it('Transactions store with invalid data', function () {
    $user = User::factory()->create();
    Livewire::actingAs($user);

    $component = Livewire::test(TransactionsStore::class);

    $component->assertViewHas('formFields', function ($fields) {
        return count($fields) === 1;
    });

    $component->call('addFields');
    $component->call('addFields');

    $component->assertViewHas('formFields', function ($fields) {
        return count($fields) === 3;
    });

    $component->call('submit');

    $errors = [];

    for ($i = 0; $i < 3; $i++) {
        $errors = [
            ...$errors,
            "formFields.{$i}.transaction_type_id" => ['required'],
            "formFields.{$i}.item_count" => ['required'],
            "formFields.{$i}.item_price" => ['required'],
        ];
    }

    $component->assertHasErrors($errors);
});

it('Transaction add and remove functionality', function () {

    $user = User::factory()->create();
    Livewire::actingAs($user);

    $component = Livewire::test(TransactionsStore::class);

    $component->assertViewHas('formFields', function ($fields) {
        return count($fields) === 1;
    });

    $component->call('addFields');
    $component->call('addFields');

    $component->assertViewHas('formFields', function ($fields) {
        return count($fields) === 3;
    });

    $component->call('removeRow', 1);

    $component->assertViewHas('formFields', function ($fields) {
        return count($fields) === 2;
    });

    $component->call('addFields');
    $component->call('addFields');
    $component->call('addFields');

    $component->assertViewHas('formFields', function ($fields) {
        return count($fields) === 5;
    });

    $component->call('removeRow', 3);
    $component->call('removeRow', 2);

    $component->assertViewHas('formFields', function ($fields) {
        return count($fields) === 3;
    });
});
