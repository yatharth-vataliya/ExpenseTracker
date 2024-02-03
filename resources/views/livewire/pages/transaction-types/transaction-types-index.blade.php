<div class="p-4 bg-white flex justify-center flex-col">
    @if (count($collections) > 0)
        <x-custom-table :collections="$collections" :columns="$columns" pagination="true" />
    @endif
</div>
