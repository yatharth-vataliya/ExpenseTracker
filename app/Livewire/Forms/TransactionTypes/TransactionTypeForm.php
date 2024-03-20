<?php

namespace App\Livewire\Forms\TransactionTypes;

use App\Models\TransactionType;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class TransactionTypeForm extends Form
{
    public ?TransactionType $transactionType = null;

    #[Validate]
    public string $transaction_type_name = '';

    #[Validate]
    public string $description = '';

    public function setTransactionType(TransactionType $transactionType): void
    {
        $this->transactionType = $transactionType;
        $this->fill([
            'transaction_type_name' => $transactionType->transaction_type_name,
            'description' => $transactionType->description,
        ]);
    }

    public function storeTransactionType(): void
    {

        $this->validate();
        //$data = array_merge($this->form->all(), ['user_id' => auth()->id()]);
        $data = $this->only(['transaction_type_name', 'description']) + ['user_id' => auth()->id()];

        TransactionType::create($data);
    }

    public function updateTransactionType(): void
    {
        $this->validate();
        $this->transactionType->update($this->only(
            ['transaction_type_name', 'description']
        ));
    }

    public function rules()
    {
        $rule = function () {
            if (!empty($this->transactionType?->id)) {
                return Rule::unique('transaction_types', 'transaction_type_name')->where(fn (Builder $query) => $query->where('user_id', '=', auth()->id()))->ignore($this->transactionType->id);
            }

            return Rule::unique('transaction_types', 'transaction_type_name')->where(fn (Builder $query) => $query->where('user_id', '=', auth()->id()));
        };

        return [
            'transaction_type_name' => [
                'required', 'string', $rule(),
            ],
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
