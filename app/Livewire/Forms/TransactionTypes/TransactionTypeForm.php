<?php

namespace App\Livewire\Forms\TransactionTypes;

use Livewire\Attributes\Validate;
use Livewire\Form;

class TransactionTypeForm extends Form
{
    #[Validate]
    public string $transaction_type_name = '';

    #[Validate]
    public string $description = '';

    public function rules()
    {
        return [
            'transaction_type_name' => 'required|string|unique:transaction_types,transaction_type_name',
            'description' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'transaction_type_name.required' => 'The field :attribute is required',
            'transaction_type_name.unique' => 'The field :attribute must be unique',
        ];
    }

    public function validationAttributes()
    {
        return [
            'transaction_type_name' => 'Transaction Type Name',
            'description' => 'Description',
        ];
    }
}
