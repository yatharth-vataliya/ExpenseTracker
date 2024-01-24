<div class="p-2">
    <div class="p-2 rounded">
        <div class="flex justify-center">
            <div class="font-bold">
                <p>
                    Transaction Type Index
                </p>
            </div>
        </div>
        <div class="py-2 flex justify-center">
            <form wire:submit="storeTransactionType">
                <div class="grid grid-cols-1 auto-cols-auto gap-4 w-[500px]">
                    <div>
                        <x-input-label for="transaction_type_name" value="Transaction Type Name" />
                        <x-text-input wire:model.blur="form.transaction_type_name" id="transaction_type_name"
                            class="block mt-1 w-full" type="text" name="transaction_type_name" autofocus />
                        <x-input-error :messages="$errors->get('form.transaction_type_name')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="description" value="Description" />
                        <x-text-input wire:model.blur="form.description" id="description" class="block mt-1 w-full"
                            type="text" name="description" autofocus />
                        <x-input-error :messages="$errors->get('form.description')" class="mt-2" />
                    </div>
                    <div>
                        <x-custom-button type="submit">
                            Submit
                        </x-custom-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
