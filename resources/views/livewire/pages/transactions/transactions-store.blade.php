<div class="p-4 rounded-md">
    <div class="w-full p-4 flex justify-center sticky top-0 backdrop-blur-xs">
        <x-custom-button wire:click="addFields">
            Add transaction
        </x-custom-button>
    </div>
    <form wire:submit="submit">
        @if (count($formFields) > 0)
            @foreach ($formFields as $key => $field)
                <div wire:key="{{ $key }}" class="grid py-2 gap-2 sm:grid-cols-3 md:grid-cols-5 xl:grid-cols-8">
                    <div>
                        <x-input-label for="transaction_type_id_{{ $key }}" value="Transaction Type" />
                        <x-custom-select wire:model="formFields.{{ $key }}.transaction_type_id"
                            id="transaction_type_id_{{ $key }}" value-field="id"
                            text-field="transaction_type_name" :options-data="$transactionTypes" required />
                        <x-input-error :messages="$errors->get('formFields.' . $key . '.transaction_type_id')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="description_{{ $key }}" value="Description" />
                        <x-text-input type="text" id="description_{{ $key }}"
                            wire:model="formFields.{{ $key }}.description" placeholder="Description" />
                        <x-input-error :messages="$errors->get('formFields.' . $key . '.description')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="item_unit_{{ $key }}" value="Item Measure Unit" />
                        <x-text-input type="text" id="item_unit_{{ $key }}"
                            wire:model="formFields.{{ $key }}.item_unit"
                            placeholder="Item Measure Unit :- Kilo, Litre etc" />
                        <x-input-error :messages="$errors->get('formFields.' . $key . '.item_unit')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="item_count_{{ $key }}" value="Quantity" />
                        <x-text-input type="number" step="0.01" id="item_count_{{ $key }}"
                            wire:model="formFields.{{ $key }}.item_count"
                            placeholder="Item Quantity eg: 1, 2, 3, ..." required />
                        <x-input-error :messages="$errors->get('formFields.' . $key . '.item_count')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="item_price_{{ $key }}" value="Price per unit" />
                        <x-text-input type="number" step="0.01" id="item_price_{{ $key }}"
                            wire:model="formFields.{{ $key }}.item_price" placeholder="Price per unit"
                            required />
                        <x-input-error :messages="$errors->get('formFields.' . $key . '.item_price')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="total_{{ $key }}" value="Total" />
                        <x-text-input type="number" step="0.01" disabled id="total_{{ $key }}"
                            x-bind:value="(($wire.formFields[{{ $key }}]?.item_count ? $wire.formFields[
                                {{ $key }}]?.item_count : 0) * ($wire.formFields[{{ $key }}]
                                ?.item_price ? $wire.formFields[{{ $key }}]?.item_price : 0)).toFixed(2)"
                            placeholder="Total" />
                    </div>
                    <div>
                        <x-input-label for="transaction_date" value="Transaction Date" />
                        <x-text-input type="date" id="transaction_date" name="transaction_date"
                            wire:model="formFields.{{ $key }}.transaction_date" placeholder="Transaction Date"
                            required />
                        <x-input-error :messages="$errors->get('formFields.' . $key . '.transaction_date')" class="mt-2" />
                    </div>
                    <div class="flex items-end">
                        <x-custom-button wire:click="removeRow({{ $key }})">
                            Remove
                        </x-custom-button>
                    </div>
                </div>
                <hr class="my-2" />
            @endforeach
        @endif
        <div>
            <x-custom-button type="submit" color="success" class="w-full sm:w-max">
                Submit
            </x-custom-button>
        </div>
    </form>
</div>
