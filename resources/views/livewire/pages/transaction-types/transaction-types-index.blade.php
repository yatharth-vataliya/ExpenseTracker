<div class="p-4 bg-white flex justify-center flex-col">
    @if (count($collections) > 0)
        <x-custom-table :collections="$collections" :columns="$columns" pagination="true" />
    @else
        <div class="flex justify-center bg-gray-200 shadow-md rounded p-2">No Data Available</div>
    @endif
</div>
