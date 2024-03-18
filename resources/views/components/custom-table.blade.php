@props([
    'pagination' => false,
    'moduleName' => 'Expense Tracker Resource',
])
@if (count($collections) > 0)
    <div x-data="customDataTable" class="w-full">
        <table class="border-collapse border border-slate-400 mb-1 w-full">
            <thead class="bg-slate-50">
                <tr class="*:border *:border-slate-300 *:p-4 *:font-semibold *:text-left">
                    @foreach ($columns as $key => $column)
                        @if ($key == 'no')
                            <th>{{ $column['header'] ?? 'No' }}</th>
                        @elseif ($key !== 'action')
                            <th>{{ $column }}</th>
                        @elseif($key == 'action')
                            <th>{{ $column['header'] ?? 'Action' }}</th>
                        @endif
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @if (count($collections) > 0)
                    @foreach ($collections as $item)
                        <tr class="*:border *:border-slate-300 *:p-4 *:text-slate-500 *:hover:text-black">
                            @foreach ($columns as $key => $column)
                                @if ($key == 'no')
                                    <td>{{ 1 + $loop->parent->index }}</td>
                                @elseif ($key !== 'action')
                                    <td>{{ $item->{$key} }}</td>
                                @elseif($key == 'action')
                                    <td>
                                        @if (!empty($column['view']) && $column['view'])
                                            <a href=""
                                                class="mx-1 p-2 hover:shadow-lg bg-indigo-400 text-white rounded hover:cursor-default">
                                                View
                                            </a>
                                        @endif
                                        @if (!empty($column['edit']) && $column['edit'])
                                            <x-custom-link-button wire:navigate href="{{ $item->editUrl() }}"
                                                color="warning">
                                                Edit
                                            </x-custom-link-button>
                                        @endif
                                        @if (!empty($column['delete']) && $column['delete']['isDelete'] && $column['delete']['deleteFunction'])
                                            {{-- @php
                                            $parameters = $column['delete']['deleteFunctionParameters'];
                                            $parametersString = '';
                                            array_map(function ($param) use (&$parametersString, $item) {
                                                $paramValue = $item->{$param};
                                                if (gettype($paramValue) === 'string') {
                                                    $paramValue = "\"$paramValue\"";
                                                }
                                                $parametersString .= "{$paramValue},";
                                            }, $parameters);
                                            $parametersString = trim($parametersString, ',');
                                        @endphp --}}
                                            {{-- <button
                                            wire:click="{{ $column['delete']['deleteFunction'] }}({{ $parametersString }})"
                                            type="button"
                                            class="mx-1 p-2 hover:shadow-lg bg-green-400 text-white rounded">
                                            Delete
                                        </button> --}}
                                            <x-custom-link-button
                                                x-on:click.prevent="openConfirmationModal({{ $item->id }})"
                                                color="error">Delete
                                            </x-custom-link-button>
                                        @endif
                                    </td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>
                            No Data
                        </td>
                    </tr>
                @endif
            </tbody>
            <tfoot>
                <tr class="*:border *:border-slate-300 *:p-4 *:font-semibold *:text-left">
                    @foreach ($columns as $key => $column)
                        @if ($key == 'no')
                            <th>{{ $column['header'] ?? 'No' }}</th>
                        @elseif ($key !== 'action')
                            <th>{{ $column }}</th>
                        @elseif($key == 'action')
                            <th>{{ $column['header'] ?? 'Action' }}</th>
                        @endif
                    @endforeach
                </tr>
            </tfoot>
        </table>
        @if ($pagination === true)
            <div>
                {{ $collections->links() }}
            </div>
        @endif
        <x-confirmation-modal name="custom-data-table">
            <div class="p-4">
                <h2 class="text-lg font-medium text-gray-900">
                    Are you sure you want to delete this {{ $moduleName }}?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    This action can't be reverted so please make sure double check your decision.
                </p>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close-modal', { name: 'custom-data-table' })">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-custom-button x-bind:disabled="isLoading" x-on:click="callDeleteResource()" class="ml-3">
                        {{ $moduleName }}
                    </x-custom-button>
                </div>
            </div>
        </x-confirmation-modal>
    </div>
    @script
        @if (!empty($column['delete']))
            <script>
                Alpine.data('customDataTable', () => {
                    return {
                        isModalDeleteConfirmationModal: false,
                        resourceId: null,
                        isLoading: false,
                        openConfirmationModal(id) {
                            this.resourceId = id;
                            $wire.dispatch("open-modal", {
                                name: "custom-data-table"
                            });
                        },
                        async callDeleteResource() {
                            this.isLoading = true;
                            await $wire.call("{{ $column['delete']['deleteFunction'] }}", this.resourceId);
                            this.isLoading = false;
                            $wire.dispatch('close-modal', {
                                name: 'custom-data-table'
                            });
                            showToaster('success', '{{ $moduleName }} successfully Deleted.');
                        },
                    };
                });
            </script>
        @endif
    @endscript
@else
    <div class="flex justify-center bg-gray-200 shadow-md rounded p-2">No Data Available</div>
@endif
