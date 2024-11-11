<div class="p-4 bg-white flex justify-center flex-col">
    <div>
        <x-custom-table :collections="$collections" :columns="$columns" :moduleName="$moduleName" pagination="true" />
        <div class="font-bold w-full text-center p-4 rounded text-white bg-red-900 mt-1">
            This is Total Expense of All Time :- <span class="font-extrabold">{{ $totalExpenses }}</span>
        </div>
    </div>
</div>
